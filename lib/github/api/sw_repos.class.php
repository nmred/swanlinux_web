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
class sw_repos extends sw_abstract
{
	// {{{ const
	// }}}
	// {{{ members
	// }}}
	// {{{ functions
	// {{{ public function get_commits()

	/**
	 * 获取提交的信息 
	 * 
	 * @param string $username 
	 * @param string $repos 
	 * @param array $param 
	 * @access public
	 * @return array
	 */
	public function get_commits($username, $repos, array $param = array())
	{
		$path = 'repos/' . urlencode($username) . '/' . urlencode($repos) . '/commits';
		$repsonse = $this->get($path, $param);
		return $repsonse;	
	}

	// }}}
	// {{{ public function get_commit()

	/**
	 * 获取提交的信息 
	 * 
	 * @param string $username 
	 * @param string $repos 
	 * @param string $sha 
	 * @param array $param 
	 * @access public
	 * @return array
	 */
	public function get_commit($username, $repos, $sha, array $param = array())
	{
		$path = 'repos/' . urlencode($username) . '/' . urlencode($repos) . '/commits/' . urlencode($sha);
		$repsonse = $this->get($path, $param);
		return $repsonse;	
	}

	// }}}
	// {{{ public function get_contents()

	/**
	 * 获取提交的文件的内容
	 * 
	 * @param string $username 
	 * @param string $repos 
	 * @param string $path 
	 * @param array $param 
	 * @access public
	 * @return array
	 */
	public function get_contents($username, $repos, $path, array $param = array())
	{
		$path = 'repos/' . urlencode($username) . '/' . urlencode($repos) . '/contents/' . urlencode($path);
		$repsonse = $this->get($path, $param);
		return $repsonse;	
	}

	// }}}
	// }}}
}
