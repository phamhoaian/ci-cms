<?php
class Auth extends MY_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 3;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	public function __construct()
	{
        //$this->set_auth(TRUE);
        //$this->set_only_mobile(TRUE);
        //$this->set_only_pc(TRUE);
        
        //$this->set_pictgram(TRUE);
        //$this->set_test(TRUE);
        //$this->set_bench(TRUE);
        
        //$this->set_force_ssl('ON');
        
        //$this->set_iphone_view(TRUE);
        //$this->set_android_view(TRUE);
        
        parent::__construct();
        
		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		$this->load->library('Session');
		
		//$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->model('myauth_model');
		
		if(! $this->is_mobile)
		{
			$this->set_js("bootstrap-button.js");
		}
		
	}
	
	
	function _remap($method)
	{
		if($method == 'email_check' or $method == 'username_check' or $method == 'captcha_check' or $method == 'recaptcha_check')
		{
			$this->login();
		}
		elseif (method_exists('Auth',$method))
		{
			$this->$method();
		}
		else
		{
			$this->message("不正な処理が行われました");
			#$this->$method();
		}
	}
	
	
	
	function banned()
	{
		$this->message("こちらのIDではご利用できません。");
		#$this->$method();
	}
	
	
	
	
	
	
	
	
	function index()
	{
		$this->login();
	}
	
	/* Callback function */
	
	function username_check($username)
	{
		
		$result = $this->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->form_validation->set_message('username_check', 'このユーザー名はすでに使われています。別のユーザー名を入力してください');
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->form_validation->set_message('email_check', 'このメールアドレスは既に他のユーザーが使用しています。別のメールアドレスを選択してください');
		}
				
		return $result;
	}

	function captcha_check($code)
	{

		
		$result = TRUE;
		
		if ($this->dx_auth->is_captcha_expired())
		{
			// Will replace this error msg with $lang
			$this->form_validation->set_message('captcha_check', '確認コードが有効期限切れです。 再試行してください。');			
			$result = FALSE;
		}
		elseif ( ! $this->dx_auth->is_captcha_match($code))
		{
			$this->form_validation->set_message('captcha_check', '入力された文字が違っています。再度入力してください。');			
			$result = FALSE;
		}

		return $result;
	}
	
	function recaptcha_check()
	{
		$result = $this->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->form_validation->set_message('recaptcha_check', '入力された文字が違っています。再度入力してください。');
		}
		
		return $result;
	}
	
	/* End of Callback function */
	
	
	function login()
	{

		
		if ( ! $this->dx_auth->is_logged_in())
		{
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_error_delimiters('<div class="error"><strong><font color="#FF0000">*', '</font></strong></div>');
			$val->set_rules('username', 'メールアドレス', 'trim|valid_email|required|xss_clean');
			$val->set_rules('password', 'パスワード', 'trim|required|xss_clean');
			$val->set_rules('remember', 'Remember me', 'integer');

			// Set captcha rules if login attempts exceed max attempts in config
			if ($this->dx_auth->is_max_login_attempts_exceeded())
			{
				$val->set_rules('captcha', '画像文字', 'trim|required|xss_clean|callback_captcha_check');
			}
				
			if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))
			{
				
				
				// ログインが完了したので情報をセッションに保存する
				
				$this->load->model('dx_auth/user_profile', 'user_profile');
				
				
				// 生年月日を取得
				if($user_id = $this->dx_auth->get_user_id() and $user_profile = $this->user_profile->get_profile($user_id))
				{
					$user_profile = $user_profile->row();
					
					$session_ins = array();
					
					/*
					if($user_profile->birth_year and $user_profile->birth_month and $user_profile->birth_day)
					{
						$birth = sprintf("%04d%02d%02d", $user_profile->birth_year,$user_profile->birth_month,$user_profile->birth_day);
						$session_ins["birth"] = $birth;
					}
					
					// 性別
					if($user_profile->sex)
					{
						$session_ins["sex"] = $user_profile->sex;
					}
					
					// 血液型
					if($user_profile->blood)
					{
						$session_ins["blood"] = $user_profile->blood;
					}
					
					// 地域
					if($user_profile->pref)
					{
						$session_ins["pref"] = $user_profile->pref;
					}
					
					// 職種
					if($user_profile->work_type)
					{
						$session_ins["work_type"] = $user_profile->work_type;
					}
					
					// スポット１
					if($user_profile->spot1)
					{
						$session_ins["spot1"] = $user_profile->spot1;
					}
					*/
					
					
					$this->session->set_userdata($session_ins);
					
					
					
					
					// 情報をcookieに保存する
					/*
					if($val->set_value('remember'))
					{
					*/
						$this->load->helper('cookie');
						$cookie_expire = $this->config->item('cookie_expire', 'config_main');
						$this->load->library('encrypt');
						$cookie_username = $this->dx_auth->get_username().$this->config->item('cookie_tail', 'config_main');
					
						$cookie = array(
							'name'   => 'sf',
							'value'  => $this->encrypt->encode($cookie_username ),
							'expire' => $cookie_expire,
						);
						set_cookie($cookie); 
					/*
					}
					else
					{
						$this->load->helper('cookie');
						delete_cookie("sf"); 
					}
					*/
				}
				
				
				// 見ていたページへジャンプ
				$next_segment = $this->session->userdata('next_segment');
				$this->session->unset_userdata('next_segment');
				if(!$next_segment)
				{
					$next_segment = "user";
				}
				redirect("$next_segment", 'location');
			}
			else
			{
			
				// Check if the user is failed logged in because user is banned user or not
				if ($this->dx_auth->is_banned())
				{
					// Redirect to banned uri
					$this->dx_auth->deny_access('banned');
				}
				else
				{
					// Default is we dont show captcha until max login attempts eceeded
					$this->data['show_captcha'] = FALSE;
				
					// Show captcha if login attempts exceed max attempts in config
					if ($this->dx_auth->is_max_login_attempts_exceeded())
					{
						// Create catpcha
						$this->dx_auth->captcha();
						
						// Set view data to show captcha on view file
						$this->data['show_captcha'] = TRUE;
					}
					
					$this->data["message"] = "";
					if($this->security_clean($this->uri->segment(3, 0) =="page"))
					{
						$this->data["message"] = "<strong>こちらのページを見るにはログインが必要です</strong>";
					}
					
					
					$this->load_view($this->dx_auth->login_view,$this->data,TRUE);
				}
			}
		}
		else
		{
			//$this->data['auth_message'] = 'ログイン中です';
			// ログイン中なのでトップページに飛ばす
			redirect('/', 'refresh');
		}
	}
	
	function logout()
	{
		
		$this->session->unset_userdata();
		
		
		$this->dx_auth->logout();
		
		$this->load->helper('cookie');
		delete_cookie("sf"); 
		
		
		
		
		
		$this->data['auth_message'] = 'ログアウトが完了しました';		
		$this->load_view($this->dx_auth->logout_view,$this->data,TRUE);
	}
	
	function register()
	{
	
		if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
		{	
			$val = $this->form_validation;
			
			// Set form validation rules		
			$val->set_error_delimiters('<div class="error"><strong><font color="#FF0000">*', '</font></strong></div>');	
			$val->set_rules('username', 'ユーザー名', 'trim|required|xss_clean|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check');
			$val->set_rules('password', 'パスワード', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', 'パスワード(再入力)', 'trim|required|xss_clean');
			$val->set_rules('email', 'メールアドレス', 'trim|required|xss_clean|valid_email|callback_email_check');
			
			
			if ($this->dx_auth->captcha_registration)
			{
				$val->set_rules('captcha', '画像文字の入力', 'trim|xss_clean|required|callback_captcha_check');
			}
			
			
			

			// Run form validation and register user if its pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
			{
				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$this->data['auth_message'] = '仮登録が完了しました。正式登録するためのメールを送りました。';
				}
				else
				{					
					$this->data['auth_message'] = '登録が完了しました。'.anchor(site_url($this->dx_auth->login_uri), 'Login');
				}
				
				// ここでカスタマイズ情報を格納
				
				
				// Load registration success page
				$this->load_view($this->dx_auth->register_success_view, $this->data,TRUE);
			}
			else
			{
				// Is registration using captcha
				if ($this->dx_auth->captcha_registration)
				{
					$this->dx_auth->captcha();										
				}

				// Load registration page
				$this->load_view($this->dx_auth->register_view,null,TRUE);
			}
		}
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$this->data['auth_message'] = '現在登録を受け付けしていません。';
			$this->load_view($this->dx_auth->register_disabled_view, $this->data,TRUE);
		}
		else
		{
			$this->data['auth_message'] = '登録する前に、ログアウトをしてください。';
			$this->load_view($this->dx_auth->logged_in_view, $this->data);
		}
	}
	
	
	
	

	
	function activate()
	{
	
		// Get username and key
		//$username = $this->security_clean($this->uri->segment(3));
		$key = $this->security_clean($this->uri->segment(3));
		
		
		
		
		if(!$key)
		{
			$this->message("不正な処理が行われました");
		}
		
		
		
		if(!$user_tmp=$this->myauth_model->get_one_user_temp_by_key($key)){
			$this->message("不正な処理が行われました(code=2)");
		}
		
		
		

		
		$this->data["username"] = $user_tmp->username;
		$this->data["key"] = $key;			
		
		if($this->is_mobile)
		{
			$this->data["username"] = mb_convert_encoding($this->data["username"], 'UTF-8', 'SJIS-win');
		}
		
		

			// Activate user
			if ($this->dx_auth->activate($this->data["username"], $key)) 
			{
				
				$this->load->model('dx_auth/user_profile', 'user_profile');
				
				$user_id = $this->myauth_model->get_one_user_id_by_username($this->data["username"]);
				
				// Create user profile
				
				$this->data['auth_message'] = '登録が完了しました<br />'.anchor(site_url($this->dx_auth->login_uri), 'ログイン');
				$this->load_view($this->dx_auth->activate_success_view, $this->data,TRUE);
			}
			else
			{
				$this->data['auth_message'] = '不正な処理が行われました(code=3)';
				$this->load_view($this->dx_auth->activate_failed_view, $this->data,TRUE);
			}

		
		
		
		

	}
	
	
	
	
	function forgot_password()
	{
	
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_error_delimiters('<div class="error"><strong><font color="#FF0000">*', '</font></strong></div>');	
		$val->set_rules('login', 'メールアドレス', 'trim|valid_email|required|xss_clean');
		
		
		/*
		$val->set_rules('year', '年', 'trim|integer|exact_length[4]|required|xss_clean');
		$val->set_rules('month', '月', 'trim|integer|min_length[1]|max_length[2]|required|xss_clean');
		$val->set_rules('day', '日', 'trim|integer|min_length[1]|max_length[2]|integer|required|xss_clean');
		*/
		
		// Validate rules and call forgot password function
		#if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
		if ($val->run())
		{
			
			
			if(!$tmp_id = $this->myauth_model->get_one_user_id_by_email($val->set_value('login')))
			{
				$this->message("ユーザーが存在しません。正しいメールアドレスと生年月日を入力してください");
				exit;
			}
			
			/*
			if(!$this->myauth_model->get_one_user_profile_forgot_password($tmp_id,$val->set_value('year'),$val->set_value('month'),$val->set_value('day')))
			{
				$this->message("ユーザーが存在しません。正しいメールアドレスと生年月日を入力してください");
				exit;
			}
			*/
			
			if($this->dx_auth->forgot_password($val->set_value('login')))
			{
				$this->data['auth_message'] = '新しいパスワードを記載したメールを送りました';
				$this->load_view($this->dx_auth->forgot_password_success_view, $this->data,TRUE);
			}
			else
			{
				$this->message("不正な処理が行われました");
				exit;
			}
		}
		else
		{
			
			$this->load_view($this->dx_auth->forgot_password_view,TRUE);
		}
	}
	
	
	
	
	
	function reset_password()
	{
		// Get username and key
		//$username = $this->uri->segment(3);
		//$key = $this->uri->segment(3);
		
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);
		$username = rawurldecode($username);
		
		
		// Reset password
		if ($this->dx_auth->reset_password($username, $key))
		{
			$this->data['auth_message'] = 'パスワードが再発行されました<br />'.anchor(site_url($this->dx_auth->login_uri), 'ログイン');
			$this->load_view($this->dx_auth->reset_password_success_view, $this->data,TRUE);
		}
		else
		{
			$this->data['auth_message'] = '不正な処理が行われました';
			$this->load_view($this->dx_auth->reset_password_failed_view, $this->data,TRUE);
		}
	}
	
	function change_password()
	{
	
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_error_delimiters('<div class="error"><strong><font color="#FF0000">*', '</font></strong></div>');	
			$val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$this->data['auth_message'] = 'パスワードの変更が完了しました';
				$this->load_view($this->dx_auth->change_password_success_view, $this->data,TRUE);
			}
			else
			{
				$this->load_view($this->dx_auth->change_password_view,TRUE);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
	
	function cancel_account()
	{
	
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('password', 'Password', "trim|required|xss_clean");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				//redirect('', 'location');
				
				$this->message("ご利用ありがとうございました。");
				return FALSE;
			}
			else
			{
				$this->load_view($this->dx_auth->cancel_account_view,TRUE);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	
	
	// アクセス拒否
	function deny()
	{

		
		$this->data['auth_message'] = 'アクセスが拒否されました';
		$this->load_view($this->dx_auth->logout_view,$this->data,TRUE);
		//redirect('', 'location');
	}
	
	
	
	
	
}
?>