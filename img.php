<?php

echo "<html>" . "\n";
echo "    <head>" . "\n";
echo "        <title>" . "\n";
echo "            Shoutcasthack No2 by bikmaek" . "\n";
echo "        </title>" . "\n";
echo "    </head>" . "\n";
echo "    <body>" . "\n";

// Serverdaten

    $scast_host = 'dashtec.de';
    $scast_name = 'ClubNation.fm';
    $scast_port = '9030';
    $scast_pass = 'Pilipili1972';

// Viewmodis

if ($_REQUEST['history']) {
    $show_sc_songhistory = 1;
}
else {
    $show_sc_songhistory = 0;
}
if ($_REQUEST['listener']) {
    $show_sc_listeners = 1;
}
else {
    $show_sc_listeners = 0;
}

// XML holen
    if($fp = @fsockopen($scast_host, $scast_port, $errno, $errstr, 30)) {
        if(fputs($fp, "GET /admin.cgi?pass=".$scast_pass."&mode=viewxml HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n")) {
            $xmldata = "";
            while(!feof($fp)) $xmldata .= fgets($fp, 1000);
            $xmldata = explode("\r\n", $xmldata);
            $xmldata = $xmldata[3];
        }
    }


// Regex Funktionen
    function get_item($name, $source) {
        preg_match('#<'.$name.'>(.*?)</'.$name.'>#', $source, $matches);
        return $matches[1];
    }
    function get_items($name, $source) {
        preg_match_all('#<'.$name.'>(.*?)</'.$name.'>#', $source, $matches);
        return $matches[1];
    }


// Werte aus XML auslesen
    $sc_stream_status = get_item("STREAMSTATUS", $xmldata);
    
    if($sc_stream_status) {
        $sc_stream_bitrate = get_item("BITRATE", $xmldata);
        $sc_listeners_cur  = get_item("CURRENTLISTENERS", $xmldata);
        $sc_listeners_peak = get_item("PEAKLISTENERS", $xmldata);
        $sc_listeners_max  = get_item("MAXLISTENERS", $xmldata);
        $sc_server_title   = get_item("SERVERTITLE", $xmldata);
        $sc_server_url     = get_item("SERVERURL", $xmldata);
        $sc_server_genre   = get_item("SERVERGENRE", $xmldata);
        $sc_server_version = get_item("VERSION", $xmldata);
        $sc_current_song   = get_item("SONGTITLE", $xmldata);
        $sc_irc            = get_item("IRC", $xmldata);
        $sc_icq            = get_item("ICQ", $xmldata);
        $sc_aim               = get_item("AIM", $xmldata);
    }
    if(!($sc_stream_bitrate)) {
        echo "        <h1>Sorry, aber Server ist offline!</h1>" . "\n";
    }
    else {
        
        echo $sc_current_song;
        if ($show_sc_songhistory) {
            echo "\n" . "        <h3>Songhistory</h3>" . "\n";
            echo "        <table border=1>" . "\n";
            
            $scast_songs = get_items("SONG", $xmldata);
            $count = 0;
            for($i=0; $i<count($scast_songs); $i++) 
            {
                
                $sc_song_playtime        = strftime("%d.%m.%y %H:%M", get_item("PLAYEDAT", $scast_songs[$i]));
                $sc_song_title            = get_item("TITLE", $scast_songs[$i]);
    
                echo "                <tr><td>$sc_song_playtime</td><td>$sc_song_title</td></tr>" . "\n";
            }
            echo "        </table>" . "\n";
        } else {
            $sc_songhistory = "";
        }
            
    
        if ($show_sc_listeners) {
            echo "\n" . "        <h3>Zuh&ouml;rer</h3>" . "\n";
            echo "        <table border=1>" . "\n";
            echo "                <tr><th>No.</th><th>Hostname</th><th>Useragent</th><th>Connecttime</th></tr>" . "\n";
            
            $scast_listeners = get_items("LISTENER", $xmldata);
            $count = 0;
    
            for($i=0; $i<count($scast_listeners); $i++) 
            {
                
                $sc_no                      = $i+1;
                $sc_hostname            = get_item("HOSTNAME", $scast_listeners[$i]);
                $sc_useragent            = get_item("USERAGENT", $scast_listeners[$i]);
                $sc_connecttime            = gmstrftime("%H:%M:%S", get_item("CONNECTTIME", $scast_listeners[$i]));
    
                echo "                <tr><td>$sc_no</td><td>$sc_hostname</td><td>$sc_useragent</td><td>$sc_connecttime</td></tr>" . "\n";
            }
            echo "        </table>" . "\n";
        } 
        else {
            $sc_listeners = "";
        }
    }

echo "    </body>" . "\n";
echo "</html>" . "\n";

?> 