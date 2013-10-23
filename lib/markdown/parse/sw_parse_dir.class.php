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

namespace lib\markdown\parse;
use lib\markdown\parse\exception\sw_exception;

/**
* MarkDown 解析器解析目录
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_parse_dir
{
	// {{{ consts
	// }}}
	// {{{ members
	
	/**
	 * 根目录 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $__root_directory = '';

	/**
	 * 文件列表 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__file_list = array();

	// }}}
	// {{{ functions
	// {{{ public function set_root_directory()
	
	/**
	 * 设置数据的根目录 
	 * 
	 * @access public
	 * @return \lib\markdown\parse\sw_parse_dir
	 */
	public function set_root_directory($directory)
	{
		if (!is_dir($directory)) {
			throw new sw_exception("$directory is not directory.");	
		}

		$this->__root_directory = $directory;

		return $this;
	}

	// }}}
	// {{{ public function get_file_list()

	/**
	 * get_file_list 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_file_list()
	{
		$iterator = \swan\iterator\sw_fetch_dir($this->__root_directory);

		foreach($iterator as $value => $key) {
			$this->__file_list[$key] = $value;	
		}

		return $this->__file_list;
	}

	// }}}
	// }}}
}
