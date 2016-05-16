<?php

if(!empty($_REQUEST['code'])){
 
  $file = base64_decode($_REQUEST['code']);

  header("Content-Description: File Transfer"); 
  header("Content-Type: application/octet-stream"); 
  header("Content-Disposition: attachment; filename=\"$file\""); 

  echo file_get_contents($file); 

}

?>