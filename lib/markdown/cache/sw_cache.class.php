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

namespace lib\markdown\cache;
use lib\markdown\cache\exception\sw_exception;

/**
* MarkDown 解析器 cache
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_cache
{
	// {{{ consts

	/**
	 * 缓存的是 PHP 文件 
	 */
	const SRC_PHP = 1;

	/**
	 *  缓存的是普通内容 
	 */
	const SRC_FILE = 2;

	// }}}
	// {{{ members
	// }}}
	// {{{ functions
	// {{{ public static function set_cache_content()

	/**
	 * 写入缓存 
	 * 
	 * @param string $path 
	 * @param string $data 
	 * @access public
	 * @return void
	 */
	public static function set_cache_content($path, $data, $type = self::SRC_PHP)
	{
		if (!is_file($path)) {
			throw new sw_exception("$path is not exists.");
		}
		
		if (empty($data)) {
			throw new sw_exception("cache data is not allow empty.");
		}

		$cache_file = self::get_cache_name($path, self::SRC_PHP);

		if ($type == self::SRC_PHP) {
			$data = "<?php \nreturn \n" . var_export($data, true) . ';';
		}
		return file_put_contents($cache_file, $data);
	}

	// }}}
	// {{{ public static function get_cache_content()

	/**
	 * 获取缓存内容 
	 * 
	 * @param string $path 
	 * @access public
	 * @return array
	 */
	public static function get_cache_content($path, $type = self::SRC_PHP)
	{
		$cache_file = self::get_cache_name($path, $type);
		
		if (!is_file($cache_file)) {
			return null;	
		}	

		if ($type == self::SRC_PHP) {
			return include($cache_file);
		} else {
			return file_get_contents($cache_file);	
		}
	}

	// }}}
	// {{{ public static function get_cache_name()

	/**
	 * 获取 cache 文件名 
	 * 
	 * @param string $key 
	 * @access public
	 * @return string
	 */
	public static function get_cache_name($key, $type = self::SRC_FILE)
	{
		$cache_path = \swan\sw_hash_dir::get_hash_dir($key);
		\swan\sw_hash_dir::make_hash_dir(PATH_SWWEB_MKCACHE, $cache_path);
		$cache_path = PATH_SWWEB_MKCACHE . $cache_path;
		$cache_name = md5($key);

		if (is_file($key)) {
			$cache_name .= '.' . basename($key);	
		}

		if ($type == self::SRC_PHP) {
			$cache_name .= '.php';	
		}


		return $cache_path . $cache_name;
	}

	// }}}
	// }}}
}
