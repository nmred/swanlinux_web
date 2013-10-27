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

namespace lib\markdown\replace;
use swan\markdown\replace\sw_abstract;
use lib\markdown\exception\replace\sw_exception;
require_once PATH_SWWEB_LIB . 'geshi/geshi.php';

/**
* MarkDown 解析器
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_replace extends sw_abstract
{
	// {{{ consts
	// }}}
	// {{{ members
	// }}}
	// {{{ functions
	// {{{ public function headers_setext_callback()

	/**
	 * 解析标题回调 
	 * 
	 * @param array $matches 
	 * @access public
	 * @return string
	 */
	public function headers_setext_callback($matches)
	{
		$return = parent::headers_setext_callback($matches);

		$level = ($matches[2][0] == '=' ? 1 : 2);

		$element = $this->__markdown->get_element();
		$header = $element->get_param('header', array());
		$header[] = array('text' => $matches[1], 'level' => $level);
		$element->set_param('header', $header);
		 

		return  $return;
		
	}

	// }}}
	// {{{ public function headers_axt_callback()

	/**
	 * 解析标题回调 
	 * 
	 * @param array $matches 
	 * @access public
	 * @return string
	 */
	public function headers_axt_callback($matches)
	{
		$return = parent::headers_axt_callback($matches);

		$level = strlen($matches[1]);
		$element = $this->__markdown->get_element();
		$header = $element->get_param('header', array());
		$header[] = array('text' => $matches[2], 'level' => $level);
		$element->set_param('header', $header);

		return $return;
	}

	// }}}
	// {{{ public function code_blocks_callback()

	/**
	 * 解析代码块回调 
	 * 
	 * @param array $matches 
	 * @access public
	 * @return string
	 */
	public function code_blocks_callback($matches)
	{
		$code_block = $matches[1];
		$code_block = $this->__markdown->outdent($code_block);
	//	$code_block = htmlspecialchars($code_block, ENT_NOQUOTES);

		$code_block = preg_replace('/\A\n+|\n+\z/', '', $code_block);
		
		$code_block = preg_replace_callback('/^(\[([\w]+)\]\n|)(.*?)$/s', // {{lang:...}}greedy_code
			array($this, 'syntax_highlight'), $code_block);
		$code_block = "<code>$code_block\n</code>";
		return "\n\n" . \swan\markdown\hash\sw_hash::hash_block($code_block) . "\n\n";
	}

	// }}}
	// {{{ public function syntax_highlight()

	/**
	 * 语法高亮替换 
	 * 
	 * @param array $matches 
	 * @access public
	 * @return void
	 */
	public function syntax_highlight($matches)
	{
		$geshi = new \GeSHi($matches[3], empty($matches[2]) ? "txt" : $matches[2]);
		$geshi->enable_classes();
		$geshi->set_overall_style(""); // empty style
		return $geshi->parse_code();	
	}

	// }}}
	// }}}
}
