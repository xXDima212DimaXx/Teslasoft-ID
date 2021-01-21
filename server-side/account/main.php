<?php
$sessionid = $_COOKIE['SessionID'];
$uid = $_COOKIE['UserID'];
$time = $_COOKIE['LoginTZ'];
$device = $_COOKIE['DeviceID'];
setcookie("continue", "", time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);

$session = file_get_contents("./../users/".$uid."/security/session");
$skey = $session * $time;

$action = $_GET["action"];
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    
    if ($action == "logout") {
        setcookie("SessionID", $sessionid, time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
        setcookie("LoginTZ", $time, time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
        setcookie("UserID", $uid, time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
        setcookie("DeviceID", $device, time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
        setcookie("continue", "", time() - (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
        unlogged();
    }
}

$username = file_get_contents("./../users/".$uid."/public/username");
$useremail = file_get_contents("./../users/".$uid."/public/useremail");
$userid = file_get_contents("./../users/".$uid."/public/userid");
$usericon = "./../users/".$uid."/public/photos/icon.png";
$userbg = "./../users/".$uid."/public/photos/background.png";
$userbirthday = file_get_contents("./../users/".$uid."/private/birthday");
$subscription = file_get_contents("./../users/".$uid."/public/subscription");

if (time() > ($time + (3600 * 24 * 6))) {
    // Auto renew session (+ 7 days) if user signed in to your account
    // If user was inactive from 7 days on this device the session will close automatically (auto logout)
    setcookie("SessionID", $sessionid, time() + (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
    setcookie("DeviceID", $device, time() + (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
    setcookie("LoginTZ", $time, time() + (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
    setcookie("UserID", $uid, time() + (3600 * 24 * 7), "/", "cs.jarvis.studio", 1);
}

$app = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>My Account</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                background-color: #000000;
            }
            
            .header {
                width: 100vw;
                height: 60px;
                background-color: rgba(50, 50, 50, 0.7);
                position: fixed;
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
            
            .block-user {
                /*padding: 16px;*/
                width: 100vw;
                height: 152px;
            }
            
            .card-user {
                border-radius: 8px;
                width: 100%;
                height: 320px;
                background-color: #212121;
                
            }
            
            .bg-user {
                background: url("$userbg") center center / 100%;
                width: 100%;
                height: 120px;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            
            .user-icon-bg {
                bottom: 0px;
                width: 120px;
                height: 120px;
                background-color: #323232;
                border-radius: 50%;
                margin-left: calc(50% - 64px);
                margin-top: -64px;
                border: 4px solid #2e8b57;
            }
            
            .user-icon {
                background: url("$usericon") center center / 100%;
                width: 120px;
                height: 120px;
                border-radius: 50%;
            }
            
            .user {
                padding: 16px;
            }
            
            .user-name {
                margin-left: calc(50% - 100px);
                width: 200px;
                text-align: center;
                margin-top: 16px;
                margin-bottom: 16px;
                font-size: 20px;
            }
            
            .actions {
                width: 100%;
                height: 56px;
                display: flex;
            }
            
            .user-actions {
                width: 100%;
                height: 52px;
                margin: 16px;
                align-items: stretch;
            }
            
            .buttons {
                width: 100%;
                height: 48px;
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
        </style>
    </head>
    <body>
        <div class = "header">
            
        </div>
        <div class = "page">
            <div class = "block-user">
                <div class = "user">
                    <div class = "card-user">
                        <div class = "bg-user">
                            
                        </div>
                        <div class = "user-icon-bg">
                            <div class = "user-icon">
                                
                            </div>
                        </div>
                        <p class = "user-name">$username</p>
                        <div class = "actions">
                            <div class = "user-actions">
                                <table class = "buttons">
                                    <tr>
                                        <td style = "padding: 4px;">
                                            <button class = "action-button btn-green">Account settings</button>
                                        </td>
                                        <td style = "padding: 4px;">
                                            <a href = "https://cs.jarvis.studio/account/main?action=logout"><button class = "action-button btn-red">Sign out</button></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
EOL;

$page = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>My Account</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                font-family: sans-serif;
                font-size: 16px;
                outline: none;
                background-color: #121212;
                color: #fafafa;
            }
            
            .text-title {
                font-family: sans-serif;
                font-size: 16px;
                color: #2e8b57;
                word-break: break-all;
            }
            
            .text-title::selection {
                color: #000000;
                background: #2e8b57;
            }
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #fafafa;
                word-break: break-all;
            }
            
            .text::selection {
                color: #000000;
                background: #fafafa;
            }
            
            .variable-1 {
                color: #00aa11;
                user-select: all;
            }
            
            .variable-1::selection {
                color: #000000;
                background: #00aa11;
            }
            
            .variable-2 {
                color: #db4437;
                user-select: all;
            }
            
            .variable-2::selection {
                color: #000000;
                background: #db4437;
            }
            
            .variable-3 {
                color: #0033aa;
                user-select: all;
            }
            
            .variable-3::selection {
                color: #000000;
                background: #0033aa;
            }
            
            .variable-4 {
                color: #5500aa;
                user-select: all;
            }
            
            .variable-4::selection {
                color: #000000;
                background: #5500aa;
            }
            
            .line-number {
                color: #fafafa;
                user-select: none;
            }
            
            a {
                user-select; none;
            }
            
            .code {
                font-family: monospace;
            }
        </style>
    </head>
    <body>
<pre class = "code text-title"><span>admin@cs.jarvis.studio~# cat \$username</span>
<span>$username</span>
<span>admin@cs.jarvis.studio~# cat /smartcard/main.php</span>
<span class = "line-number">1 |</span>&nbsp;// TODO: Implement this page
<span class = "line-number">2 |</span>&nbsp;/* Additional information */
<span class = "line-number">3 |</span>&nbsp;/************************************************************
<span class = "line-number">4 |</span>&nbsp; * Common variables:
<span class = "line-number">5 |</span>&nbsp; * <span class = "variable-1">\$username</span> - User name (login) (public)
<span class = "line-number">6 |</span>&nbsp; * <span class = "variable-1">\$useremeil</span> - User email (public)
<span class = "line-number">7 |</span>&nbsp; * <span class = "variable-1">\$userbirthday</span> - User date of birth (private)
<span class = "line-number">8 |</span>&nbsp; * <span class = "variable-1">\$usericon</span> - Path to user profile icon (public)
<span class = "line-number">9 |</span>&nbsp; * <span class = "variable-1">\$userbg</span> - Path to background image of user profile (public)
<span class = "line-number">10|</span>&nbsp; * <span class = "variable-1">\$userid</span> - Public user id (public)
<span class = "line-number">11|</span>&nbsp; *
<span class = "line-number">12|</span>&nbsp; * Security settings variables (needs additional permissions):
<span class = "line-number">13|</span>&nbsp; * <span class = "variable-2">\$sessionid</span> - Current session id (secured)
<span class = "line-number">14|</span>&nbsp; * <span class = "variable-2">\$time</span> - Last login time (secured)
<span class = "line-number">15|</span>&nbsp; * <span class = "variable-2">\$session</span> - Security marker (secured)
<span class = "line-number">16|</span>&nbsp; * <span class = "variable-2">\$skey</span> - Computed security key (must equal to session id) (secured)
<span class = "line-number">17|</span>&nbsp; * <span class = "variable-2">\$device</span> - Current device ID (secured)
<span class = "line-number">18|</span>&nbsp; ************************************************************/
<span class = "line-number">19|</span>&nbsp;
<span class = "line-number">20|</span>&nbsp;/************************************************************
<span class = "line-number">21|</span>&nbsp; * Common information:
<span class = "line-number">22|</span>&nbsp; * Username: <span class = "variable-3">$username</span>
<span class = "line-number">23|</span>&nbsp; * User email: <span class = "variable-3">$useremail</span>
<span class = "line-number">24|</span>&nbsp; * User ID: <span class = "variable-3">$userid</span>
<span class = "line-number">25|</span>&nbsp; ************************************************************/
<span class = "line-number">26|</span>&nbsp;
<span class = "line-number">27|</span>&nbsp;/************************************************************
<span class = "line-number">28|</span>&nbsp; * Security information:
<span class = "line-number">29|</span>&nbsp; * Current session id: <span class = "variable-4">$sessionid</span>
<span class = "line-number">30|</span>&nbsp; * Last login time: <span class = "variable-4">$time</span>
<span class = "line-number">31|</span>&nbsp; * Security marker: <span class = "variable-4">$session</span>
<span class = "line-number">32|</span>&nbsp; * Computed security key (must equal to session id): <span class = "variable-4">$skey</span>&nbsp;&nbsp;&nbsp;&nbsp;
<span class = "line-number">33|</span>&nbsp; * Current device ID: <span class = "variable-4">$device</span>
<span class = "line-number">34|</span>&nbsp; ************************************************************/
<span class = "line-number">35|</span>&nbsp; 
<span>admin@cs.jarvis.studio~# logout</span>
<span>Click <a href = "https://cs.jarvis.studio/account/main?action=logout">here</a> to logout</span>
</pre>
    </body>
</html>


EOL;
if (isset($_COOKIE['SessionID']) && isset($_COOKIE['LoginTZ']) && isset($_COOKIE['UserID']) && isset($_COOKIE['DeviceID'])) {
    $sessionid = $_COOKIE['SessionID'];
    $session = file_get_contents("./../users/".$uid."/security/session");
    $time = $_COOKIE['LoginTZ'];
    
    if ($sessionid == ($session * $time)) {
        echo $page;
    } else {
        unlogged();
    }
} else {
    unlogged();
}

function unlogged() {
    echo('<script>window.location.replace("https://cs.jarvis.studio/oauth.php?continue=https://cs.jarvis.studio/account/main");</script>');
}
?>