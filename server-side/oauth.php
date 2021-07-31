<?php
$xsessionid = $_COOKIE['SessionID'];
$xuid = $_COOKIE['UserID'];
$xtime = $_COOKIE['LoginTZ'];
$xdevice = $_COOKIE['DeviceID'];
$continue = $_GET['continue'];
$cancelable = $_GET['cancelable'];

$cn = <<<EOL
<script>window.location.replace("$continue")</script>
EOL;

/*if (isset($_COOKIE['SessionID']) && isset($_COOKIE['LoginTZ']) && isset($_COOKIE['UserID']) && isset($_COOKIE['DeviceID'])) {
    $xsessionid = $_COOKIE['SessionID'];
    $xuid = $_COOKIE['UserID'];
    $xtime = $_COOKIE['LoginTZ'];
    $xsession = file_get_contents("./users/".$xuid."/security/session");
    
    /***************************** DEBUG/
    echo $xsessionid."<br>";
    echo $xuid."<br>";
    echo $xtime."<br>";
    echo $xsession."<br>";
    echo ($xsession * $xtime)."<br>";
    *******************************/
    
    /*if(isset($_GET['continue'])) {
        setcookie("continue", $continue, time() + (3600 * 24), "/", "cs.jarvis.studio", 1);
        if ($continue == "https://" || $continue == "http://") {
            echo '<script>window.location.replace("https://id.teslasoft.org/account/main")</script>';
        } else {
            echo $cn;
        }
    } else if ($xsessionid == ($xsession * $xtime)) {
        echo '<script>window.location.replace("https://id.teslasoft.org/account/main")</script>';
    } else {
        
    }
} else {
    
}*/

