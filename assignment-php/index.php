<?php

// enable apache error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

// get ReadTmp.class.php
require_once 'ReadTmp.php';

// Set if to display filesize in KBs
$fileSizeInKBs = TRUE;

// get system temp dir
$tmpDir = sys_get_temp_dir();
$tmpDir = '/var/www/html/vislog/';

$tmpDirData = new ReadTmp($tmpDir, $fileSizeInKBs);

try {
  // Process Direcoty files and folders
  $tmpDirData->getDirFiles();
  // Get processed data
  $data = $tmpDirData->getData();
  
  // no error message
  $message = NULL;
  
} catch (Exception $ex) {
  
  // on exception make an empty error
  $data = array(
	  'dir' => array(),
	  'files' => array(),
  );
  
  // get error message
  $message =  $ex->getMessage();
}


include_once 'view.php';

