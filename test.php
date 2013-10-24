<?php

require_once 'core.php';

use lib\markdown\sw_markdown;
use lib\markdown\parse\sw_parse_dir;

$dir = new sw_parse_dir();
$dir->set_root_directory('/usr/local/dev_swan/web/data/swan_docs');

$list = $dir->get_file_list();

var_dump($list);
