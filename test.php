<?php

require_once 'core.php';

use lib\markdown\sw_markdown;

$markdown = new sw_markdown('data/swan_docs');
var_dump($markdown->get_article_list());
