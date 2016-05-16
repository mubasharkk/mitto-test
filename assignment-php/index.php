<?php


// Get 'tmp' directory

$tmp_dir = sys_get_temp_dir();

$dir = scandir($tmp_dir, SCANDIR_SORT_ASCENDING);

echo "<pre>";
print_r($dir);

