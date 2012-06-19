<?php
function langRedirect() {
	header("HTTP/1.1 301 Moved Permanently");
	$browser_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$lang_code = substr($browser_lang, 0, 2);
	$language_file = dirname(__FILE__) . '/../languages/'.$lang_code.'.inc.php';
	if (is_file($language_file)) {
		header('Location: http://www.streamerspanel.com/'.$lang_code.'/home/');
	}
	else {
		header('Location: http://www.streamerspanel.com/en/home/');
	}
	exit();
}