<?php
function functionLoad($functionName) {
	$file_name = dirname(__FILE__).'/functions/'.$functionName.'.inc.php';
	if (is_file($file_name)) {
		require_once($file_name);
	}
	else {
		die('Function could not be found!');
	}
	if($functionName=='mobile_device_detect') {
		return mobile_device_detect(true,false,true,true,true,true,true,false,false);
	}
	else {
		$functionName();
	}
	
}

function main() {
	if (functionLoad(mobile_device_detect)) {
		if (isset($_GET['lang'])) {
			functionLoad(templateLoad);
		}
		else {
			functionLoad(langRedirect);
		}
		exit;
	}
	if (isset($_GET['request'])) {
		switch ($_GET['request']) {
			case 'facebook':
				functionLoad(getFacebookJson);
				break;
			case 'get':
				functionLoad(getFile);
				break;
		}
	}
	elseif (isset($_GET['lang'])) {
		functionLoad(templateLoad);
	}
	else {
		functionLoad(langRedirect);
	}
}
main();