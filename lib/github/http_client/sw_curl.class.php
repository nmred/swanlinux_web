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
use lib\github\sw_github;

/**
* github API 客户端
*
* @package
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$
*/
class sw_curl extends sw_abstract
{
	// {{{ const
	// }}}
	// {{{ members
	// }}}
	// {{{ functions
	// {{{ protected function do_request()

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
	protected function do_request($url, array $param = array(), $http_method = 'GET', array $options = array()) {
		$curloptions = array();
		
		if ($options['login']) {
			switch ($options['auth_method']) {
				case sw_github::AUTH_HTTP_PASSWORD:
					$curloptions += array(
						CURLOPT_USERPWD => $options['login'].':'.$options['secret'],
					);
					break;
				case sw_github::AUTH_HTTP_TOKEN:
				default:
					$curloptions += array(
						CURLOPT_USERPWD => $options['secret'] . ':x-oauth-basic',
					);
					break;
			}
		}
		
		if (!empty($param)) {
			$query_string = utf8_encode(http_build_query($param, '', '&'));
			
			if ('GET' === $http_method) {
				$url .= '?' . $query_string;	
			} else {
				$curloptions += array(
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $query_string,
				);	
			}
		}	

		$curloptions += array(
			CURLOPT_URL => $url,
			//CURLOPT_PORT => $options['http_port'],
			CURLOPT_USERAGENT => $options['user_agent'],
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_TIMEOUT => $options['timeout']
		);

		$response = $this->_do_curl_call($curloptions);

		if (!in_array($response['headers']['http_code'], array(0, 200, 201))) {
			throw new sw_exception(null, (int) $response['headers']['http_code']);	
		}

		if ($response['error_number'] != '') {
			throw new sw_exception('error ' . $response['error_msg']);	
		}

		return $response['response'];
	}

	// }}}
	// {{{ protected function _do_curl_call()

	/**
	 * _do_curl_call 
	 * 
	 * @param array $curloptions 
	 * @access protected
	 * @return void
	 */
	protected function _do_curl_call(array $curloptions)
	{
		$curl = curl_init();
		
		curl_setopt_array($curl, $curloptions);
		
		ob_start();
		curl_exec($curl);
		$headers = curl_getinfo($curl);
		$error_number = curl_errno($curl);
		$error_msg    = curl_error($curl);
		curl_close($curl);
		$response = ob_get_clean();

		return compact('response', 'error_number', 'error_msg', 'headers');
	}

	// }}}
	// }}}
}
