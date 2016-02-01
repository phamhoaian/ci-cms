<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MobileMyClass
{
    private $_ua        = NULL;

    private $_carrier   = 'Nonmobile';

    private $_is_mobile = FALSE;
    
    private $_is_iphone = FALSE;
    
    private $_is_android = FALSE;
    
    private $_is_windowsphone = FALSE;
    
    private $_is_smartphone = FALSE;
    
    private $_is_tablet = FALSE;
    
    private $_is_ipad = FALSE;


    private $CI;
    

    /**
     * constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        //autoloadで読み込んでいない場合
        #$this->CI->load->library('user_agent');
        #$this->_ua    = $this->CI->agent->agent_string();
        
        if(isset($_SERVER['HTTP_USER_AGENT']))
        {
        	$this->_ua = trim($_SERVER['HTTP_USER_AGENT']);
        }
        
        $this->_init();
    }


    public function is_mobile()
    {
        return $this->_is_mobile;
    }
    
    
    public function is_iphone()
    {
        return $this->_is_iphone;
    }
    
    public function is_android()
    {
        return $this->_is_android;
    }
    
    public function is_android_spmode()
    {
        return $this->_is_android_spmode;
    }
    
    public function is_windowsphone()
    {
        return $this->_is_windowsphone;
    }
    
    public function is_smartphone()
    {
        return $this->_is_smartphone;
    }
    
    public function is_tablet()
    {
        return $this->_is_tablet;
    }
    
    public function is_ipad()
    {
        return $this->_is_ipad;
    }


    public function get_agent()
    {
        return $this->_ua;

    }


    private function _set_carrier($carrier)
    {
        $this->_carrier = $carrier;
    }

    public function get_carrier()
    {
        return $this->_carrier;
    }

    
    /**
     *
     * @access private
     */
    private function _init()
    {
        // DoCoMo
        if ( ! strncmp($this->_ua, 'DoCoMo', 6))
        {
            $this->_set_carrier("docomo");
            $this->_is_mobile = TRUE;
        }

        // Vodafone(PDC)
        else if (preg_match("/^(J-PHONE)/i", $this->_ua))
        {
            $this->_set_carrier("softbank");
            $this->_is_mobile = TRUE;
        }
        // Vodafone(3G)
        //* Up.Browser を搭載しているものがある(auより先に評価)
        else if ( ! strncmp($this->_ua, 'Vodafone', 8))
        {
            $this->_set_carrier("softbank");
            $this->_is_mobile = TRUE;
        }
        // SoftBank
        else if ( ! strncmp($this->_ua, 'SoftBank', 8))
        {
            $this->_set_carrier("softbank");
            $this->_is_mobile = TRUE;
        }
        // SoftBank mot
        else if (preg_match("/^(MOT\-[CV]|Semulator)/i", $this->_ua))
        {
            $this->_set_carrier("softbank");
            $this->_is_mobile = TRUE;
        }
        // au
        else if ( ! strncmp($this->_ua, 'KDDI', 4))
        {
            $this->_set_carrier("au");
            $this->_is_mobile = TRUE;
        }
        // au
        else if ( ! strncasecmp($this->_ua, 'up.browser', 10))
        {
            $this->_set_carrier("au");
            $this->_is_mobile = TRUE;
        }

        // WILLCOM / DDIPOCKET
        else if (strpos($this->_ua, 'WILLCOM') !== false
             || strpos($this->_ua, 'SHARP/WS') !== false
             || strpos($this->_ua, 'DDIPOCKET') !== false)
        {
            $this->_set_carrier("willcom");
            #$this->_is_mobile = TRUE;
        }

        // emobile 携帯電話
        else if (strpos($this->_ua, 'emobile') !== false OR stristr($this->_ua, 'Huawei') != false)
        {
            $this->_set_carrier("emobile");
            #$this->_is_mobile = TRUE;
        }
        else if (isset($_SERVER['HTTP_X_EM_UID']) && $_SERVER["HTTP_X_EM_UID"] <> '')
        {
            $this->_set_carrier("emobile");
            #$this->_is_mobile = TRUE;
        }
        
        
        // iPhone
        else if (strpos($this->_ua, 'iPhone') !== false)
        {
            //$this->_set_carrier("softbank");
            //$this->_is_mobile = FALSE;
            $this->_is_iphone = TRUE;
            $this->_is_smartphone = TRUE;
        }
        // iPod
        else if (strpos($this->_ua, 'iPod') !== false)
        {
            //$this->_set_carrier("softbank");
            //$this->_is_mobile = FALSE;
            $this->_is_iphone = TRUE;
            $this->_is_smartphone = TRUE;
        }
        
        // iPad
        else if (strpos($this->_ua, 'iPad') !== false)
        {
            //$this->_is_mobile = FALSE;
            $this->_is_ipad = TRUE;
            
            $this->_is_tablet = TRUE;
        }
        
        
        // android
        else if (strpos($this->_ua, 'Android') !== false)
        {
            //$this->_is_mobile = FALSE;
            $this->_is_android = TRUE;
            
            // とりあえずAndoroidはスマートフォンとみなす（あとで必ず修正）
            $this->_is_smartphone = TRUE;
        }
        
        // windows phone
        else if (strpos($this->_ua, 'Windows Phone OS') !== false)
        {
            //$this->_is_mobile = FALSE;
            $this->_is_windowsphone = TRUE;
            
            // とりあえずAndoroidはスマートフォンとみなす（あとで必ず修正）
            $this->_is_smartphone = TRUE;
        }
        
		// モバイル用クローラー(googleはドコモ携帯として判別)
        else if (strpos($this->_ua, 'Googlebot-Mobile') !== false)
        {
            $this->_set_carrier("docomo");
            $this->_is_mobile = TRUE;
        }
		
		// モバイル用クローラー(yahooはsoftbank携帯として判別)
        else if ( strpos($this->_ua, 'Y!J-SRD') !== false || strpos($this->_ua, 'Y!J-MBS') !== false )
        {
            $this->_set_carrier("softbank");
            $this->_is_mobile = TRUE;
        }
        
    }
    
    

    //携帯の場合文字コードを変更する
    //SoftBankはUTF-8であればいらない
    private function _convert_encoding($arr)
    {
        if ($this->_carrier !== 'softbank')
        {
            return is_array($arr) ? array_map(array(&$this, '_convert_encoding'), $arr) :
                                mb_convert_encoding($arr, 'UTF-8', 'SJIS-win,Shift-JIS');
        }
        else
        {
            //return is_array($arr) ? array_map(array(&$this, '_convert_encoding'), $arr) :  mb_convert_encoding($arr, 'UTF-8', 'SJIS-win,Shift-JIS');
            //UTFで受け取っているので変換しない
        }
    }

    //携帯の絵文字コードを内部形式に変更する
    private function _convert_pictgram($arr)
    {
        return is_array($arr) ? array_map(array(&$this, '_convert_pictgram'), $arr) :
                                emoji_escape($arr);

    }

    //携帯の入力を内部文字コードに変換するとともに、絵文字コードを変換する
    public function mobile_convert()
    {
        $_GET     = $this->_convert_pictgram($_GET);
        $_POST    = $this->_convert_pictgram($_POST);
        $_REQUEST = $this->_convert_pictgram($_REQUEST);
        $_GET     = $this->_convert_encoding($_GET);
        $_POST    = $this->_convert_encoding($_POST);
        $_REQUEST = $this->_convert_encoding($_REQUEST);
        return TRUE;
    }

}
?>
