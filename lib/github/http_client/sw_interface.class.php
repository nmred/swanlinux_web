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

namespace lib\github\http_client;

/**
* github API 客户端
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
interface sw_interface
{
	// {{{ const
	// }}}
	// {{{ members
	// }}}
	// {{{ functions
	// {{{ public function get()

	/**
	 * 发送 GET 请求 
	 * 
	 * @param string $path 
	 * @param array $param 
	 * @param array $options 
	 * @access public
	 * @return data
	 */
	public function get($path, array $param = array(), array $options = array());

	// }}}
	// {{{ public function post()

	/**
	 * 发送 POST 请求 
	 * 
	 * @param string $path 
	 * @param array $param 
	 * @param array $options 
	 * @access public
	 * @return data
	 */
	public function post($path, array $param = array(), array $options = array());

	// }}}
	// {{{ public function set_option()

	/**
	 * 设置请求参数 
	 * 
	 * @param string $name 
	 * @param mixed $value 
	 * @access public
	 * @return \lib\github\sw_interface
	 */
	public function set_option($name, $value);

	// }}}
	// }}}
}
