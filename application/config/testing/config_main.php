<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// サイト名
define('SITE_NAME','Codeigniter CMS (testing)');

// メールアドレス
define('MAIL_ADDRESS_FROM', 'phamhoaian005@gmail.com');

define('LANG','Japanese');



// DBスレーブを利用するかどうか 
$config['use_db_slave'] = true;

// キャッシュするかどうか
$config['cache_flag'] = false;

// キャッシュディレクトリ
$config['cache_dir'] = BASEPATH . "cache/web/content/";

// キャッシュ時間（秒）
$config['cache_lifetime'] = "3600";


// Google Anlytics モバイルのコード（空白の場合は解析を行わない、コード例：MO-10000000-1）
$config['google_anlytics_mobile_code'] = "";


// base_url
$config['base_url'] = "";

// クッキーの保存期間
$config['cookie_expire'] = 100 * 86400;

// クッキーに保存するキーワード
$config['cookie_tail'] = "aaaa";

$config['ip_member'] = array(
	'127.0.0.1',
);





//
//
// ここから下は設定を変更しない
//
//



?>
