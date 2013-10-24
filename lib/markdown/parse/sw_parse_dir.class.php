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

	/**
	 * 解析的文件的后缀 
	 */
	const SUBFIX_FILE = '.md';

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

	/**
	 * 忽略文件
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__ignore_file = array();

	/**
	 * 忽略目录 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__ignore_dir = array();

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
		$iterator = new \swan\iterator\sw_fetch_dir($this->__root_directory);
		$iterator->set_ignore_file($this->__ignore_file);
		$iterator->set_ignore_dir($this->__ignore_dir);

		foreach($iterator as $file_info) {
			if ($file_info->isDir() 
				|| substr($file_info->getFilename(), -(strlen(self::SUBFIX_FILE))) != self::SUBFIX_FILE) {
				continue;	
			}

			$fileinfo['name']  = $file_info->getFilename();
			$fileinfo['path']  = substr($file_info->getPathname(), strlen($this->__root_directory));
			$fileinfo['ctime'] = $file_info->getCTime();
			$this->__file_list[] = $fileinfo;
		}

		return $this->__file_list;
	}

	// }}}
	// {{{ public function set_ignore_file()

	/**
	 * 设置忽略的文件 
	 * 
	 * @param array $file 
	 * @access public
	 * @return void
	 */
	public function set_ignore_file($file)
	{
		if (is_string($file)) {
			$file = array($file);	
		}

		$this->__ignore_file = $file;

		return $this;
	}

	// }}}
	// {{{ public function set_ignore_dir()

	/**
	 * 设置忽略的目录 
	 * 
	 * @param array $directory 
	 * @access public
	 * @return void
	 */
	public function set_ignore_dir($directory)
	{
		if (is_string($directory)) {
			$directory = array($directory);	
		}

		$this->__ignore_dir = $directory;

		return $this;
	}

	// }}}
	// }}}
}
