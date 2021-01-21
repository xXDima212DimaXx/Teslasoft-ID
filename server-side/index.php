<?php
$xsessionid = $_COOKIE['SessionID'];
$xuid = $_COOKIE['UserID'];
$xtime = $_COOKIE['LoginTZ'];
$xdevice = $_COOKIE['DeviceID'];

if (isset($_COOKIE['SessionID']) && isset($_COOKIE['LoginTZ']) && isset($_COOKIE['UserID']) && isset($_COOKIE['DeviceID'])) {
    $xsessionid = $_COOKIE['SessionID'];
    $xuid = $_COOKIE['UserID'];
    $xtime = $_COOKIE['LoginTZ'];
    $xsession = file_get_contents("./users/".$xuid."/security/session");
    
    /***************************** DEBUG
    echo $xsessionid."<br>";
    echo $xuid."<br>";
    echo $xtime."<br>";
    echo $xsession."<br>";
    echo ($xsession * $xtime)."<br>";
    *******************************/
    
    if ($xsessionid == ($xsession * $xtime)) {
        echo('<script>window.location.replace("https://cs.jarvis.studio/account/main");</script>');
    } else {
        unlogged();
    }
} else {
    unlogged();
}

function unlogged() {
    echo('<script>window.location.replace("https://cs.jarvis.studio/oauth?continue=https://cs.jarvis.studio/account/main&cancelable=false");</script>');
}
?>