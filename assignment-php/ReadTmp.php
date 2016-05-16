<?php

/**
 * Read data in the tmp folders
 *
 * @author mubasharkk
 */
class ReadTmp {

  private $data;
  private $dir;
  private $fileSizeFormat;

  function __construct($dir, $fileSizeFormat = FALSE) {
	$this->data = array(
		'dir' => array(),
		'files' => array()
	);
	
	$this->fileSizeFormat = $fileSizeFormat; 

	$this->dir = $dir;
  }

  function getDirFiles() {

	$dir = scandir($this->dir, SCANDIR_SORT_ASCENDING);

	foreach ($dir as $item) {
	  if (is_dir($this->dir . '/' . $item)) {
		$this->data['dir'][] = array('dirname' => $item);
	  } else {
		$this->data['files'][] = array('filename' => $item);
	  }
	}

	foreach ($this->data['files'] as $id => $file) {
	  $this->data['files'][$id]['attr'] = $this->readFileAttr("{$this->dir}/{$file['filename']}");
	}

	foreach ($this->data['dir'] as $id => $dir) {
	  $this->data['dir'][$id]['attr'] = $this->readDirAttr("{$this->dir}/{$dir['dirname']}");
	}
	
  }

  function readFileAttr($filename) {
	
	$mtime = filemtime($filename);
	
	
	$now = time(); // or your date as well
	$datediff = $now - $mtime;
	$file_age = ceil($datediff/(60*60*24));
	
	$filesize = filesize($filename);
	$filesize = ($this->fileSizeFormat) ?  round($filesize / 1024, 3) : $filesize;
	
	return array(
		'filesize' => $filesize,
		'fileowner' => posix_getpwuid(fileowner($filename))['name'],
		'filegroup' => posix_getgrgid(filegroup($filename))['name'],
		'fileperms' => $this->getFilePerms($filename),
		'filetype' => filetype($filename),
		'last_modified' => date('Y-m-d h:i:s', $mtime),
		'file_age' => $file_age, 
	);
  }

  function getFilePerms($filename) {
	
	$perms = fileperms($filename);
		
	$info = NULL;

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
  
  function getData(){
	return $this->data;
  }
  
  function readDirAttr($dirname){
	
	$stat = stat($dirname);
	
	
	$now = time(); // or your date as well
	$datediff = $now - $stat['mtime'];
	$file_age = ceil($datediff/(60*60*24));
//	
	$dirsize = ($this->fileSizeFormat) ?  round($stat['size'] / 1024, 3) : $stat['size'];
	
	return array(
		'filesize' => $dirsize,
		'fileowner' => posix_getpwuid($stat['uid'])['name'],
		'filegroup' => posix_getgrgid($stat['gid'])['name'],
		'fileperms' => $this->getFilePerms($dirname),
		'filetype' => 'directory',
		'last_modified' => date('Y-m-d h:i:s', $stat['mtime']),
		'file_age' => $file_age, 
	);
	
  }

}