$smartcard_err = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <link rel = "icon" href = "https://id.teslasoft.org/smartcard/id.png">
        <title>Teslasoft ID</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #323232;
                user-select: none;
            }
            
            .page {
                padding-top: 60px;
                min-height: 60px;
                background-color: #121212;
            }
            
            p, span {
                color: #fafafa;
                font-size: 16px;
                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }
            
            p::selection, span::selection {
                color: #000000;
                background: #fafafa;
            }
            
            a {
                text-decoration: none;
                padding: 0;
                margin: 0;
            }
            
            .action-button {
                width: 100%;
                height: 40px;
                margin-start: 4px;
                border-radius: 4px;
                border: none;
                outline: none;
                transition: 0.3s;
                color: #ffffff;
            }
            
            .btn-green {
                background-color: rgba(46, 139, 86, 0.8);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.05);
            }
            
            .btn-green:active {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:focus {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:hover {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-aqua {
                background-color: rgba(0, 255, 255, 0.8);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.05);
            }
            
            .btn-aqua:active {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:focus {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:hover {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-red {
                background-color: rgba(242, 0, 40, 0.8);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.05);
            }
            
            .btn-red:active {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:focus {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:hover {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .login-form {
                margin: 36px auto;
                padding: 36px;
            }
            
            .header {
                margin: auto;
                font-family: sans-serif;
                color: #cecece;
                user-select: none;
                outline: none;
                text-align: center;
                background-color: none;
                font-size: 36px;
            }
            
            .public-icon {
                width: 90px;
                height: 90px;
                margin-left: calc(50% - 45px);
                margin-top: 36px;
                margin-bottom: 36px;
                outline: none;
            }
            
            .h {
                margin: auto;
                text-align: center;
            }
            
            .br {
                margin-top: 16px;
            }
        </style>
    </head>
    <body>
        <div = "h">
            <img class = "public-icon" src = "https://id.teslasoft.org/smartcard/id.png">
            <p class = "header">Teslasoft ID</p>
        </div>
        <div class = "login-form">
            <p style = "color: red; text-align: center;">Unfortunetly Teslasoft ID isn't supported on this device.</p>
            <p style = "color: #cecece; text-align: center;">Now Teslasoft ID is supported on Android devices Only.</p>
            <p style = "color: #cecece; text-align: center;">If you see this on Android please enable NFC or make sure if NFC is supported by your device.</p>
            <br>
            <p style = "color: #ffff00; text-align: center;">Also you need to switch to mobile view.</p>
            <br>
            <p style = "color: #ffff00; text-align: center;">You can login with email:</p>
            <a href="https://teslasoft.org/ServiceLogin?did=id.teslasoft.org&lang=en_US&c=$continue"><button class = "action-button btn-green br">Continue with Jarvis Account</button></a>
        </div>
    </body>
</html>
EOL;

if(isset($_GET['continue'])) {
    $continue = $_GET['continue'];
    setcookie("continue", $continue, time() + (3600 * 24), "/", "cs.jarvis.studio", 1);
}

$smartcard_url = "";
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) { // && stripos($ua,'mobile') !== false) {
    $smartcard_url = "intent://id.teslasoft.org/smartcard/open#Intent;scheme=https;package=com.teslasoft.id.smartcard;S.cont=".$continue.";end";
} else {
    echo($smartcard_err);
    exit();
}

$app = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <link rel = "icon" href = "https://id.teslasoft.org/smartcard/id.png">
        <title>Teslasoft ID</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #323232;
            }
            
            .page {
                padding-top: 60px;
                min-height: 60px;
                background-color: #121212;
            }
            
            p, span {
                color: #fafafa;
                font-size: 16px;
                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }
            
            p::selection, span::selection {
                color: #000000;
                background: #fafafa;
            }
            
            a {
                text-decoration: none;
                padding: 0;
                margin: 0;
            }
            
            .action-button {
                width: 100%;
                height: 40px;
                margin-start: 4px;
                border-radius: 4px;
                border: none;
                outline: none;
                transition: 0.3s;
                color: #ffffff;
            }
            
            .btn-green {
                background-color: rgba(46, 139, 86, 0.8);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.05);
            }
            
            .btn-green:active {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:focus {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:hover {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-aqua {
                background-color: rgba(0, 255, 255, 0.8);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.05);
            }
            
            .btn-aqua:active {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:focus {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:hover {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-red {
                background-color: rgba(242, 0, 40, 0.8);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.05);
            }
            
            .btn-red:active {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:focus {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:hover {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .login-form {
                margin: 36px auto;
                padding: 36px;
            }
            
            .header {
                margin: auto;
                font-family: sans-serif;
                color: #cecece;
                user-select: none;
                outline: none;
                text-align: center;
                background-color: none;
                font-size: 36px;
            }
            
            .public-icon {
                width: 90px;
                height: 90px;
                margin-left: calc(50% - 45px);
                margin-top: 36px;
                margin-bottom: 36px;
                outline: none;
            }
            
            .h {
                margin: auto;
                text-align: center;
            }
            
            .br {
                margin-top: 16px;
            }
        </style>
    </head>
    <body>
        <div = "h">
            <img class = "public-icon" src = "https://id.teslasoft.org/smartcard/id.png">
            <p class = "header">Teslasoft ID</p>
        </div>
        <div class = "login-form">
            <a href="$smartcard_url"><button class = "action-button btn-aqua">Login with SmartCard</button></a>
            <a href="https://teslasoft.org/ServiceLogin?did=id.teslasoft.org&lang=en_US&c=$continue"><button class = "action-button btn-green br">Continue with Jarvis Account</button></a>
            <button class = "action-button btn-red br" onclick = "javascript:history.back()">Back to App</button>
        </div>
    </body>
</html>
EOL;

$smartcard_only = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <link rel = "icon" href = "https://id.teslasoft.org/smartcard/id.png">
        <title>Teslasoft ID</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #323232;
            }
            
            .page {
                padding-top: 60px;
                min-height: 60px;
                background-color: #121212;
            }
            
            p, span {
                color: #fafafa;
                font-size: 16px;
                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }
            
            p::selection, span::selection {
                color: #000000;
                background: #fafafa;
            }
            
            a {
                text-decoration: none;
                padding: 0;
                margin: 0;
            }
            
            .action-button {
                width: 100%;
                height: 40px;
                margin-start: 4px;
                border-radius: 4px;
                border: none;
                outline: none;
                transition: 0.3s;
                color: #ffffff;
            }
            
            .btn-green {
                background-color: rgba(46, 139, 86, 0.8);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.05);
            }
            
            .btn-green:active {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:focus {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:hover {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-aqua {
                background-color: rgba(0, 255, 255, 0.8);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.05);
            }
            
            .btn-aqua:active {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:focus {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:hover {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-red {
                background-color: rgba(242, 0, 40, 0.8);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.05);
            }
            
            .btn-red:active {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:focus {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:hover {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .login-form {
                margin: 36px auto;
                padding: 36px;
            }
            
            .header {
                margin: auto;
                font-family: sans-serif;
                color: #cecece;
                user-select: none;
                outline: none;
                text-align: center;
                background-color: none;
                font-size: 36px;
            }
            
            .public-icon {
                width: 90px;
                height: 90px;
                margin-left: calc(50% - 45px);
                margin-top: 36px;
                margin-bottom: 36px;
                outline: none;
            }
            
            .h {
                margin: auto;
                text-align: center;
            }
            
            .br {
                margin-top: 16px;
            }
        </style>
    </head>
    <body>
        <div = "h">
            <img class = "public-icon" src = "https://id.teslasoft.org/smartcard/id.png">
            <p class = "header">Teslasoft ID</p>
        </div>
        <div class = "login-form">
            <a href="$smartcard_url"><button class = "action-button btn-aqua">Login with SmartCard</button></a>
            <button class = "action-button btn-red br" onclick = "javascript:history.back()">Back to App</button>
        </div>
    </body>
</html>
EOL;

$app_unc = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <link rel = "icon" href = "https://id.teslasoft.org/smartcard/id.png">
        <title>Teslasoft ID</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #323232;
            }
            
            .page {
                padding-top: 60px;
                min-height: 60px;
                background-color: #121212;
            }
            
            p, span {
                color: #fafafa;
                font-size: 16px;
                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }
            
            p::selection, span::selection {
                color: #000000;
                background: #fafafa;
            }
            
            a {
                text-decoration: none;
                padding: 0;
                margin: 0;
            }
            
            .action-button {
                width: 100%;
                height: 40px;
                margin-start: 4px;
                border-radius: 4px;
                border: none;
                outline: none;
                transition: 0.3s;
                color: #ffffff;
            }
            
            .btn-green {
                background-color: rgba(46, 139, 86, 0.8);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.05);
            }
            
            .btn-green:active {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:focus {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:hover {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-aqua {
                background-color: rgba(0, 255, 255, 0.8);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.05);
            }
            
            .btn-aqua:active {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:focus {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:hover {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-red {
                background-color: rgba(242, 0, 40, 0.8);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.05);
            }
            
            .btn-red:active {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:focus {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:hover {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .login-form {
                margin: 36px auto;
                padding: 36px;
            }
            
            .header {
                margin: auto;
                font-family: sans-serif;
                color: #cecece;
                user-select: none;
                outline: none;
                text-align: center;
                background-color: none;
                font-size: 36px;
            }
            
            .public-icon {
                width: 90px;
                height: 90px;
                margin-left: calc(50% - 45px);
                margin-top: 36px;
                margin-bottom: 36px;
                outline: none;
            }
            
            .h {
                margin: auto;
                text-align: center;
            }
            
            .br {
                margin-top: 16px;
            }
        </style>
    </head>
    <body>
        <div = "h">
            <img class = "public-icon" src = "https://id.teslasoft.org/smartcard/id.png">
            <p class = "header">Teslasoft ID</p>
        </div>
        <div class = "login-form">
            <a href="$smartcard_url"><button class = "action-button btn-aqua">Login with SmartCard</button></a>
            <a href="https://teslasoft.org/ServiceLogin?did=id.teslasoft.org&lang=en_US&c=$continue"><button class = "action-button btn-green br">Continue with Jarvis Account</button></a>
        </div>
    </body>
</html>
EOL;

$smartcard_only_unc = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <link rel = "icon" href = "https://id.teslasoft.org/smartcard/id.png">
        <title>Teslasoft ID</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #323232;
            }
            
            .page {
                padding-top: 60px;
                min-height: 60px;
                background-color: #121212;
            }
            
            p, span {
                color: #fafafa;
                font-size: 16px;
                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }
            
            p::selection, span::selection {
                color: #000000;
                background: #fafafa;
            }
            
            a {
                text-decoration: none;
                padding: 0;
                margin: 0;
            }
            
            .action-button {
                width: 100%;
                height: 40px;
                margin-start: 4px;
                border-radius: 4px;
                border: none;
                outline: none;
                transition: 0.3s;
                color: #ffffff;
            }
            
            .btn-green {
                background-color: rgba(46, 139, 86, 0.8);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.05);
            }
            
            .btn-green:active {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:focus {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-green:hover {
                background-color: rgba(46, 139, 86, 1);
                box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.6);
            }
            
            .btn-aqua {
                background-color: rgba(0, 255, 255, 0.8);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.05);
            }
            
            .btn-aqua:active {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:focus {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-aqua:hover {
                background-color: rgba(0, 255, 255, 1);
                box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.6);
            }
            
            .btn-red {
                background-color: rgba(242, 0, 40, 0.8);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.05);
            }
            
            .btn-red:active {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:focus {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .btn-red:hover {
                background-color: rgba(242, 0, 40, 1);
                box-shadow: 0 0 0 3px rgba(242, 0, 40, 0.6);
            }
            
            .login-form {
                margin: 36px auto;
                padding: 36px;
            }
            
            .header {
                margin: auto;
                font-family: sans-serif;
                color: #cecece;
                user-select: none;
                outline: none;
                text-align: center;
                background-color: none;
                font-size: 36px;
            }
            
            .public-icon {
                width: 90px;
                height: 90px;
                margin-left: calc(50% - 45px);
                margin-top: 36px;
                margin-bottom: 36px;
                outline: none;
            }
            
            .h {
                margin: auto;
                text-align: center;
            }
            
            .br {
                margin-top: 16px;
            }
        </style>
    </head>
    <body>
        <div = "h">
            <img class = "public-icon" src = "https://id.teslasoft.org/smartcard/id.png">
            <p class = "header">Teslasoft ID</p>
        </div>
        <div class = "login-form">
            <a href="$smartcard_url"><button class = "action-button btn-aqua">Login with SmartCard</button></a>
        </div>
    </body>
</html>
EOL;

if ($cancelable == "false")
    if ($continue == "https://id.teslasoft.org/account/main") {
        echo $smartcard_only_unc;
    } else {
        echo $app_unc;
    }
else {
    if ($continue == "https://id.teslasoft.org/account/main") {
        echo $smartcard_only;
    } else {
        echo $app;
    }
}

?>