<?php

/**
 * Read data in the tmp folders
 *
 * @author mubasharkk
 */
class ReadTmp {

  private $data;
  private $tmp_dir;

  function __construct() {
	$this->data = array(
		'dir' => array(),
		'files' => array()
	);

	$this->tmp_dir = sys_get_temp_dir();
	
	
  }

  function getDirFiles() {

	$dir = scandir($this->tmp_dir, SCANDIR_SORT_ASCENDING);

	foreach ($dir as $item) {
	  if (is_dir($this->tmp_dir . '/' . $item)) {
		$this->data['dir'][] = $item;
	  } else {
		$this->data['files'][] = array('filename' => $item);
	  }
	}
	
	foreach ($this->data['files'] as $id =>  $file){
	  $this->data['files'][$id]['attr'] = $this->readFileAttr("{$this->tmp_dir}/{$file['filename']}");
	}	
	
	echo "<pre>";
	print_r($this->data);
  }

  function readFileAttr($filename) {
	return array(
		'filesize' => intval(filesize($filename)) / 1024,
		'fileowner' => fileowner($filename),
		'filegroup' => filegroup($filename),
		'fileperms' => fileperms($filename),
		'filetype' => filetype($filename),
		'filemtime' => filemtime($filename),
	);
  }

}
