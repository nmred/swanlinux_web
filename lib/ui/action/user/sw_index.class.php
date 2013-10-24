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
		$page = $this->get_request()->get_query('page', 0);
		$markdown = new sw_markdown(PATH_SWWEB_DOCS_DATA);
		$list = $markdown->get_article_list();
		foreach ($list as $key => $value) {
			$list[$key]['path'] = urlencode($value['path']);
			$list[$key]['month'] = date('m d', $value['mtime']);	
			$list[$key]['year']  = date('Y', $value['mtime']);	
		}

		return $this->render('index.html', array('list' => $list));	
	}
	
	// }}}
	// }}}	
}
