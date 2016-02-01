<?php

/**
 * Data class
 * m.haba
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Data_help_library {


    function nl2br_p($str)
    {
		#$CI =& get_instance();	
		#$CI->load->library('typography');
		
		$str = str_replace(array("\r\n", "\r"), "\n", $str);
		$str = str_replace("\n\n", "</p><p>", $str);
		$str = str_replace("\n", "<br />\n", $str);
		$str = str_replace("</p><p>", "</p>\n\n<p>", $str);
		
		$str = "<p>".$str."</p>";
		
		$str = str_replace(array("<br /><br />", "<p></p>","<br />\n<br />"), "", $str);
		$str = str_replace("/p><p", "/p>\n\n<p", $str);

		return $str;
    }


    function nl2br_reverse($str)
    {
		$str = str_replace(array("<p>", "</p>", "<br />"), "", $str);
		return $str;
    }


    function reverse_array($str)
    {
		$str = htmlspecialchars_decode($str);
		$str = unserialize($str);
		return $str;
    }


	#
	# 数字の整形
	#
	function get_int_dispose($tmp_int,$keta=2,$rev=""){
		$tmp = mb_convert_kana($tmp_int,"akR");
		if (strlen($tmp) < $keta) {
			$str = $keta-strlen($tmp);
			if($rev){
				for ($i=0; $i<$str; $i++) $tmp = $tmp.' ';
			}else{
				for ($i=0; $i<$str; $i++) $tmp = ' '.$tmp;
			}
		}
		return $tmp;
	}



	#
	# 数字の整形(桁数が少ないときに0と追加して合わせる)
	#
	function get_int_dispose_zero($tmp_int,$keta=2){
		$tmp = mb_convert_kana($tmp_int,"akR");
		if (strlen($tmp) < $keta) {
			$str = $keta-strlen($tmp);
			for ($i=0; $i<$str; $i++) $tmp = '0'.$tmp;
		}
		return $tmp;
	}

	# 12桁の数字から日付を取得する （$scopeは year day hour minute）
    function get_date_format($str,$scope="minute")
    {
		if ( preg_match("/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})$/", $str, $this->regs) ){
			$this->year = $this->regs[1];
			$this->month = $this->regs[2];
			$this->day = $this->regs[3];
			$this->hour = $this->regs[4];
			$this->minute = $this->regs[5];
			
			if($scope =="day"){
				$str = (int)$this->month."/".(int)$this->day;
			}elseif($scope =="hour"){
				$str = (int)$this->month."/".(int)$this->day." ".(int)$this->hour."時";
			}elseif($scope =="minute"){
				$str = (int)$this->month."/".(int)$this->day." ".(int)$this->hour.":".(int)$this->minute;
			}elseif($scope =="year"){
				$str = $this->year."/".(int)$this->month."/".(int)$this->day." ".(int)$this->hour.":".$this->minute;
			}else{
				$str = "";
			}
			
		}else{
			$str = "";
		}
		return $str;
    }
    
    
    
    
    
    //
	// 日付のフォーマットを返す(mysqlのdatetime用)
	//
	function get_datetime_format($timestamp,$format='daytime')
	{
		if( ! preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/s", $timestamp ,$regex))
		{
			return FALSE;
		}
		
		
		if( $format == 'daytime' )
		{
			return $regex[2]."/".$regex[3]." ".$regex[4].":".$regex[5];
		}
		else
		{
			return $regex[1]."/".$regex[2]."/".$regex[3]." ".$regex[4].":".$regex[5];
		}
	}
    
    
    
    
    
    
    


	function truncate($string, $length = 80, $etc = '...', $break_words = true)
	{
		if ($length == 0)
			return '';
		
		
		$string = $this->delete_emoji_tag($string);
		$string = strip_tags($string);
		
		
		$from = array('&amp;', '&lt;', '&gt;', '&quot;', '&#039;',"\r","\n");
		$to   = array('&', '<', '>', '"', "'",'','');
		$string = str_replace($from, $to, $string);
		
		if (strlen($string) > $length) {
			$length -= strlen($etc);
			if (!$break_words)
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));

			$string = mb_strimwidth($string, 0, $length) . $etc;
		}
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}


    function get_one_paragraph($str)
    {
    	$str_return = "";
    	if ( preg_match("/^(.*)\n\n/", $str, $this->regs) ){
    		$str_return = $this->regs[1];
    	}else{
    		$str_return = $this->truncate($str,"100");
    	}
    	return $str_return;
    }


    function get_one_sentence($str)
    {
    	$str_return = "";
    	$str = $this->truncate($str,"160");
    	if ( preg_match("/^(.*?。).*/", $str, $this->regs) ){
    		$str_return = $this->regs[1];
    	}else{
    		#$str_return = $this->truncate($str,"100");
    		$str_return = $str;
    	}
    	return $str_return;
    }





    function delete_emoji_tag($str)
    {
    	$moji_pattern = '/\[([ies]:[0-9]{1,3})\]/';
    	return preg_replace($moji_pattern,'', $str);
    }
	




	
    function change_price_unit($price,$unit="million",$precision=2)
    {
		if($unit == "million")
		{
			$price = $price/ 10000;
			$price = round($price, $precision,PHP_ROUND_HALF_EVEN);
		}
		
		
		return $price;
    }
	


	// datetime型を○○年第○四半期と変換する
    function get_quarter_by_datetime($datetime)
    {
    	if ( preg_match("/^(\d{4})-(\d{1,2})-.*/", $datetime, $regs) ){
    		//print_r($regs);
			$year = $regs[1];
			$quarter_tmp = (int)$regs[2];
			
			if($quarter_tmp <= 3)
			{
				$quarter = 1;
			}
			else if($quarter_tmp <= 6)
			{
				$quarter = 2;
			}
			else if($quarter_tmp <= 9)
			{
				$quarter = 3;
			}
			else if($quarter_tmp <= 12)
			{
				$quarter = 4;
			}
			else
			{
				return false;
			}
			
			return $year."年第".$quarter."四半期";
			
    	}else{
    		return $datetime;
    	}
    }
	

}

?>