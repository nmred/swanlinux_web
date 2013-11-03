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

namespace lib\github\api;
use lib\github\api\exception\sw_exception;

/**
* github API 客户端
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
abstract class sw_abstract
{
	// {{{ const
	// }}}
	// {{{ members

	/**
	 * API client 
	 * 
	 * @var \lib\github\http_client\sw_abstract
	 * @access protected
	 */
	protected $__client = null;

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * __construct 
	 * 
	 * @param \lib\github\sw_github $client 
	 * @access public
	 * @return void
	 */
	public function __construct(\lib\github\sw_github $client)
	{
		$this->__client = $client;
	}

	// }}}
	// {{{ public function get()

	/**
	 * 发送 GET 请求 
	 * 
	 * @param string $path 
	 * @param array $param 
	 * @param array $options 
	 * @access public
	 * @return mixed
	 */
	public function get($path, array $param = array(), array $options = array())
	{
		return $this->__client->get($path, $param, $options);	
	}

	// }}}
	// {{{ public function post()

	/**
	 * 发送 POST 请求 
	 * 
	 * @param string $path 
	 * @param array $param 
	 * @param array $options 
	 * @access public
	 * @return mixed
	 */
	public function post($path, array $param = array(), array $options = array())
	{
		return $this->__client->post($path, $param, $options);	
	}

	// }}}
	// }}}
}
