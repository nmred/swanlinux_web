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
 
namespace lib\ui\action\user;
use lib\ui\action\sw_action;
use lib\markdown\sw_markdown;

/**
+------------------------------------------------------------------------------
* sw_default 
+------------------------------------------------------------------------------
* 
* @uses sw
* @uses _action
* @package 
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$ 
+------------------------------------------------------------------------------
*/
class sw_index extends sw_action
{
	// {{{ const

	/**
	 *  分页大小 
	 */
	const PAGE_SIZE = 10;

	// }}}
	// {{{ functions
	// {{{ public function action_default()

	/**
	 * action_default 
	 * 
	 * @access public
	 * @return void
	 */
	public function action_default()
	{
		$page = (int)$this->get_request()->get_query('page', 1);
		$markdown = new sw_markdown(PATH_SWWEB_DOCS_DATA);
		
		// 分页
		$flag = 1; // 有前一页和后一页
		$count = $markdown->count();
		$max_page = (int)ceil($count / self::PAGE_SIZE);
		if ($page >= $max_page) {
			$page = $max_page;
			$flag = 2; // 没有后一页	
		}

		if ($page == 1) {
			$flag = 3; // 没有前一页
		}

		$markdown->limit(self::PAGE_SIZE, (($page - 1) * self::PAGE_SIZE));
		
		$list = $markdown->get_article_list();
		foreach ($list as $key => $value) {
			$list[$key]['path'] = urlencode($value['path']);
			$list[$key]['month'] = date('m d', $value['mtime']);	
			$list[$key]['year']  = date('Y', $value['mtime']);	
		}
		
		$render['list'] = $list;
		$render['flag'] = $flag;
		$render['page'] = $page; 
		return $this->render('index.html', $render);	
	}
	
	// }}}
	// }}}	
}
