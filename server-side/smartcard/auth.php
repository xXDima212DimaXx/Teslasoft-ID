<?php
$xsessionid = $_COOKIE['SessionID'];
$xuid = $_COOKIE['UserID'];
$xtime = $_COOKIE['LoginTZ'];
$xdevice = $_COOKIE['DeviceID'];

if (isset($_COOKIE['SessionID']) && isset($_COOKIE['LoginTZ']) && isset($_COOKIE['UserID']) && isset($_COOKIE['DeviceID'])) {
    $xsessionid = $_COOKIE['SessionID'];
    $xuid = $_COOKIE['UserID'];
    $xtime = $_COOKIE['LoginTZ'];
    $xsession = file_get_contents("./../users/".$xuid."/security/session");
    
    /***************************** DEBUG
    echo $xsessionid."<br>";
    echo $xuid."<br>";
    echo $xtime."<br>";
    echo $xsession."<br>";
    echo ($xsession * $xtime)."<br>";
    *******************************/
    
    if ($xsessionid == ($xsession * $xtime)) {
        echo '<script>window.location.replace("https://id.teslasoft.org/account/main")</script>';
    } else {
        
    }
} else {
    
}

// exit(); // Breakpoint

$auth_token = $_GET['cbs'];
$sid = $_GET['sid'];
$pwtoken = $_GET['pwtoken'];
$uid = $_GET['uid'];
$pincode = $_POST['pincode'];
$continue = $_COOKIE['continue'];
$vc = $_GET['ver'];
$vn = $_GET['vn'];

