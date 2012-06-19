<?php
function relocate() {
	header('Location: http://www.streamerspanel.com/');
	exit;
}
function is_facebook() {
	if(!(stristr($_SERVER["HTTP_USER_AGENT"],'facebook') === FALSE))
	return true;
}
function templateLoad() {
	require_once(dirname(__FILE__).'/../classes/template.class.php');
	if (is_file(dirname(__FILE__).'/../templates/'.$_GET['content'].'.inc.php')) {
		$template = new Template(dirname(__FILE__).'/../templates/'.$_GET['content'].'.inc.php');
		if(strlen($_GET['lang'])===2) {
			if (is_file(dirname(__FILE__).'/../languages/'.$_GET['lang'].'.inc.php')) {
				require_once(dirname(__FILE__).'/../languages/'.$_GET['lang'].'.inc.php');
				$html5url = 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
				if (is_file(dirname(__FILE__).'/../templates/_header.inc.php')) {
					$HeaderObject = new Template(dirname(__FILE__).'/../templates/_header.inc.php');
				}
				else {
					die('Header was not found!');
				}
				if (is_file(dirname(__FILE__).'/../templates/_footer.inc.php')) {
					$FooterObject = new Template(dirname(__FILE__).'/../templates/_footer.inc.php');
				}
				else {
					die('Footer was not found!');
				}
				if (is_facebook()) {
					$facebookObject = new Template(dirname(__FILE__).'/../templates/facebook.inc.php');
					foreach ($languageVar as $langKey => $langValue) {
						$facebookObject->set($langKey, $langValue);
					}
					$facebook_title = ucfirst(strtolower($_GET['content']));
					$facebookObject->set('facebook_title', $languageVar[$_GET['content'].'01']);
					$facebookOutput = $facebookObject->output();
					$facebook_head = ' xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
					$HeaderObject->set('facebook_head', $facebook_head);
					$HeaderObject->set('facebook_meta', $facebookOutput);
					$HeaderObject->set('facebookurl', $html5url);
				}
				else {
					$HeaderObject->set('facebook_head', NULL);
					$HeaderObject->set('facebook_meta', NULL);
				}
				foreach ($languageVar as $langKey => $langValue) {
					$HeaderObject->set($langKey, $langValue);
				}
				$HeaderObject->set('pagetitle', $languageVar[$_GET['content'].'01']);
				$HeaderObject->set('url', 'http://'.$_SERVER['HTTP_HOST']);
				$HeaderObject->set('lang', $_GET['lang']);
				foreach ($languageVar as $langKey => $langValue) {
					$FooterObject->set($langKey, $langValue);
				}
				$FooterObject->set('html5url', urlencode($html5url));
				$FooterObject->set('lang', strtolower($_GET['lang']));
				foreach ($languageVar as $langKey => $langValue) {
					$template->set($langKey, $langValue);
				}
				$template->set('url', 'http://'.$_SERVER['HTTP_HOST']);
				$template->set('lang', strtolower($_GET['lang']));
				$template->set('_header', $HeaderObject->output());
				$template->set('_footer', $FooterObject->output());
				echo 
					$template->output();
			}
			else 
				relocate();
		}
		else 
			relocate();
	}
	else 
		relocate();
}
