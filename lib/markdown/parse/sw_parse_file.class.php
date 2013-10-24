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
use lib\markdown\cache\sw_cache;
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
	 * __src_path 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $__src_path = '';

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

	/**
	 * markdown 语义替换对象 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $__replace = null;

	/**
	 * 解析后的内容 
	 * 
	 * @var string
	 * @access protected
	 */
	protected $__html = null;

	/**
	 * 设置 cache 内容 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $__cache = null;

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * __construct 
	 * 
	 * @param mixed $file_path 
	 * @access public
	 * @return void
	 */
	public function __construct($file_path)
	{
		if (!is_file($file_path)) {
			throw new sw_exception("$file_path is not exists.");
		}

		$this->__src_path = $file_path;
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
		$cache = sw_cache::get_cache_content($this->__src_path);
		$mtime = filemtime($this->__src_path);
		if (null !== $cache
			&& isset($cache['mtime']) 
			&& $cache['mtime'] >= $mtime) {
			$this->__cache = $cache;
			return isset($this->__cache['html']) ? $this->__cache['html'] : '';
		}	

		$this->__source_string = file_get_contents($this->__src_path);	
		$this->__markdown = new sw_markdown();
		$this->__markdown->set_replace($this->get_replace());

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
		$this->__html   = $this->__markdown->to_html($this->__source_string);
		$data['mtime']  = filemtime($this->__src_path);
		$data['html']   = $this->__html;
		$data['header'] = $this->get_header();

		$this->__cache = $data;
		sw_cache::set_cache_content($this->__src_path, $data);

		return $this->__html;
	}

	// }}}
	// {{{ public function get_header()

	/**
	 * get_header 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_header()
	{
		if (isset($this->__cache)) {
			return isset($this->__cache['header']) ? $this->__cache['header'] : array();	
		}

		$element = $this->__markdown->get_element();	
		return $element->get_param('header', array());
	}

	// }}}
	// {{{ public function get_title()

	/**
	 * 获取文章的标题 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_title()
	{
		$header = $this->get_header();	
		if (empty($header)) {
			return null;	
		}

		$min_level = 100;
		$title = '';
		foreach ($header as $value) {		
			if ($min_level > $value['level']) {
				$title = $value['text'];
			}
		}

		return $title;
	}

	// }}}
	// {{{ public function get_cache()

	/**
	 * 获取解析缓存 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_cache()
	{
		return $this->__cache;	
	}

	// }}}
	// {{{ public function get_description()

	/**
	 * 获取摘要信息 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_description($len = 100)
	{
		$desc_html = isset($this->__cache['html']) ? $this->__cache['html'] : $this->__html;
		$string = strip_tags($desc_html);
		$string = mb_substr($string, 0, $len, SWWEB_ENCODE);

		return $string;
	}

	// }}}
	// {{{ public function set_replace()

	/**
	 * set_replace 
	 * 
	 * @param mixed $replace 
	 * @access public
	 * @return void
	 */
	public function set_replace($replace = null)
	{
		if (!isset($replace)) {
			$replace = new \lib\markdown\replace\sw_replace($this->__markdown);	
		}

		$this->__replace = $replace;
		return $this;
	}

	// }}}
	// {{{ public function get_replace()

	/**
	 * 获取替换对象 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_replace()
	{
		if (!isset($this->__replace)) {
			$this->set_replace();	
		}

		return $this->__replace;
	}

	// }}}
	// }}}
}
