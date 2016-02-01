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



