<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// アクセス解析の前処理
if ( ! function_exists('googleAnalyticsGetImageUrl'))
{

	function googleAnalyticsGetImageUrl($account) {
		global $GA_ACCOUNT, $GA_PIXEL;
		$GA_ACCOUNT = $account;
		$GA_PIXEL = "/ga.php";
		
		$url = "";
		$url .= $GA_PIXEL . "?";
		$url .= "utmac=" . $GA_ACCOUNT;
		$url .= "&utmn=" . rand(0, 0x7fffffff);
		
		// 改造（HTTP_REFERERがないときにNoticeがでてしまうため）
		//$referer = $_SERVER["HTTP_REFERER"];
		$referer = "";
		if(isset($_SERVER["HTTP_REFERER"]))
		{
			$referer = $_SERVER["HTTP_REFERER"];
		}
		// 改造終わり
		
		$query = $_SERVER["QUERY_STRING"];
		$path = $_SERVER["REQUEST_URI"];
		if (empty($referer)) {
			$referer = "-";
		}
		$url .= "&utmr=" . urlencode($referer);
		if (!empty($path)) {
			$url .= "&utmp=" . urlencode($path);
		}
		$url .= "&guid=ON";
		return str_replace("&", "&amp;", $url);
	}
}



