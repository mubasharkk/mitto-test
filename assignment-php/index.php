<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once 'ReadTmp.php';

$tmpDirData = new ReadTmp();

try {
  $tmpDirData->getDirFiles();
} catch (Exception $ex) {
  echo $ex->getMessage();
}
