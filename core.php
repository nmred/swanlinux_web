<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */
// +---------------------------------------------------------------------------
// | SWAN [ $_SWANBR_SLOGAN_$ ]
// +---------------------------------------------------------------------------
// | Copyright $_SWANBR_COPYRIGHT_$
// +---------------------------------------------------------------------------
// | Version  $_SWANBR_VERSION_$
// +---------------------------------------------------------------------------
// | Licensed ( $_SWANBR_LICENSED_URL_$ )
// +---------------------------------------------------------------------------
// | $_SWANBR_WEB_DOMAIN_$
// +---------------------------------------------------------------------------
 

/**
+------------------------------------------------------------------------------
* 核心处理程序 全局变量
+------------------------------------------------------------------------------
*  
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$ 
+------------------------------------------------------------------------------
*/

// {{{  绝对路劲
define('PATH_SWAN_BASE', realpath(dirname(__FILE__)));
define('PATH_SWWEB_LIB', PATH_SWAN_BASE . '/lib/');

// }}}
// {{{ 参数配置
// {{{ 参数设置

// 默认时区设置
define('SWAN_TIMEZONE_DEFAULT', 'Asia/Chongqing');

// }}}

require_once PATH_SWWEB_LIB . 'sf/swanphp.php';

// 设置命名空间
require_once PATH_SF_LIB . 'loader/sw_standard_auto_loader.class.php';
$autoloader = new swan\loader\sw_standard_auto_loader(
	array(
		'namespaces' => array(
			'swan' => PATH_SF_BASE,
			'lib' => '.',
		),
));
$autoloader->register();

