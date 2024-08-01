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
    $smarty->assign('totalScore', ($count == 0 ? 0 : $total / $count));
    $smarty->assign('notMeasured', $not_measured);
    $smarty->assign('blockers', $this->blockers);
  }

  public function getTemplate() {
    return 'overview.tpl';
  }
}