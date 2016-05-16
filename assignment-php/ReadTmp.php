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

	foreach ($this->data['files'] as $id => $file) {
	  $this->data['files'][$id]['attr'] = $this->readFileAttr("{$this->tmp_dir}/{$file['filename']}");
	}

	echo "<pre>";
	print_r($this->data);
  }

  function readFileAttr($filename) {
	return array(
		'filesize' => filesize($filename),
		'fileowner' => posix_getpwuid(fileowner($filename))['name'],
		'filegroup' => posix_getgrgid(filegroup($filename))['name'],
		'fileperms' => $this->getFilePerms($filename),
		'filetype' => filetype($filename),
		'filemtime' => filemtime($filename),
	);
  }

  function getFilePerms($filename) {
	$perms = fileperms($filename);

	if (($perms & 0xC000) == 0xC000) {
	  // Socket
	  $info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	  // Symbolic Link
	  $info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	  // Regular
	  $info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	  // Block special
	  $info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	  // Directory
	  $info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	  // Character special
	  $info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	  // FIFO pipe
	  $info = 'p';
	} else {
	  // Unknown
	  $info = 'u';
	}

	// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
					(($perms & 0x0800) ? 's' : 'x' ) :
					(($perms & 0x0800) ? 'S' : '-'));

	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
					(($perms & 0x0400) ? 's' : 'x' ) :
					(($perms & 0x0400) ? 'S' : '-'));

	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
					(($perms & 0x0200) ? 't' : 'x' ) :
					(($perms & 0x0200) ? 'T' : '-'));

	return $info;
  }

}
