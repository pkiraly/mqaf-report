<?php

include_once 'classes/IssuesDB.php';

class Record extends BaseTab {

  public function __construct() {
    parent::__construct();
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    error_log(__FILE__ . ':' . __LINE__);

    $this->action = getOrDefault('action', 'display', ['display', 'downloadRecord', 'downloadFile']);

    $id = getOrDefault('id', '');
    $smarty->assign('id', $id);
    if ($id != '') {
      $xml = $this->getXml($id);
      if ($this->action == 'downloadRecord') {
        $this->outputType = 'none';
        $this->downloadContent($xml, 'record.xml', 'application/xml');
      } else {
        $smarty->assign('record', $xml);
        $smarty->assign('issues', $this->getIssues($id));
        $smarty->assign('filename', $this->db->fetchValue($this->db->getFilenameByRecordId($id), 'file'));
        $smarty->assign('filedata', $this->db->getFileDataByRecordId($id)->fetch(PDO::FETCH_ASSOC));
      }
    }
    if ($this->action == 'downloadFile') {
      $filename = $this->db->fetchValue($this->db->getFilenameByRecordId($id), 'file');
      error_log('filename: ' . $filename);
      $this->outputType = 'none';
      $this->downloadFile($filename, 'application/xml');
    }
  }

  public function getTemplate() {
    return 'record.tpl';
  }

  public function getAjaxTemplate() {
    return null;
  }

  public function getXml($id) {
    $db = new IssuesDB($this->outputDir, 'ddb-record.sqlite');
    return $db->getRecord($id)->fetchArray(SQLITE3_ASSOC)['xml'];
  }

  private function getIssues($id) {
    $issues = $this->db->getIssuesByRecordId($id)->fetch(PDO::FETCH_ASSOC);
    foreach ($issues as $key => $value) {
      if (preg_match('/^(.*):(.*)$/', $key, $matches)) {
        unset($issues[$key]);
        $key2 = $matches[1] == 'ruleCatalog' ? 'total' : $matches[1];
        if (!isset($issues[$key2])) {
          $issues[$key2] = [];
        }
        $issues[$key2][$matches[2]] = $value;
      }
    }
    return $issues;
  }
}