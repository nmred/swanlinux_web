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
	const PAGE_SIZE = 3;

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
		$is_top = false;
		
		// 分页
		$flag = 1; // 有前一页和后一页
		$count = $markdown->count();
		$config = $this->_read_config();
		if (isset($config['top'])) {
			$md_file = PATH_SWWEB_DOCS_DATA . $config['top'];
			if (is_file($md_file)) {
				$top_article = $markdown->get_article_content($md_file);
				$count--;
				$is_top = true;
			}
		}

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
			if (isset($config['top']) 
				&& $is_top
				&& $value['path'] == $config['top']) {
				unset($list[$key]);
				continue;
			}
			$list[$key]['path']  = urlencode($value['path']);
			$list[$key]['month'] = date('m d', $value['ctime']);	
			$list[$key]['year']  = date('Y', $value['ctime']);	
		}

		// 处理置顶
		if (isset($top_article) && !empty($top_article)) {
			$top['path']  = urlencode($config['top']);
			$top['month'] = date('m d', $value['ctime']);
			$top['year']  = date('Y', $top_article['ctime']);
			$top = array_merge($top, $top_article);
		}
		array_unshift($list, $top);
		
		$render['list'] = $list;
		$render['flag'] = $flag;
		$render['page'] = $page; 
		return $this->render('index.html', $render);	
	}
	
	// }}}
	// {{{ public function action_do()

	/**
	 * action_do 
	 * 
	 * @access public
	 * @return void
	 */
	public function action_do()
	{
		$action = $this->get_request()->get_query('action');

		switch ($action) {
			case 'sync':
				return $this->_sync();
		}
	}

	// }}}
	// {{{ protected function _sync()

	/**
	 * 同步 github 的数据 
	 * 
	 * @access protected
	 * @return void
	 */
	protected function _sync()
	{
		$github_ini = parse_ini_file(PATH_SWWEB_ETC . 'sw_github.ini');

		if (false == $github_ini || !isset($github_ini['github_token'])) {
			return false;	
		}
		
		$last_update_cache = PATH_SWWEB_TMP . 'last_update';
		if (!is_file($last_update_cache)) {
			file_put_contents($last_update_cache, time() - (3600 * 8));
			return false;
		}

		$last_update_time = file_get_contents($last_update_cache);
		$since = date('Y-m-d\TH:i:s\Z', $last_update_time);
		$github = new \lib\github\sw_github();

		$github->auth('nmred', trim($github_ini['github_token']));
		$commits = $github->get_repos_api()
					      ->get_commits('nmred', 'swan_docs', array(
								'since' => $since,
							));

		foreach ($commits as $commit) {
			if (!isset($commit['sha'])) {
				continue;	
			}	

			$commit_info = $github->get_repos_api()
								  ->get_commit('nmred', 'swan_docs', $commit['sha']);
			if (!isset($commit_info['files'])) {
				continue;	
			}
			foreach ($commit_info['files'] as $file) {
				if (!isset($file['filename'])) {
					continue;	
				}
				
				$content_info = $github->get_repos_api()
									   ->get_contents('nmred', 'swan_docs', $file['filename']);
				if (!isset($content_info['content'])
						|| $content_info['type'] != 'file') {
					continue;
				}

				$str = base64_decode($content_info['content']);

				$input_path = PATH_SWWEB_DOCS_DATA . $file['filename'];

				echo "sync file: $input_path.\n";

				$dir = dirname($input_path);

				if (!is_dir($dir)) {
					mkdir($dir, 0644, true);
				}

				file_put_contents($input_path, $str);
			}
		}
	}

	// }}}
	// {{{ protected function _read_config()

	/**
	 * 读取配置文件 
	 * 
	 * @access protected
	 * @return void
	 */
	protected function _read_config()
	{
		$config_file = PATH_SWWEB_DOCS_DATA . '.config.ini';
		if (!is_file($config_file)) {
			return false;
		}
		
		$config = parse_ini_file($config_file, true);

		if (isset($config['list'])) {
			return $config['list'];	
		}

		return false;
	}

	// }}}
	// }}}	
}