$app = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
                font-family: sans-serif;
                font-size: 16px;
                outline: none;
                background-color: #121212;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .token {
                word-break: break-all;
                color: #009900;
            }
            
            .pin-button {
                border-radius: 50%;
                cursor: pointer;
                text-align: center;
                justify-content: center;
                width: 60px;
                height: 60px;
                background-color: #323232;
                border: none;
                color: #2e8b57;
                font-family: sans-serif;
                border: 2px solid #515151;
                outline: none;
                padding: 0;
                margin: 2px;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-button:active {
                background-color: #2e8b57;
                color: #ffffff;
                outline: none;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-clear {
                color: #db4437;
                outline: none;
                /*border: 2px solid rgba(0, 0, 0, 0.0);*/
                /*background-color: rgba(0, 0, 0, 0.0);*/
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-clear:active {
                background-color: #db4437;
                color: #ffffff;
                outline: none;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-input {
                margin; 2px;
                border: 3px solid #2e8b57;
                background-color: #ffffff;
                outline: none;
                border-radius: 4px;
                width: 182px;
                height: 56px;
                margin-left: 0;
                margin-right: 0;
                margin-top: 8px;
                margin-bottom: 8px;
                font-size: 72px;
                text-align: center;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-title {
                width: 192px;
                text-align: center;
                color: #fafafa;
                padding: 0;
                margin-left: 0;
                margin-right: 0;
                margin-top: 0;
                margin-bottom: 8px;
                    -webkit-tap-highlight-color: transparent;
                    -khtml-user-select: none;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    -o-user-select: none;
                    user-select: none;
            }
            
            .pin-form {
                width: 192px;
                margin: 100px auto;
            }
        </style>
    </head>
    <body>
        <!-- Show debug block<div>
            <span>Authenticating with token: </span>
            <span class = "token">$auth_token</span>
            <span> ...</span>
            <br>
            <span>SmartCard serial ID: </span>
            <span class = "token">$sid</span>
            <br>
            <span>Secure token: </span>
            <span class = "token">$pwtoken</span>
            <br>
            <span>User ID: </span>
            <span class = "token">$uid</span>
            <br>
        </div>-->
        <div class = "page">
            <div class = "pin-form">
                <h3 class = "pin-title">Enter SmartCard PIN</h3>
                <form method="POST" action = "">
                    <input class = "pin-input" id = "pin" value = "$pincode" type = "password" unselectable="on" onselectstart = "return false;" onmousedown = "return false;" name = "pincode" readonly="readonly">
                    <table style = "border: none; border-spacing: 0; border-collapse: collapse;">
                        <tr style = "border: none; border-spacing: 0; border-collapse: collapse;">
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "1" class = "pin-button" id = "one">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "2" class = "pin-button" id = "two">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "3" class = "pin-button" id = "three">
                            </th>
                        </tr>
                        <tr style = "border: none; border-spacing: 0; border-collapse: collapse;">
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "4" class = "pin-button" id = "four">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "5" class = "pin-button" id = "five">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "6" class = "pin-button" id = "six">
                            </th>
                        </tr>
                        <tr style = "border: none; border-spacing: 0; border-collapse: collapse;">
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "7" class = "pin-button" id = "seven">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "8" class = "pin-button" id = "eigth">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "9" class = "pin-button" id = "nine">
                            </th>
                        </tr>
                        <tr style = "border: none; border-spacing: 0; border-collapse: collapse;">
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "X" class = "pin-clear pin-button" id = "clear">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type="Button" value = "0" class = "pin-button" id = "zero">
                            </th>
                            <th style = "border: none; padding: 0;">
                                <input type = "submit" value = "&gt;" class = "pin-button" id = "enter">
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <script>
            var text = document.getElementById('pin');
            var pinlen = document.getElementById('pin').value;
            
            var submit = document.getElementById('enter');
            
            var clr = document.getElementById('clear');
            
            text.addEventListener('select', function() {
                this.selectionStart = this.selectionEnd;
            }, false);
            
            document.getElementById("one").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '1';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("two").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '2';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("three").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '3';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("four").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '4';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("five").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '5';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("six").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '6';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("seven").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '7';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("eigth").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '8';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("nine").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '9';
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
            
            document.getElementById("zero").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                clr.disabled = false;
                clr.style.opacity = "1";
                
                if (pinlen.length < 4) {
                    text.value += '0';
                    pinlen = document.getElementById('pin').value;
                } else {
                    submit.disabled = false;
                    submit.style.opacity = "1";
                }
            });
            
            document.getElementById("clear").addEventListener('click', function () {
                pinlen = document.getElementById('pin').value;
                
                if (pinlen.length != 0) {
                    text.value = pinlen.slice(0, pinlen.length-1)
                    pinlen = document.getElementById('pin').value;
                } else {
                    
                }
            });
        </script>
    </body>
</html>
EOL;

$salt = file_get_contents("./../users/".$uid."/security/salt");
$pt = $pincode * $salt;
$attempts = file_get_contents("./../users/".$uid."/security/apin");
// Anticheat
if ($attempts > 3) {
    $attempts = 3;
}
$cattempts = $attempts - 1;

$proccess = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
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
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #2e8b57;
            }
        </style>
    </head>
    <body>
        <span class = "text">Login successfull, redirecting ...</span>
        <script>window.location.replace("https://id.teslasoft.org/account/main")</script>
    </body>
</html>
EOL;

$cproccess = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
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
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #2e8b57;
            }
        </style>
    </head>
    <body>
        <span class = "text">Login successfull, redirecting ...</span>
        <script>window.location.replace("$continue")</script>
    </body>
</html>
EOL;

$error = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
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
                color: #db4437;
            }
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #fafafa;
            }
        </style>
    </head>
    <body>
        <span class = "text-title">Incorrect PIN!</span>
        <br>
        <span class = "text">Attempts: $cattempts</span>
        <br>
        <a href = "">Try again</a>
    </body>
</html>
EOL;

$dis = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
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
                color: #db4437;
            }
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #fafafa;
            }
        </style>
    </head>
    <body>
        <span class = "text-title">Authentication failed!</span>
        <br>
        <span class = "text">This SmardCard has been blocked for security purposes.</span>
        <br>
        <span class = "text">SmartCard login disabled for this account: Too many attempts: Use SmardCard helper to create new SmartCard.</span>
    </body>
