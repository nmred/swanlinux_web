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

namespace lib\markdown;
use lib\markdown\parse\sw_parse_dir;
use lib\markdown\parse\sw_parse_file;

/**
* Markdown 解析器
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_markdown
{
	// {{{ const
	// }}}
	// {{{ members

	/**
	 * 解析目录对象 
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $__parse_dir = null;

	/**
	 * 所有的 md 文件描述 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__lists = array();

	/**
	 * limit 一次获取个数 
	 * 
	 * @var int
	 * @access protected
	 */
	protected $__count = null;

	/**
	 * 起始位置 
	 * 
	 * @var int
	 * @access protected
	 */
	protected $__offset = null;

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * 构造函数 
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($root_directory)
	{
		$this->__parse_dir = new sw_parse_dir();
		$this->__parse_dir->set_root_directory($root_directory);	
		$this->__lists = $this->__parse_dir->get_file_list();	
	}

	// }}}
	// {{{ public function get_article_list()

	/**
	 * 获取文章列表 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_article_list()
	{
		if ($this->__count && $this->__offset) {
			$list = array_slice($this->__lists, $this->__offset, $this->__count);	
		} else {
			$list = $this->__lists;	
		}

		$data = array();
		foreach ($list as $key => $value) {
			$fileinfo = $this->get_article_content($value['path']);
			$data[$key]['title'] = $fileinfo['title'];
			$data[$key]['desc']  = $fileinfo['desc'];
			$data[$key]['mtime'] = $fileinfo['mtime'];
			$data[$key]['path']  = $value['path'];
		}

		return $data;
	}

	// }}}
	// {{{ public function limit()

	/**
	 * limit 
	 * 
	 * @param mixed $count 
	 * @param mixed $offset 
	 * @access public
	 * @return void
	 */
	public function limit($count, $offset)
	{	
		$this->__count = $count;
		$this->__offset = $offset;

		return $this;
	}

	// }}}
	// {{{ public funciton count()

	/**
	 * count 
	 * 
	 * @access public
	 * @return void
	 */
	public function count()
	{
		return count($this->__lists);	
	}

	// }}}
	// {{{ public function get_article_content()

	/**
	 * get_article_content 
	 * 
	 * @param mixed $path 
	 * @access public
	 * @return void
	 */
	public function get_article_content($path)
	{	
		$file_parse = new sw_parse_file($path);
		$file_parse->parse();

		$data['title'] = $file_parse->get_title();
		$data['desc']  = $file_parse->get_description();
		$data = array_merge((array)$file_parse->get_cache(), $data); 

		return $data;
	}

	// }}}
	// }}}
}
