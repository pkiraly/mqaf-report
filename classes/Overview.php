<?php

class Overview extends BaseTab {

  private $blockers = ['Q-1.1', 'Q-4.1', 'Q-5.1', 'Q-6.1'];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $frequency = $this->db->fetchAssocList($this->db->getFrequency($this->schema, $this->provider_id, $this->set_id), 'field');
    $smarty->assign('frequency', $frequency);
    $smarty->assign('variability', $this->db->fetchAssocList($this->db->getVariablitily($this->schema, $this->provider_id, $this->set_id), 'field'));
    $count = 0;
    $total = 0;
    $not_measured = 0;
    if (isset($frequency['ruleCatalog:score'])) {
      foreach ($frequency['ruleCatalog:score'] as $record) {
        if (!is_null($record['value']) && $record['value'] != 'NA') {
          $count += $record['frequency'];
          $total += ($record['frequency'] * $record['value']);
        } else {
          $not_measured += $record['frequency'];
        }
      }
    }
    $filePath = $this->getRootFilePath('shacl4bib-stat.csv');
    error_log('filePath: ' . $filePath);
    $result = readCsv($filePath, 'id');
    $smarty->assign('result', $result);
    $smarty->assign('index', $this->indexSchema($this->schemaConfiguration));

    $smarty->assign('totalScore', ($count == 0 ? 0 : $total / $count));
    $smarty->assign('notMeasured', $not_measured);
    $smarty->assign('blockers', $this->blockers);
  }

  public function getTemplate() {
    return 'overview.tpl';
  }

  private function indexSchema($schema) {
    $index = [];
    foreach ($schema['fields'] as $field) {
      if (isset($field['rules'])) {
        $path = $field['path'];
        foreach ($field['rules'] as $rule) {
          $id = $rule['id'];
          unset($rule['id']);
          $rule['path'] = $path;
          $index[$id] = $rule;
        }
      }
    }
    return $index;
  }

  public function showArray($name, $criterium) {
    $text = $name;
    $elements = [];
    $isList = array_is_list($criterium);
    foreach ($criterium as $key => $value) {
      if (is_array($value)) {
        if ($isList)
          $elements[] = $this->showArray('', $value);
        else
          $elements[] = $this->showArray($key, $value);
      } else {
        $valueStr = is_bool($value) ? var_export($value, true) : $value;
        if ($isList)
          $elements[] = $valueStr;
        else
          $elements[] = $key . '=' . $valueStr;
      }
    }
    $elementsStr = join(', ', $elements);
    if ($isList)
      $text .= '(' . $elementsStr . ')';
    else
      $text .= $elementsStr;

    return $text;
  }

  public function queryUrl($id, $value) {
    return sprintf('?tab=data&type=custom-rule&query=%s:%s', $id, $value);
  }

  public function downloadUrl($id, $value) {
    $baseParams = [
      'tab=shacl',
      'action=download',
    ];
    // $params = array_merge($baseParams, $this->getGeneralParams());
    $params[] = sprintf('ruleId=%s', $id);
    $params[] = sprintf('value=%s', $value);
    return '?' . join('&', $params);
  }

}