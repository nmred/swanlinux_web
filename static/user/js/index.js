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
 
/**
+------------------------------------------------------------------------------
* 管理设备页
+------------------------------------------------------------------------------
* 
* @package 
* @version $_SWANBR_VERSION_$
* @copyright $_SWANBR_COPYRIGHT_$
* @author $_SWANBR_AUTHOR_$ 
+------------------------------------------------------------------------------
*/


function Index() {
	ModuleBase.call(this);
	var __this = this;

	// {{{ functions
	// {{{ function init()
		
	/**
	 * 初始化  
	 */
	this.init = function()
	{
		var baseUrl = '?q=index&page=';
		sW.hide("prev_id");
		sW.hide("next_id");
		gFlag = parseInt(gFlag);
		gPage = parseInt(gPage);
		if (gFlag == 1) {
			sW.show("prev_id");
			sW.show("next_id");
			g("prev_id").href = baseUrl + (gPage - 1);
			g("next_id").href = baseUrl + (gPage + 1);
		} else if (gFlag == 2) {
			sW.show("prev_id");
			sW.hide("next_id");
			g("prev_id").href = baseUrl + (gPage - 1);
		} else {
			sW.hide("prev_id");
			sW.show("next_id");
			g("next_id").href = baseUrl + (gPage + 1);
		}
	}
	
	// }}}
	// }}}
}
