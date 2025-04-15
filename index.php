<?php
try {
  require 'vendor/autoload.php';
} catch(Throwable $e) {
  die("Installation incomplete: <code>composer install</code> must be run first!");
}

include_once 'common-functions.php';

$smarty = createSmarty('templates');

$tab = getOrDefault('tab', 'overview', ['overview', 'records', 'record', 'about', 'downloader', 'fair', 'download']);
$ajax = getOrDefault('ajax', 0, [0, 1]);
$languages = [
  'en' => 'en_GB.UTF-8',
  'de' => 'de_DE.UTF-8'
];
$language = getOrDefault('lang', 'de', ['en', 'de']);
setLanguage($language);

$map = [
  'overview' => 'Overview',
  'factors'  => 'Overview',
  'records'  => 'Records',
  'record'   => 'Record',
  'about'    => 'About',
  'downloader' => 'Downloader',
  'fair' => 'Fair',
  'download' => 'Download',
];

include_once('classes/Tab.php');
include_once('classes/BaseTab.php');
$class = isset($map[$tab]) ? $map[$tab] : 'Completeness';
$controller = createTab($class);
$controller->prepareData($smarty);
// include_once('classes/DdbLocale.php');
// $locale = new DdbLocale($language);

if ($ajax == 1) {
  if (!is_null($controller->getAjaxTemplate()))
    $smarty->display($controller->getAjaxTemplate());
} elseif ($controller->getOutputType() == 'html')
  $smarty->display($controller->getTemplate());

error_log('_REQUEST: ' . json_encode($_REQUEST));
error_log('_GET: ' . json_encode($_GET));
error_log('_SERVER: ' . json_encode($_SERVER));
error_log('_ENV: ' . json_encode($_ENV));
error_log('REPORT_PATH (env): ' . getenv('REPORT_PATH'));

