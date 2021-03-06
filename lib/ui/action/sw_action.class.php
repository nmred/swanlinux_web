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
 
namespace lib\ui\action;
use swan\controller\sw_action as sf_sw_action;

/**
+------------------------------------------------------------------------------
* sw_action 
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
class sw_action extends sf_sw_action
{
	// {{{ members

	/**
	 * 视图对象 
	 * 
	 * @var swan\view\sw_view
	 * @access protected
	 */
	protected $__view;

	// }}}
	// {{{ functions
	// {{{ public function init_view()
	
	/**
	 * 初始化samrty 
	 * 
	 * @access public
	 * @return void
	 */
	public function init_view()
	{
		if (null !== $this->__view) {
			return $this->__view;	
		}

		$module_name = $this->get_request()->get_module_name();

		$template_dir = PATH_SWWEB_TPL . $module_name;
		$compile_dir = PATH_SWWEB_COMPILE . $module_name;
		$cache_dir = PATH_SWWEB_CACHE . $module_name;
		$this->__view = new \swan\view\sw_view($template_dir, $compile_dir, $cache_dir);
		$staic_file_paths = $this->get_static_path();
		foreach ($this->get_static_path() as $key => $value) {
			$this->__view->assign($key, $value);
		}

		return $this->__view;
	}

	// }}}
	// {{{ public function render()

	/**
	 * render 
	 * 
	 * @param mixed $dispaly_file 
	 * @param array $args 
	 * @access public
	 * @return void
	 */
	public function render($dispaly_file, array $args)
	{
		$view = $this->init_view();
		foreach ($args as $key => $value) {
			$view->assign($key, $value);	
		}
		
		$module_name = $this->get_request()->get_module_name();
		$action_name = $this->get_request()->get_action_name();
		
		ob_start();
		$view->render(PATH_SWWEB_TPL . $module_name . '/' . $dispaly_file);
		$this->get_response()->append_body(
			ob_get_clean(),
			$action_name
		);
	}

	// }}}
	// {{{ public function get_static_path()

	/**
	 * 获取全局静态文件的路劲 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_static_path()
	{
		$base_path = $this->get_request()->get_base_path();
		$static_base_path = $base_path . '/static/';
		$tpl_static_public = $static_base_path . 'public/';
		$tpl_static_user   = $static_base_path . 'user/';

		//注意：虽然提供了目录路劲，但是最好不要直接使用
		$map = array(
			//全局
			'URL_PREFIX'    => $base_path,
			'URL_PREFIX_USER' => $base_path . '/user/',

			// {{{ public

			'URL_JS_PUBLIC'    => $tpl_static_public . 'js/',
				'URL_JQUERY_PUBLIC' => $tpl_static_public . 'js/jquery-1.7.2.min.js' . $this->get_version(),
				'URL_SW_JS_PUBLIC' => $tpl_static_public . 'js/sw.js' . $this->get_version(),
			'URL_CSS_PUBLIC'   => $tpl_static_public . 'css/',
			//	'URL_COMMON_JS_CSS_PUBLIC' => $tpl_static_public . 'css/common_js.css' . $this->get_version(),
			'URL_IMAGE_PUBLIC' => $tpl_static_public . 'image/',

			// }}}
			// {{{ user

			'URL_JS_USER'     => $tpl_static_user . 'js/',
				'URL_JS_COMMON_USER'     => $tpl_static_user . 'js/common.js',
				'URL_JS_INDEX_USER'     => $tpl_static_user . 'js/index.js',
			'URL_CSS_USER'    => $tpl_static_user . 'css/',
				'URL_CSS_COMMON_USER' => $tpl_static_user . 'css/common.css', 
			'URL_IMAGE_USER'  => $tpl_static_user . 'image/',

			// }}}
		);

		return $map;
	}

	// }}}
	// {{{ public function get_version()

	/**
	 * 静态文件后加入的版本号 
	 * 
	 * @access public
	 * @return string
	 */
	public function get_version()
	{
		return '?v=' . SWAN_VERSION;	
	}

	// }}}
	// }}}	
}
