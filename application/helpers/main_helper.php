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

