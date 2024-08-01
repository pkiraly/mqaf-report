<?php

class Download extends BaseTab {

  private static $allowableFiles = [
    'summary' => [
      'count.csv' => 'number of records',
      'frequency.csv' => 'frequency of values',
      'variability.csv' => 'variability'
    ],
    'schemas' => [
      'all-issues.csv' => 'All',
      'mets-mods.csv' => 'METS-MODS',
      'lido.csv' => 'LIDO',
      'dc.csv' => 'DDB DC',
      'marc.csv' => 'MARC21',
      'edm-ddb.csv' => 'DDB EDM'
    ]
  ];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $smarty->assign('summaryFiles', $this->getFileInfo('summary'));
    $smarty->assign('schemaFiles', $this->getFileInfo('schemas'));
  }

  public function getTemplate() {
    return 'download.tpl';
  }

  /**
   * @return string[]
   */
  public static function getAllowableFiles(): array {
    return array_merge(
      array_keys(Download::$allowableFiles['summary']),
      array_keys(Download::$allowableFiles['schemas'])
    );
  }

  private function getFileInfo($key) {
    $summary = Download::$allowableFiles[$key];
    foreach ($summary as $file => $label) {
      $summary[$file] = [
        'label' => $label,
        'size' => $this->human_filesize(filesize($this->outputDir . '/' . $file), 0)
      ];
    }
    return $summary;
  }

  private function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    $unit = @$sz[$factor];
    if ($unit != 'B')
      $unit .= 'B';
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $unit;
  }
}