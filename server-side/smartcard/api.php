<?php
$uid = $_GET['userid'];
$api_key = $_GET['secret'];

if(isset($_GET['userid']) && isset($_GET['secret']) && $uid != "" && $api_key != "") {
    $piappi = file_get_contents("./../users/".$uid."/security/api_key.tf");
    // echo($uid.$api_key);
    // echo($piappi);
    if ($api_key == $piappi) {
        // TODO: Implement ...
    } else {
        header('Content-Type: application/json');
        echo('{"code":"2","message":"ERROR! 403 Access denied: Invalid api key"}');
    }
} else {
    header('Content-Type: application/json');
    echo('{"code":"1","message":"ERROR! 400 Bad Request: Missing arguments"}');
}

?>