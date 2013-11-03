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

namespace lib\github;

/**
* github API 客户端
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_github
{
	// {{{ const

	/**
	 * 通过密码认证 
	 */
	const AUTH_HTTP_PASSWORD = 'http_password';

	/**
	 * 通过 token 认证 
	 */
	const AUTH_HTTP_TOKEN = 'http_token';

	// }}}
	// {{{ members

	/**
	 * http 客户端 
	 * 
	 * @var \lib\github\http_client\sw_abstract
	 * @access protected
	 */
	protected $__http_client = null;

	/**
	 * API 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__apis = array();

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * __construct 
	 * 
	 * @param \lib\github\http_client\sw_abstract $http_client 
	 * @access public
	 * @return void
	 */
	public function __construct(\lib\github\http_client\sw_abstract $http_client = null) {
		if (null === $http_client) {
			$this->__http_client = new \lib\github\http_client\sw_curl();	
		} else {
			$this->__http_client = $http_client;	
		}
	}

	// }}}
	// {{{ public function auth()

	/**
	 * 认证 
	 * 
	 * @param string $login 
	 * @param string $secret 
	 * @param string $method 
	 * @access public
	 * @return void
	 */
	public function auth($login, $secret, $method = null)
	{
		if (!$method) {
			$method = self::AUTH_HTTP_TOKEN;	
		}

		$this->get_http_client()
			 ->set_option('auth_method', $method)
			 ->set_option('login', $login)
			 ->set_option('secret', $secret);
	}

	// }}}
	// {{{ public function deauth()

	/**
	 * 取消认证 
	 * 
	 * @access public
	 * @return void
	 */
	public function deauth()
	{
		$this->auth(null, null, null);	
	}

	// }}}
	// {{{ public function set_http_client()

	/**
	 * set_http_client 
	 * 
	 * @param \lib\github\http_client\sw_abstract $http_client 
	 * @access public
	 * @return void
	 */
	public function set_http_client(\lib\github\http_client\sw_abstract $http_client)
	{
		$this->__http_client = $http_client;
	}

	// }}}
	// {{{ public function get_http_client()

	/**
	 * get_http_client 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_http_client()
	{
		return $this->__http_client;	
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
	 * @return void
	 */
	public function get($path, array $param = array(), array $options = array())
	{
		return $this->get_http_client()->get($path, $param, $options);	
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
	 * @return void
	 */
	public function post($path, array $param = array(), array $options = array())
	{
		return $this->get_http_client()->post($path, $param, $options);	
	}

	// }}}
	// {{{ public function set_api()

	/**
	 * 设置 API 对象 
	 * 
	 * @param string $name 
	 * @param \lib\github\api\sw_abstract $api 
	 * @access public
	 * @return void
	 */
	public function set_api($name, \lib\github\api\sw_abstract $api)
	{
		$this->__apis[$name] = $api;
		
		return $this;	
	}

	// }}}
	// {{{ public function get_api()

	/**
	 * 获取 API 对象 
	 * 
	 * @param string $name 
	 * @access public
	 * @return void
	 */
	public function get_api($name)
	{
		if (!isset($this->__apis[$name])) {
			return null;	
		}

		return $this->__apis[$name];
	}

	// }}}
	// {{{ public function get_repos_api()

	/**
	 * 获取仓库信息的 API 
	 * 
	 * @access public
	 * @return void
	 */
	public function get_repos_api()
	{
		if (!isset($this->__apis['repos'])) {
			$this->__apis['repos'] = new \lib\github\api\sw_repos($this);	
		}

		return $this->__apis['repos'];
	}

	// }}}
	// }}}
}
