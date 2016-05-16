<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once 'ReadTmp.php';

$fileSizeInKBs = TRUE;

//$tmpDir = sys_get_temp_dir();
$tmpDir = '/var/www/html/vislog/';
$tmpDirData = new ReadTmp($tmpDir, $fileSizeInKBs);

try {
  $tmpDirData->getDirFiles();
  
  $data = $tmpDirData->getData();
  
//  echo "<pre>";
//  print_r($data['dir']);
//  die;
} catch (Exception $ex) {
  echo $ex->getMessage();
}


include_once 'view.php';