</html>
EOL;

$rupdate = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>SmartCard Authentication</title>
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
                color: #db4437;
            }
            
            .text {
                font-family: sans-serif;
                font-size: 16px;
                color: #fafafa;
            }
        </style>
    </head>
    <body>
        <span class = "text-title">Update is required!</span>
        <br>
        <span class = "text">Your SmartCard client is deprecated.</span>
        <br>
        <span class = "text">Please click the button below to update:</span>
        <br>
        <a href = "https://play.google.com/store/apps/details?id=com.teslasoft.id.smartcard"><img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" style = "height: 90px;"></a>
    </body>
</html>
EOL;

$tk = file_get_contents("./../users/".$uid."/security/token");
$sn = file_get_contents("./../users/".$uid."/security/sn");
$lastses = file_get_contents("./../users/".$uid."/security/session");
$tz = time();

$devid = rand(30303030, 97000000);

$nvc = "11793";
$nvn = "1.17.93.20210619-stable";

if ($vc == $nvc && $vn == $nvn) {
$sessid = $lastses * $tz;
if (isset($_COOKIE['SessionID']) && isset($_COOKIE['LoginTZ']) && isset($_COOKIE['UserID']) && isset($_COOKIE['DeviceID']) && $_COOKIE['SessionID'] == $lastsess * $_COOKIE['LoginTZ'] && $_COOKIE['UserID'] == $uid) {
    echo($proccess);
} else {
    if (isset($_GET['cbs'])) {
        if (strlen($auth_token) == 64) {
            if (isset($_GET['sid'])) {
                if (isset($_GET['pwtoken'])) {
                    if (isset($_GET['uid'])) {
                        if ($attempts <= 0) {
                            echo $dis;
                        } else {
                            if ($auth_token == $tk) {
                                if ($sid == $sn) {
                                    if (isset($_POST['pincode']) && (strlen($pincode) == 4)) {
                                        if ($pwtoken == $pt) {
                                            // $session = rand(30303030, 97000000);
                                            // file_put_contents("./../users/".$uid."/devices/".$devid."/useragent", $_SERVER['HTTP_USER_AGENT']);
                                            setcookie("SessionID", $sessid, time() + (3600 * 24 * 7), "/", "id.teslasoft.org", 1);
                                            setcookie("DeviceID", $devid, time() + (3600 * 24 * 7), "/", "id.teslasoft.org", 1);
                                            setcookie("LoginTZ", $tz, time() + (3600 * 24 * 7), "/", "id.teslasoft.org", 1);
                                            setcookie("UserID", $uid, time() + (3600 * 24 * 7), "/", "id.teslasoft.org", 1);
                                            file_put_contents("./../users/".$uid."/security/apin", "3");
                                            
                                            // echo($s);
                                            
                                            if (isset($_COOKIE['continue'])) {
                                                setcookie("continue", "", time() - (3600 * 24 * 7), "/", "id.teslasoft.org", 1);
                                                echo $cproccess;
                                            } else {
                                                echo $proccess;
                                            }
                                        } else {
                                            file_put_contents("./../users/".$uid."/security/apin", $attempts - 1);
                                            echo $error;
                                        }
                                    } else {
                                        echo($app);
                                    }
                                } else {
                                    echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=smartcard_not_genuine")</script>');
                                }
                            } else {
                                echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=invalid_token")</script>');
                            }
                        }
                    } else {
                        echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=invalid_token")</script>');
                    }
                } else {
                    echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=smartcard_not_genuine")</script>');
                }
            } else {
                echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=smartcard_not_genuine")</script>');
            }
        } else {
            echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=invalid_token")</script>');
        }
    } else {
        echo('<script>window.location.replace("https://id.teslasoft.org/smartcard/error?code=empty_response")</script>');
    }
}
} else {
    echo($rupdate);
}
?>