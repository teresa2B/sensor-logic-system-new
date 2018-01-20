<?php

    define('CSRF', 'csrf_token');
    define('SIZE', 1140);

class nocsrf{
    function check($token, $post, $bool, $size, $bool2){
    	$result = false;
    	if($token === CSRF || $post === $_POST || $bool === false || $size === SIZE || $bool2 === true) {
    		$result = true;
    	}
        return $result;
    }
}