<?php

Class Criterium {

  private $id;
  private $category;
  private $definition;
  private $status;
  private $score;
  private $distribution = [];
  private $mean;
  private $isBlocked = false;

  /**
   * @param $status
   * @param $score
   */
  public function __construct($id, $category, $definition, $status, $score) {
    $this->id = $id;
    $this->category = $category;
    $this->definition = $definition;
    $this->status = $status;
    $this->score = $score;
    $this->calculateStatus();
    $this->calculateScore();
  }

  private function calculateStatus() {
    if (isset($this->definition['blocker']) && $this->definition['blocker'] == true) {
      foreach ($this->status as $record) {
        if ($record['value'] == '0') {
          $this->isBlocked = true;
          $this->distribution['blocked'] = $record['frequency'];
        }
      }
    }
  }

  /**
   * @return array
   */
  public function getDistribution($color = NULL) {
    if (is_null($color)) {
      return $this->distribution;
    } elseif (isset($this->distribution[$color])) {
      $this->distribution[$color];
    } else {
      return [];
    }
  }

  public function has($color) {
    return isset($this->distribution[$color]);
  }

  public function tooltip($color, $total) {
    if ($this->has($color)) {
      $count = $this->distribution[$color];
      return sprintf("%.4f%%, %d records", $count * 100 / $total, $count);
    }
    return "";
  }

  public function percent($color, $total) {
    if ($this->has($color)) {
      return sprintf("%.0f%%", $this->distribution[$color] * 100 / $total);
    }
    return "";
  }

  /**
   * @return mixed
   */
  public function getMean()
  {
    return $this->mean;
  }

  /**
   * @return bool
   */
  public function isBlocked(): bool
  {
    return $this->isBlocked;
  }

  public function isMeasured(): bool {
    return !empty($this->distribution);
  }

  public function getClass() {
    if ($this->isBlocked())
      return 'red';
    elseif (!$this->isMeasured())
      return 'grey';
  }

  private function calculateScore() {
    $count = 0;
    $total = 0;
    foreach ($this->score as $record) {
      if (!is_null($record['value']) && $record['value'] != 'NA') {
        $count += $record['frequency'];
        $total += ($record['frequency'] * $record['value']);
        list($label, $color) = $this->getLabel((float)$record['value']);
        if ($color != '') {
          if (!isset($this->distribution[$color]))
            $this->distribution[$color] = 0;
          $this->distribution[$color] += $record['frequency'];
        }
      }
    }
    if ($this->isBlocked() && isset($this->distribution['orange'])) {
      $this->distribution['orange'] -= $this->distribution['blocked'];
      if ($this->distribution['orange'] == 0) {
        unset($this->distribution['orange']);
      }
    }
    $this->mean = ($count > 0) ? sprintf("%.2f", ($total / $count)) : '&mdash;';
  }

  public function getId() {
    return $this->id;
  }

  public function getLink($color, Fair $controller) {
    $suffix = 'score';
    $op = 'eq';
    $value = 0;
    if ($color == 'blocked') {
      $suffix = 'status';
    } else if ($color == 'orange') {
      $op = 'lt';
    } else if ($color == 'white') {
    } else if ($color == 'green') {
      $op = 'gt';
    }
    $params = [
      'tab' => 'records',
      'schema' => ($controller->getSchema() == 'NA' ? '' : $controller->getSchema()),
      'provider_id' => ($controller->getProviderId() == 'NA' ? '' : $controller->getProviderId()),
      'set_id' => ($controller->getSetId() == 'NA' ? '' : $controller->getSetId()),
      'field' => $this->id . ':' . $suffix,
      'value' => $value,
      'op' => $op,
    ];

    return '?' . http_build_query($params);
  }

  private function getLabel($score) {
    $label = '';
    $color = '';
    if ($score < 0) {
      $label = 'To be improved';
      $color = 'orange';
    } else if ($score == 0) {
      $label = 'Acceptable'; $color = 'white';
    } else if ($score > 0) {
      $label = 'Good'; $color = 'green';
    }
    return [$label, $color];
  }

}