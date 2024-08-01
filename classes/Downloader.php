<?php

class Downloader extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $this->outputType = 'none';

    $this->action = getOrDefault('action', 'downloadFile', ['downloadRecord', 'downloadFile', 'csvFile']);
    $id = getOrDefault('id', '');
    if ($id != '' && $this->action == 'downloadRecord') {
      include_once('Record.php');
      $record = new Record();
      $this->downloadContent($record->getXml($id), 'record.xml', 'application/xml');
    } else if ($this->action == 'downloadFile') {
      $filename = $this->db->fetchValue($this->db->getFilenameByRecordId($id), 'file');
      error_log('filename: ' . $filename);

      $this->outputType = 'none';
      $this->downloadFile($filename, 'application/xml');
    } else if ($this->action == 'csvFile') {
      include_once('Download.php');
      $filename = getOrDefault('file', '', Download::getAllowableFiles());
      if ($filename != '') {
        $this->outputType = 'none';
        $this->downloadCsv($filename);
      }
    }
  }

  public function getTemplate() {
    return null;
  }

  public function getAjaxTemplate() {
    return null;
  }

}