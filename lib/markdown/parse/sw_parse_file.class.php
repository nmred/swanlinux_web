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
use \swan\markdown\sw_markdown;
use lib\markdown\parse\exception\sw_exception;

/**
* MarkDown 解析器解析文件
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_parse_file
{
	// {{{ consts
	// }}}
	// {{{ members

	/**
	 * 待解析的内容 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $__source_string = '';

	/**
	 * Markdown 解析引擎 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $__markdown = null;

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	public function __construct($file_path)
	{
		if (!is_file($file_path)) {
			throw new sw_exception("$file_path is not exists.")
		}
		
		$this->__source_string = file_get_contents($file_path);	
		$this->__markdown = new sw_markdown();
	}

	// }}}
	// {{{ public function parse()

	/**
	 * 解析文件 
	 * 
	 * @access public
	 * @return void
	 */
	public function parse()
	{
		return $this->_parse_contents();
	}

	// }}}
	// {{{ protected function _parse_contents()

	/**
	 * 解析文件的主体内容 
	 * 
	 * @access protected
	 * @return void
	 */
	protected function _parse_contents()
	{
		return $this->__markdown->to_html($str);
	}

	// }}}
	// }}}
}
