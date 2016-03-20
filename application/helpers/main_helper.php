<?php
/**
 * by  Makoto Haba
 */


if ( ! function_exists('h'))
{
    function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}

if (!function_exists('key2like')) {
	function key2like($str) {
		$str = trim($str);
		$str = str_replace('　', ' ', $str);
		$str = str_replace('+', ' ', $str);
		$like = array();
		foreach (explode(' ', $str) as $key) {
			$key = trim($key);
			if ($key === '')
				continue;
			if (!in_array($key, $like))
				$like[] = $key;
		}
		return $like;
	}
}

if (!function_exists('title2alias')) {
    function title2alias($str) {
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), remove_accent($str))); 
    }
}

if (!function_exists('remove_accent')) {
    function remove_accent($str) 
    { 
        $a = array(
            'á','é','í','ó','ú','ý','Á','É','Í','Ó','Ú','Ý',
            'à','è','ì','ò','ù','ỳ','À','È','Ì','Ò','Ù','Ỳ',
            'ả','ẻ','ỉ','ỏ','ủ','ỷ','Ả','Ẻ','Ỉ','Ỏ','Ủ','Ỷ',
            'ã','ẽ','ĩ','õ','ũ','ỹ','Ã','Ẽ','Ĩ','Õ','Ũ','Ỹ',
            'ạ','ẹ','ị','ọ','ụ','ỵ','Ạ','Ẹ','Ị','Ọ','Ụ','Ỵ',
            'â','ê','ô','ư','Â','Ê','Ô','Ư',
            'ấ','ế','ố','ứ','Ấ','Ế','Ố','Ứ',
            'ầ','ề','ồ','ừ','Ầ','Ề','Ồ','Ừ',
            'ẩ','ể','ổ','ử','Ẩ','Ể','Ổ','Ử',
            'ậ','ệ','ộ','ự','Ậ','Ệ','Ộ','Ự'
                ); 
        $b = array(
            'a','e','i','o','u','y','A','E','I','O','U','Y',
            'a','e','i','o','u','y','A','E','I','O','U','Y',
            'a','e','i','o','u','y','A','E','I','O','U','Y',
            'a','e','i','o','u','y','A','E','I','O','U','Y',
            'a','e','i','o','u','y','A','E','I','O','U','Y',
            'a','e','o','u','A','E','O','U',
            'a','e','o','u','A','E','O','U',
            'a','e','o','u','A','E','O','U',
            'a','e','o','u','A','E','O','U',
            'a','e','o','u','A','E','O','U'
        ); 
        return str_replace($a, $b, $str); 
    }
}
