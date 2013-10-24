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
class sw_detail extends sw_action
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
		$path = $this->get_request()->get_query('path', null);
		$path = PATH_SWWEB_DOCS_DATA . urldecode($path);
		$markdown = new sw_markdown(PATH_SWWEB_DOCS_DATA);
		$article = $markdown->get_article_content($path);

		$article['year']  = date('Y', $article['mtime']);
		$article['month'] = date('m d', $article['mtime']);

		return $this->render('detail.html', array('article' => $article));	
	}
	
	// }}}
	// }}}	
}
