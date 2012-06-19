<?php
function getFacebookJson() {
	ini_set('user_agent', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3');
	$rss_file = "http://www.facebook.com/feeds/page.php?id=120274938033985&format=rss20";
	$rss_feed = simplexml_load_file( $rss_file );
	if (strlen($rss_feed->channel->item[0]->title)<30)
		$outarray['title'] = trim($rss_feed->channel->item[0]->title);
	else
		$outarray['title'] = trim(substr($rss_feed->channel->item[0]->title, 0, 30));
		$outarray['title'].= '..';
	$outarray['time'] = trim($rss_feed->channel->item[0]->pubDate);
	$outarray['post'] = trim($rss_feed->channel->item[0]->description);
	$outarray['ahref'] = $rss_feed->channel->item[0]->guid;
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($outarray);
}