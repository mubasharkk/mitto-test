<?php

/**
 * Read data in the tmp folders
 *
 * @author mubasharkk
 */
class ReadTmp {

  // Processed Data
  private $data;
  // Directory
  private $dir;
  // FileSize to be in KBs
  private $fileSizeFormat;

  function __construct($dir, $fileSizeFormat = FALSE) {
	$this->data = array(
		'dir' => array(),
		'files' => array()
	);
	
	$this->fileSizeFormat = $fileSizeFormat; 

	$this->dir = $dir;
  }

  /**
   * Get dir processed data
   * 
   * @throws Exception
   */
  public function getDirFiles() {
	
	// check if file exists
	if(!file_exists($this->dir)){
	  throw new Exception('Folder does not exists');
	}

	// Scan directory for files (Only first level)
	$dir = scandir($this->dir, SCANDIR_SORT_ASCENDING);

	foreach ($dir as $item) {
	  
	  // check if file still exists 
	  if(!file_exists($this->dir . '/' . $item)){
		continue;
	  }
	  
	  // if item is directory
	  if (is_dir($this->dir . '/' . $item)) {
		$this->data['dir'][] = array('dirname' => $item);
	  } 
	  // or item is file
	  else {
		$this->data['files'][] = array('filename' => $item);
	  }
	}

	// Fetch file attributes
	foreach ($this->data['files'] as $id => $file) {
	  $this->data['files'][$id]['attr'] = $this->readFileAttr("{$this->dir}/{$file['filename']}");
	}

	// Fetch directory attributes
	foreach ($this->data['dir'] as $id => $dir) {
	  $this->data['dir'][$id]['attr'] = $this->readDirAttr("{$this->dir}/{$dir['dirname']}");
	}
	
  }

  /**
   * Read file required file attributes
   * 
   * @param string $filename File name with path
   * @return mixed
   */
  private function readFileAttr($filename) {
	
	// last modified time
	$mtime = filemtime($filename);
	
	
	$now = time(); // current timestamp
	$datediff = $now - $mtime; // difference of modifed time stampe
	$file_age = ceil($datediff/(60*60*24)); // calculate days 
	
	// get file size
	$filesize = filesize($filename);
	// if file size in KBs then calculate
	$filesize = ($this->fileSizeFormat) ?  round($filesize / 1024, 3) : $filesize;
	
	return array(
		'filesize' => $filesize,
		// convert file ownership id to name
		'fileowner' => posix_getpwuid(fileowner($filename))['name'],
		// convert file group id to name
		'filegroup' => posix_getgrgid(filegroup($filename))['name'],
		// get file unix permissions
		'fileperms' => $this->getFilePerms($filename),
		// file type
		'filetype' => filetype($filename),
		// last modified datetimes
		'last_modified' => date('Y-m-d h:i:s', $mtime),
		// age of file in days
		'file_age' => $file_age, 
	);
  }

  /**
   * Get file permissions in unix format
   * 
   * @param string $filename
   * @return string
   * 
   * source : http://php.net/manual/de/function.fileperms.php
   */
  private function getFilePerms($filename) {
	
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
  
  
  /**
   * Return folder information of files/dir
   * 
   * @return mixed
   */
  public function getData(){
	return $this->data;
  }
  
  /**
   * Get directory attributes
   * 
   * @param string $dirname Directory names
   * @return mixed
   */
  function readDirAttr($dirname){
	// get directory stat
	$stat = stat($dirname);
		
	$now = time(); // current time
	$datediff = $now - $stat['mtime']; // difference of time
	$file_age = ceil($datediff/(60*60*24)); // age of files in days
	
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
