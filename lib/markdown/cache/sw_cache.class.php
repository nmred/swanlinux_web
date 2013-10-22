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
	// }}}
	// {{{ members

	/**
	 * 处理 md 文件的根目录 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $__root_directory = null;

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * __construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		if (!isset(self::$__element)) {
			self::$__element = new sw_element();	
		}
	}

	// }}}
	// {{{ public function set_root_directory()

	/**
	 * 设置根目录 
	 * 
	 * @param string $directory 
	 * @access public
	 * @return lib\markdown\cache\sw_cache
	 */
	public function set_root_directory($directory)
	{
		if (is_dir($directory)) {
			$this->__root_directory = $directory;
		} else {
			throw sw_exception("$directory is not directory.");	
		}

		return $this;
	}

	// }}}
	// {{{ public function get_file_list()

	/**
	 * 获取文件的列表 
	 * 
	 * @access public
	 * @return array
	 */
	public function get_file_list()
	{
		
	}

	// }}}
	// }}}
}
