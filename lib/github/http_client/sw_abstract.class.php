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
use lib\github\http_client\exception\sw_exception;

/**
* github API 客户端
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
abstract class sw_abstract implements sw_interface
{
	// {{{ const
	// }}}
	// {{{ members

	/**
	 * 设置参数 
	 * 
	 * @var array
	 * @access protected
	 */
	protected $__options = array(
		'protocol'   => 'https',
		'url'        => ':protocol://api.github.com/:path',
		'format'     => 'json',
		'user_agent' => 'swan-github-api (www.swanlinux.net)',
		'http_port'  => 80,
		'timeout'    => 10,
		'login'      => null,
		'token'      => null,
	);

	// }}}
	// {{{ functions
	// {{{ public function __construct()

	/**
	 * __construct 
	 * 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function __construct(array $options = array())
	{
		$this->__options = array_merge($this->__options, $options);
	}

	// }}}
	// {{{ abstract protected function do_request()

	/**
	 * 请求 
	 * 
	 * @param string $url 
	 * @param array $param 
	 * @param string $http_method 
	 * @param array $options 
	 * @abstract
	 * @access protected
	 * @return void
	 */
	abstract protected function do_request($url, array $param = array(), $http_method = 'GET', array $options = array());

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
		return $this->request($path, $param, 'GET', $options);	
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
		return $this->request($path, $param, 'POST', $options);	
	}

	// }}}
	// {{{ public function request()

	/**
	 * 请求API 
	 * 
	 * @param string $path 
	 * @param array $param 
	 * @param string $http_method 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function request($path, array $param = array(), $http_method = 'GET', array $options = array())
	{
		$options = array_merge($this->__options, $options);

		// 创建 URL
		$url = strtr($options['url'], array(
			':protocol' => $options['protocol'],
			':format'   => $options['format'],
			':path'     => trim($path, '/'),
		));

		$response = $this->do_request($url, $param, $http_method, $options);

		$response = $this->decode_response($response, $options);
		return $response;
	}

	// }}}
	// {{{ public function decode_response()

	/**
	 * decode 响应数据 
	 * 
	 * @param string $response 
	 * @param array $options 
	 * @access public
	 * @return array
	 */
	public function decode_response($response, array $options)
	{
		if ('text' == $options['format']) {
			return $response;	
		} elseif ('json' === $options['format']) {
			return json_decode($response, true);	
		}

		throw sw_exception(__CLASS__ . '  only supports json & text format, '.$options['format'].' given.');
	}

	// }}}
	// {{{ public function set_option()

	/**
	 * 设置参数 
	 * 
	 * @param string $name 
	 * @param mixed $value 
	 * @access public
	 * @return \lib\github\http_client
	 */
	public function set_option($name, $value)
	{
		$this->__options[$name] = $value;
		
		return $this;	
	}

	// }}}
	// }}}
}
