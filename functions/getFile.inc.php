<?php
define('sapVersion_3beta', 	'WallCityServer_SC_Admin_MULTI_3_1.zip');
define('sapVersion_2', 		'WallCityServer_SC_Admin_GERMAN_2_2.zip');
define('sapVersion_1', 		'WallCityServer_SC_Admin_GERMAN_1_2.zip');
define('jin_de', '01_streamers_admin_panel_-_advertisement_jingle_de.zip');
define('jin_en', '02_streamers_admin_panel_-_advertisement_jingle_en.zip');

function s3Download() {
	$cloud_server_number=rand(1,9);
	switch($_GET['ver']) {
		case 'latest':
		case '3beta':
			header('Location: http://s'.$cloud_server_number.'.streamerspanel.com/mirror/'.sapVersion_3beta);
			break;
		case '2':
			header('Location: http://s'.$cloud_server_number.'.streamerspanel.com/mirror/'.sapVersion_2);
			break;
		case '1':
			header('Location: http://s'.$cloud_server_number.'.streamerspanel.com/mirror/'.sapVersion_1);
			break;
		case 'jin_de':
			header('Location: http://s'.$cloud_server_number.'.streamerspanel.com/mirror/audio/'.jin_de);
			break;
		case 'jin_en':
			header('Location: http://s'.$cloud_server_number.'.streamerspanel.com/mirror/audio/'.jin_en);
			break;
		default:
			header('Location: http://www.streamerspanel.com/');
			break;
	}
	exit;
}
function sapDownload() {
	global $sapVersion_3;
	global $sapVersion_2;
	global $sapVersion_1;
	switch($_GET['ver']) {
		case 'latest':
		case '3beta':
			header('Location: http://www.streamerspanel.com/files/'.sapVersion_3beta);
			break;
		case '2':
			header('Location: http://www.streamerspanel.com/files/'.sapVersion_2);
			break;
		case '1':
			header('Location: http://www.streamerspanel.com/files/'.sapVersion_1);
			break;
		default:
			header('Location: http://www.streamerspanel.com/');
			break;
	}
	exit;
}
function getFile() {
	switch ($_GET['download']) {
		case 's3':
			s3Download();
			break;
		case 'sap':
			sapDownload();
			break;
		default:
			header('Location: http://www.streamerspanel.com/');
			exit;
			break;
	}
}
