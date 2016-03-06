<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $is_force_ssl = FALSE;
	protected $is_bench = FALSE;
	protected $is_cache = FALSE;
	
	protected $is_auth = FALSE;
	
	public $is_mobile = FALSE;
	public $is_test = FALSE;
	private $agent = '';
	
	public $use_mobile_view = FALSE;
	public $use_smartphone_view = FALSE;
	public $view_smartphone = FALSE;
	
	public $is_pc = TRUE;
	public $view_pc = TRUE;
	
	public $css = "";
	public $js = "";
	public $js_foot = "";
	
	private $_url   = '';
	public  $config_main = array();
	
	public $db_mode   = 'write';
	public $user_id = FALSE;
	
	public $is_docomo = FALSE;
	public $is_softbank = FALSE;
	public $is_au = FALSE;
	
	public $is_android = FALSE;
	public $is_iphone = FALSE;
	public $is_ipad = FALSE;
	
	public $is_smartphone = FALSE;
	
	
	protected $only_mobile = FALSE;
	protected $only_pc = FALSE;
	protected $only_smartphone = FALSE;
	
	private $cache_id = '';
	private $cache_group = '';
	protected $cache_output ='';
	private $cache_lifetime;
	
	
	function __construct()
	{
		parent::__construct();
		$this->config->load('config_main', TRUE);
		
		mb_language(LANG);
		ini_set('mbstring.detect_order', 'auto');
		ini_set('mbstring.http_input', 'auto');
		ini_set('mbstring.http_output', 'pass');
		ini_set('mbstring.internal_encoding', 'UTF-8');
		ini_set('mbstring.script_encoding', 'UTF-8');
		ini_set('mbstring.substitude_character', 'none');
		mb_regex_encoding("UTF-8");
		mb_substitute_character("long");
		mb_substitute_character(0x3013);
		// PHP 5.3 用
		ini_set('date.timezone', 'Asia/Ho_Chi_Minh');
		
		$this->load->helper(array('url','path','form','main'));
		
 		// mobileMyClassライブラリ
 		parse_str($_SERVER['QUERY_STRING'],$_GET);
		$this->load->library('MobileMyClass');
		
		
		
		
		$path = APPPATH . 'pear';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		$this->init_APP();
		
		
	}
	
	
	
	/**
	 * SSLを強制でon/offする
	 * on = on   off = off
	 */
	protected function set_force_ssl($ssl)
	{
		$this->is_force_ssl = $ssl;
	}
	
	
	
	/**
	 * ベンチマークを表示するかどうかの値をセットする
	 */
	protected function set_bench($bench)
	{
		$this->is_bench = $bench;
	}
	
	
	
	
	/**
	 * mobileを利用するかどうかの値をセットする
	 */
	protected function set_mobile_view($iphone)
	{
		$this->use_mobile_view = TRUE;
	}
	
	/**
	 * スマートフォンを利用するかどうかの値をセットする
	 */
	protected function set_smartphone_view($smartphone)
	{
		$this->use_smartphone_view = TRUE;
	}
	
	
	
	
	/**
	 * モバイルキャリアを取得
	 */
	public function get_mobile_carrier()
	{
		if(!$this->is_mobile)
		{
			return false;
		}
        if ($this->agent->isDoCoMo()) { 
            return "DoCoMo";
        } else if ($this->agent->isVodafone()) { 
            return "SoftBank";
        } else if ($this->agent->isEZweb()) { 
            return "EZweb";
        } else{
            return "PC";
        }
	}
	
	
	
	
	
	
	
	
	/**
	 * ビューを読み込んでアウトプットに引き渡す
	 */
	public function load_view($view_name,$view_data='',$layout_flag='TRUE',$layout_name='layout')
	{
		
		$this->load->vars(array('header'=>$this->set_header()));
		if ($this->use_mobile_view and $this->mobilemyclass->is_mobile())
		{
			$this->send_nocache_headers();
		}
		
		$tmp_dir = "pc/";
		if ($this->use_mobile_view and $this->mobilemyclass->is_mobile())
		{
			$tmp_dir = "mobile/";
		}
		
		if ($this->use_smartphone_view and $this->mobilemyclass->is_smartphone())
		{
			$tmp_dir = "smartphone/";
		}
		
		
		
		$data['main'] = $this->load->view($tmp_dir.$view_name,$view_data,TRUE);
		
		// cssとjavascriptを読み込む
		$this->load->vars(array('css'=>"$this->css",'js'=>"$this->js",'js_foot'=>"$this->js_foot"));
		
		if($layout_flag)
		{
			$body = $this->load->view($tmp_dir.$layout_name,$data,TRUE,'layout_this');
		}
		else
		{
			$body = $data['main'];
		}
		$this->output($body);
	}
	
	
	
	
	
	
	
	public function output($output)
	{
		# キャッシュの処理
		if($this->is_cache and !$this->cache_output)
		{
			$this->save_cache($output);
		}
		
		$this->output->set_output($output);
		$this->output->_display();
		exit;
	}
	
	
	
	
	
	
	/**
	*  テスト環境にする
	*  指定したIPアドレス以外は表示させない
	*/
	protected function set_test($test)
	{
		$this->is_test = $test;
	}
	
	
	
	
	/**
	*  テスト環境にする
	*  指定したIPアドレス以外は表示させない
	*/
	protected function chk_test($ip='')
	{
		$ip_member = $this->config->item('ip_member', 'config_main');
		if(!$ip)
		{
			$ip = $this->input->ip_address();
		}
		
		if(in_array($ip, $ip_member))
		{
			return TRUE;
		}
		else
		{
			print "Not Access!";
			exit;
		}
	}
	
	
	
	
	/**
	 * 
	 */
    public function send_nocache_headers()
    {
        //return true;
        // no-cache
        // 日付が過去
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        // 常に修正されている
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // HTTP/1.1
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        // HTTP/1.0
        $this->output->set_header('Pragma: no-cache');
        return true;
    }
    
	
	
	
	
	
	
	
    public function set_header()
    {
		$header = '';
		
		if($this->is_mobile)
		{
			$carrier = $this->mobilemyclass->get_carrier();
            switch ($carrier)
            {
                case 'docomo':
                    $header = "<?xml version=\"1.0\" encoding=\"Shift_JIS\"?>
<!DOCTYPE html PUBLIC \"-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/1.0) 1.0//EN\"
 \"i-xhtml_4ja_10.dtd\">\n";
					//header('Content-Type: application/xhtml+xml; charset=Shift_JIS');
					header('Content-Type: text/html; charset=Shift_JIS');
					
                    break;
                case 'au':
					$this->_header = "<?xml version=\"1.0\" encoding=\"Shift_JIS\"?>
<!DOCTYPE html PUBLIC \"-//OPENWAVE//DTD XHTML 1.0//EN\"
 \"http://www.openwave.com/DTD/xhtml-basic.dtd\">\n";
					header('Content-Type: text/html; charset=Shift_JIS');
                    break;
                case 'softbank':
					$header = "<?xml version=\"1.0\" encoding=\"Shift_JIS\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
 \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd\">\n";
					header('Content-Type: text/html; charset=Shift_JIS');
					break;
				default:
					$header = "<?xml version=\"1.0\" encoding=\"Shift_JIS\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
 \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd\">\n";
					header('Content-Type: text/html; charset=Shift_JIS');
                    break;
            }
		}
		else
		{
			//PCサイト
			$header = "";
			header('Content-Type: text/html; charset=UTF-8');
		}
		
		
		return $header;
	}
	
	
	
	
	
	
	
	/**
	 * データベースの設定
	 */
	/*
	public function load_database($db_name='default',$db_mode='')
	{
		//$this->load->database();
		if($this->config->item('use_db_slave', 'config_main'))
		{
			
			if($db_name === 'default')
			{
				// defaultの場合はそのまま
				$this->_mydb = $this->load->database($db_name, TRUE);
			}
			else if($db_mode === "write")
			{
				$db_name = $db_name."_master";
				$this->_mydb = $this->load->database($db_name, TRUE);
				
			}
			else
			{
				$db_name = $db_name."_slave";
				//echo $db_name;
				$this->_mydb = $this->load->database($db_name, TRUE);
			}
			
		}
		else
		{
			$this->_mydb = $this->load->database($db_name, TRUE);
		}
		
		//print_r($this->_mydb);
		return $this->_mydb;
	}
	 */
	
	
	
	
	
	/**
	*  メールを送信する
	*/
	protected function mail_send($mail_address_to,$mail_subject,$mail_content,$mail_address_from='',$mail_attach_path='')
	{
		$this->load->library('qdmail');
		$this->load->helper('email');
		if (!valid_email("$mail_address_to"))
		{
			return FALSE;
		}
		if(!$mail_address_from)
		{
			$mail_address_from = MAIL_ADDRESS_FROM;
		}
		$mail = new Qdmail();
		$mail->to("$mail_address_to");
		$mail->subject("$mail_subject");
		$mail->text("$mail_content");
		$mail->from("$mail_address_from");
		
		if($mail_attach_path and file_exists($mail_attach_path))
		{
			$mail->attach($mail_attach_path);
		}
		$mail->send();
		//qd_send_mail('text',$mail_address_to,"$title",$mail_content,"$mail_address_from");
		return TRUE;
	}
	
	
	
	
	
	
	/**
	*  CSSを組み込む
	*/
	protected function set_css($css_name)
	{
		if ( !preg_match("/\.css$/", $css_name) )
		{
			$css_name = $css_name.'.css';
		}
		$this->css .= '<link rel="stylesheet" href="'.base_url().'css/'.$css_name.'" type="text/css" />'."\n";
	}
	
	
	/**
	*  JavaScriptを組み込む
	*/
	protected function set_js($js_name)
	{
		if ( preg_match('/^(http?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $js_name)
				|| preg_match('/^\/\/.+/', $js_name)
		)
		{
            $this->js .= '<script type="text/javascript" src="' . $js_name . '"></script>' . "\n";
        }
		else if (!preg_match("/\.js$/", $js_name))
		{
			$js_name = $js_name . '.js';
			$this->js .= '<script type="text/javascript" src="' . base_url() . 'js/' . $js_name . '"></script>' . "\n";
			
		}
		else
		{
			$this->js .= '<script type="text/javascript" src="' . base_url() . 'js/' . $js_name . '"></script>' . "\n";
		}
	}
	
	
	/**
	*  JavaScriptを組み込む
	*/
	protected function set_js_foot($js_name)
	{
		if ( preg_match('/^(http?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $js_name)
				|| preg_match('/^\/\/.+/', $js_name)
		)
		{
            $this->js_foot .= '<script type="text/javascript" src="' . $js_name . '"></script>' . "\n";
        }
		else if (!preg_match("/\.js$/", $js_name))
		{
			$js_name = $js_name . '.js';
			$this->js_foot .= '<script type="text/javascript" src="' . base_url() . 'js/' . $js_name . '"></script>' . "\n";
			
		}
		else
		{
			$this->js_foot .= '<script type="text/javascript" src="' . base_url() . 'js/' . $js_name . '"></script>' . "\n";
		}
	}
	
	
	
	public function _output($output)
	{
		if($this->is_mobile)
		{
			// Google Anlyticsモバイル設定
			if($this->config->item('google_anlytics_mobile_code', 'config_main') and preg_match("|</body>.*?</html>|is", $output))
			{
				$this->load->helper('google_analytics');
				$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl($this->config->item('google_anlytics_mobile_code', 'config_main'));
				$output = preg_replace("|</body>.*?</html>|is", '', $output);
				$output .= "<img src=\"".$googleAnalyticsImageUrl."\" />\n";
				$output .= "</body>\n</html>";
			}
		
			$output = mb_convert_encoding($output, 'SJIS-win', 'UTF-8');
		}
		echo $output;
	}
	
	
	
	# 文字コード変更
	private function _convert_encoding($arr)
	{
		return is_array($arr) ? array_map(array(&$this, '_convert_encoding'), $arr) :
			mb_convert_encoding($arr, 'UTF-8', 'SJIS-win,Shift-JIS');
	}
    
    
    
    
    
	/**
	 * 初期設定系
	 */
    private function init_APP()
    {
		//
		// スマートフォンの確認
		//
		
		// android
		if ($this->mobilemyclass->is_android())
		{
			$this->is_android = TRUE;
		}
		// iphone
		else if ($this->mobilemyclass->is_iphone())
		{
			$this->is_iphone = TRUE;
		}
		// iPad
		else if ($this->mobilemyclass->is_ipad())
		{
			$this->is_ipad = TRUE;
		}
    	
		// スマートフォン
		if ($this->mobilemyclass->is_smartphone())
		{
			$this->is_smartphone = TRUE;
			$this->is_pc = FALSE;
			$this->view_pc = FALSE;
			
			if($this->use_smartphone_view)
			{
				// クッキーを有効にしてビューの種類を取得
				$this->load->helper('cookie');
				$view_tmp = get_cookie('sf_view', TRUE);
				if($view_tmp == 'pc')
				{
					$this->view_smartphone = "";
					$this->view_pc = TRUE;
					//$this->use_smartphone_view = FALSE;
				}
				else
				{
					$this->view_smartphone = TRUE;
				}
			}
		}
		
		
		
		if( ! $this->config->config['base_url'] )
		{
			$this->config->config['base_url'] = $this->config->base_url();
		}
		
		
		if ($this->mobilemyclass->is_mobile())
		{
			$this->is_mobile = TRUE;
			$this->is_pc = FALSE;
			$this->view_pc = FALSE;
			
			# NET_USERAGENT_MOBIEL読み込み
			//$this->pearloader->load('Net/UserAgent/Mobile');
			
			require_once 'Net/UserAgent/Mobile.php';
			$this->agent = &Net_UserAgent_Mobile::singleton();
		}
		
		
		if($this->is_force_ssl == "OFF" and $_SERVER['SERVER_PORT'] != 80){
			$this->load->helper('force_ssl');
			force_no_ssl();
		}
		
		
		//
		// SSL通信の処理（SSLの場合は強制的にすべてをSSLにする）
		//
		if(isset($_SERVER['HTTPS'])){
			$this->load->helper('force_ssl');
			force_ssl();
		}
		
		# テスト環境かどうか
		if($this->is_test)
		{
			$this->chk_test();
		}
		
		
		if ( ! $this->mobilemyclass->is_mobile() and ! $this->mobilemyclass->is_smartphone() )
		{
			$this->is_pc = TRUE;
		}
		
		
		//PCでSESSIDがGETについている場合、カットする
		if (isset($_GET['sessid']))
		{
			unset($_GET['sessid']);
		}
		
		
		if ($_GET)
		{
			$this->get_param = http_build_query($_GET);
		}
		
		
		
		
		if ($this->mobilemyclass->is_mobile())
		{
			// モバイルの場合の処理
			
			// PCサイト専用の場合はエラーを返す
			if($this->only_pc)
			{
				$this->load->library('emoji');
				$this->message("PC専用ページです");
				exit;
			}
			
			//スマートフォン専用の場合はエラーを返す
			elseif($this->only_smartphone)
			{
				$this->load->library('emoji');
				$this->message("スマートフォン専用ページです");
				exit;
			}
		}
		elseif($this->mobilemyclass->is_smartphone())
		{
			//モバイルサイト専用の場合はエラーを返す
			if($this->only_mobile)
			{
				$this->message("モバイル専用ページです");
				exit;
			}
			//PCサイト専用の場合はエラーを返す
			if($this->only_pc)
			{
				#print "PC Only Page";
				$this->load->library('emoji');
				$this->message("PC専用ページです");
				exit;
			}
		}
		else
		{
			$this->is_pc = TRUE;
			//モバイルサイト専用の場合はエラーを返す
			if($this->only_mobile)
			{
				$this->message("モバイル専用ページです");
				exit;
			}
			
			//スマートフォン専用の場合はエラーを返す
			elseif($this->only_smartphone)
			{
				#print "PC Only Page";
				$this->load->library('emoji');
				$this->message("スマートフォン専用ページです");
				exit;
			}
			
			//PCでSESSIDがGETについている場合、カットする
			if (isset($_GET['sessid']))
			{
				unset($_GET['sessid']);
			}
		}
		
		
		//認証を行うか
		if ($this->is_auth)
		{
			$this->initialize_auth();
			$this->chk_auth();
		}
		
		
		$this->_url = current_url();
		
		
		
		# post getの処理
		if($this->is_mobile)
		{
			//$_GET  = $this->_convert_encoding($_GET);
			//$_POST = $this->_convert_encoding($_POST);
		}
		
		# 計測値を表示するかどうか
		if($this->is_bench)
		{
			$this->output->enable_profiler(TRUE);
		}
		
		# とりあえずセット
		$this->load->vars(array('css'=>"",'js'=>""));
	}
	
	
	
	
	
	/**
	 * 権限によるページ閲覧制限
	 */
	protected function chk_permission($this_role='9')
	{
		if(!$this->is_auth)
		{
			return FALSE;
		}
		
		if(!$this->is_mobile)
		{
			$this->load->library('DX_Auth');
			if (! $this->dx_auth->is_logged_in()){
				$this->session->set_userdata('next_segment', $this->_url);
			}
			$this->dx_auth->check_uri_permissions();
		}
		else
		{
			
			$this->load->model('mobile_auth_model');
			$user_id = $this->get_user_id();
			
			if(!$role=$this->mobile_auth_model->get_role($user_id))
			{
				print "NOT ACCESS";
				exit();
			}
			
			if($this_role > $role)
			{
				print "NOT ACCESS";
				exit();
			}
			else
			{
				return $role;
			}

		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Authチェックのための値をセットする
	 * @param   bool true or false
	 * @access  private
	 * @return  void
	 */
	protected function set_auth($auth)
	{
		$this->is_auth = $auth;
	}

	/**
	 * Authチェックを行う
	 * @access  private
	 * @return  void
	 */
	protected function chk_auth()
	{
		if($this->is_mobile)
		{
			#ここで携帯の認証
			
			
			
			if((!preg_match("/uid=/", $_SERVER['QUERY_STRING']) and !preg_match("/uid=/", $_SERVER['PHP_SELF'])) and !$this->mobilemyclass->get_mobile_id() and $this->mobile_auth->carrier() == "docomo")
			{
				#print "damedame<br>";
				$reload_url = htmlspecialchars($_SERVER['PHP_SELF']).$this->config->item('docomo_url_tail', 'config_main');
				#$reload_url = current_url().$this->config->item('docomo_url_tail', 'config_main');
				#$reload_url  = str_replace('/index.php', '', $reload_url);
				$reload_url = current_url();
				$reload_url  = str_replace('/index.php', '', $reload_url);
				header("Location: $reload_url");
				exit;
			}
			
			# 認証
			if($this->mobile_auth->is_user())
			{
				$this->load->model('mobile_auth_model');
				$user_id = $this->get_user_id();
				if($this->mobile_auth_model->get_banned($user_id))
				{
					$this->message("アクセスが拒否されました");
				}
				else
				{
					return TRUE;
				}
			}
			else
			{
				$jump_url = $this->config->item('register_url', 'config_main');
				header("Location: $jump_url");
				exit;
			}
			
			
			
		}
		else
		{
			if ( ! $this->_chk_auth())
			{
				$this->session->set_userdata('next_segment', $this->_url);
				$this->dx_auth->deny_access('login');
				#redirect('login');
			}
		}
	}
	
	
	
	#
	# 認証状態かどうか？
	# TRUEかFALSEを返すだけで
	protected function chk_auth_pass()
	{
		if(!$this->is_auth)
		{
			$this->initialize_auth();
		}
		
		if($this->is_mobile)
		{
			#ここで携帯の認証
			if((!preg_match("/uid=/", $_SERVER['QUERY_STRING']) and !preg_match("/uid=/", $_SERVER['PHP_SELF'])) and !$this->mobilemyclass->get_mobile_id() and $this->mobile_auth->carrier() == "docomo")
			{
				$reload_url = htmlspecialchars($_SERVER['PHP_SELF']).$this->config->item('docomo_url_tail', 'config_main');
				$reload_url = current_url();
				$reload_url  = str_replace('/index.php', '', $reload_url);
				header("Location: $reload_url");
				exit;
			}
			
			# 認証
			if($this->mobile_auth->is_user())
			{
				$this->is_auth = TRUE;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			if ( $this->_chk_auth())
			{
				$this->is_auth = TRUE;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		return FALSE;

	}
	
	
	#
	# 認証の初期設定をする
	# 
	protected function initialize_auth()
	{
		#$this->load->library('session');
		if($this->is_mobile)
		{
		
			//print "mobile_auth2!!<br />";
			$this->load->database();
			#parse_str($_SERVER['QUERY_STRING'],$_GET);
			$this->load->library('Mobile_auth');
			
		}
		else
		{
			//print "PC_auth!!<br />";
			$this->load->library('session');
			$this->load->library('DX_Auth');
			$this->session_flag = TRUE;
		}
		
	}
	
	

	/**
	 * 認証ページかどうかを判定する
	 *
	 * @access  private
	 * @return  void
	 */
	protected function get_auth()
	{
		return $this->is_auth;
	}


	/**
	 * 認証を確認する
	 *
	 * @access  private
	 * @return  void
	 */
	private function _chk_auth()
	{
		//セッションIDパラメータがあれば渡す
		if(!$this->is_mobile)
		{
			if (! $this->dx_auth->is_logged_in()){
				#$this->dx_auth->deny_access('login');
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	
	
	
	
	
	
	
	/**
	 * 携帯サイトのみのページかどうかを値をセットする
	 */
	protected function set_only_mobile($mobile)
	{
		$this->only_mobile = $mobile;
	}
	
	
	/**
	 * PCサイトのみのページかどうかをセットする
	 */
	protected function set_only_pc($mobile)
	{
		$this->only_pc = $mobile;
	}
	
	
	/**
	 * スマートフォンのみのページかどうかをセットする
	 */
	protected function set_only_smartphone($mobile)
	{
		$this->only_smartphone = $mobile;
	}
	
	
	
	
	// ユーザーIDを取得
	protected function get_user_id()
	{
		if(!$this->is_auth)
		{
			return FALSE;
		}
		
		if($this->user_id)
		{
			return $this->user_id;
		}
		else
		{
			$this->user_id = $this->dx_auth->get_user_id();
			return $this->user_id;
		}
	}
	
	
	
	
	/**
	 * メッセージを表示
	 */
	public function message($message)
	{
		$data['main'] = $message;
		// ログ出力
		//$uri = current_url();
		//log_message('error', "message ".$data["main"]." ".$uri);
		
		$body = $this->load_view('message',$data,TRUE);
		$this->output($body);
	}
		
	
	
	// セキュリティ対策　lengthは文字列をカットした場合に入れる
	public function security_clean($q)
	{
		$this->load->helper('security');
		//$this->load->library('security');
		
		$q = str_replace( "\0", "", $q );
		$q = str_replace( '\0', "", $q );
		
		
		$q = xss_clean($q);
		//$q = $this->security->xss_clean($q);
		
		$q = strip_image_tags($q);
		$q = encode_php_tags($q);
		$q = preg_replace(array("/select/si", "/delete/si", "/update/si", "/insert/si","/from/si","/alert/si","/\[removed\]/si","/script/si","/\*/si"), "", $q);
		
		return $q;
	}
	
	
	
	
	/**
	 * キャッシュの初期設定
	 */
	protected function cache_start($id='',$lifetime='')
	{
		$this->is_cache = TRUE;
		$this->cache_id = $id;
		if(!$this->cache_id)
		{
			$this->cache_id = $this->_url;
		}
		if(!$lifetime)
		{
			$lifetime = $this->config->item('cache_lifetime', 'config_main');
		}
		$this->cahche_lifetime = $lifetime;
		$this->cache_id = str_replace(array("/","http",":",".","-", "_"), "", $this->cache_id);
		
		$this->load->driver('cache', array('adapter' => 'file'));
		
		
		// キャッシュを削除
		$rand = mt_rand(1, 999);
		if($rand === 1)
		{
			$this->cache->clean();
		}
		if ($this->config->item('cache_flag', 'config_main') and $cacheData = $this->cache->get("$this->cache_id")) {
			//print "cache!";
			#echo $cacheData;
			
			$this->cache_output = TRUE;
			$this->output($cacheData);
			exit();
		}
		return TRUE;
	}
	
	
	/**
	 * キャッシュの保存
	 */
	protected function save_cache($data)
	{
		if(!$this->cache_id)
		{
			return FALSE;
		}
		
		if($this->cache and $this->config->item('cache_flag', 'config_main'))
		{
			$this->cache->save( "$this->cache_id", $data, $this->cahche_lifetime);
		}
	}

	
	
	
	
	/**
	 * ページネーション設定
	 */
	function generate_pagination($path, $total,$limit=10 , $uri_segment)
	{
		# ページネーションクラスをロードします。
		if($this->is_mobile)
		{
			# ページネーションクラスをロードします。
			$this->load->library('pagination_mobile');
			# リンク先のURLを指定します。
			$config['base_url']       = $path;
			# 総件数を指定します。
			$config['total_rows']     = $total;
			# 1ページに表示する件数を指定します。
			$config['per_page']       = $limit;
			# ページ番号情報がどのURIセグメントに含まれるか指定します。
			$config['uri_segment']    = $uri_segment;
			# 生成するリンクのテンプレートを指定します。
			$config['full_tag_open']  = '<div style="text-align:right;">';
			$config['full_tag_close'] = '</div>';
			
			$config['next_link'] = $this->emoji->Convert("F98C").'次の'.$limit."件";
			$config['next_tag_open'] = '';
			$config['next_tag_close'] = '';
			$config['prev_link'] = $this->emoji->Convert("F98A").'前の'.$limit."件";
			$config['prev_tag_open'] = '<br />';
			$config['prev_tag_close'] = '';
			
			# $configでページネーションを初期化します。
			$this->pagination_mobile->initialize($config);
			# 生成したリンクの文字列を返します。
			return $this->pagination_mobile->create_links();
		
		}
		elseif($this->view_smartphone)
		{
			$this->load->library('pagination');
			# リンク先のURLを指定します。
			$config['base_url']       = $this->config->site_url($path);
			# 総件数を指定します。
			$config['total_rows']     = $total;
			# 1ページに表示する件数を指定します。
			$config['per_page']       = $limit;
			# ページ番号情報がどのURIセグメントに含まれるか指定します。
			$config['uri_segment']    = $uri_segment;
			# 生成するリンクのテンプレートを指定します。
			$config['first_link']     = FALSE;
			#$config['first_tag_open'] = '&nbsp;<span class="pager_text">';
			#$config['first_tag_close'] = '</span>&nbsp;';
			$config['last_link']      = FALSE;
			#$config['last_tag_open'] = '&nbsp;<span class="pager_text">';
			#$config['last_tag_close'] = '</span>&nbsp;';
			
			$config['full_tag_open']  = '<div class="paging">';
			$config['full_tag_close'] = '</div>';
			$config['cur_tag_open'] = '<span class="current">';
			$config['cur_tag_close'] = '</span>';
			
			#$config['num_tag_open'] = '<span class="pager">&nbsp;';
			#$config['num_tag_close'] = '&nbsp;</span>';
			
			$config['next_link'] = 'Next&gt;';
			#$config['next_tag_open'] = '<span class="pager_text">';
			#$config['next_tag_close'] = '</span>';
			$config['prev_link'] = '&lt;Previous';
			#$config['prev_tag_open'] = '<span class="pager_text">';
			#$config['prev_tag_close'] = '</span>';
			
			$config['num_links'] = 1;
			
			$this->pagination->initialize($config);
			return $this->pagination->create_links();
		}
		else
		{
			$this->load->library('pagination');
			# リンク先のURLを指定します。
			$config['base_url']       = $this->config->site_url($path);
			# 総件数を指定します。
			$config['total_rows']     = $total;
			# 1ページに表示する件数を指定します。
			$config['per_page']       = $limit;
			# ページ番号情報がどのURIセグメントに含まれるか指定します。
			$config['uri_segment']    = $uri_segment;
			# 生成するリンクのテンプレートを指定します。
			$config['first_link']     = '&laquo; 最初';
			#$config['first_tag_open'] = '&nbsp;<span class="pager_text">';
			#$config['first_tag_close'] = '</span>&nbsp;';
			$config['last_link']      = '最後 &raquo;';
			#$config['last_tag_open'] = '&nbsp;<span class="pager_text">';
			#$config['last_tag_close'] = '</span>&nbsp;';
			
			$config['full_tag_open']  = '<div class="paging">';
			$config['full_tag_close'] = '</div>';
			$config['cur_tag_open'] = '<span class="current">';
			$config['cur_tag_close'] = '</span>';
			
			#$config['num_tag_open'] = '<span class="pager">&nbsp;';
			#$config['num_tag_close'] = '&nbsp;</span>';
            
			$config['next_link'] = 'Next &gt;';
			#$config['next_tag_open'] = '<span class="pager_text">';
			#$config['next_tag_close'] = '</span>';
			$config['prev_link'] = '&lt; Previous';
			#$config['prev_tag_open'] = '<span class="pager_text">';
			#$config['prev_tag_close'] = '</span>';
			
			$config['num_links'] = 4;
			
			$this->pagination->initialize($config);
			return $this->pagination->create_links();
		}
	}
	
	
	
	
	
	
	
}