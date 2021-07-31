<?php
$error_code = $_GET['code'];

if($error_code == "empty_response") {
    $error_message = "Empty response: No data found on your SmartCard";
    $suggestion = "Try to plug in valid SmartCard and try again. Check if the file /smartcard/fwid exists on your SmartCard.";
} else if ($error_code == "invalid_token") {
    $error_message = "Invalid Token: SmartCard has no valid user data";
    $suggestion = "Make sure, that you entered a valid email. Try to write new user data via SmartCard helper. If this error appears again try another login method.";
} else if ($error_code == "smartcard_unplugged") {
    $error_message = "SmartCard unplugged: No smart card found on this device";
    $suggestion = "Please plug in your SmartCard before login. If SmartCard already plugged in try to write new user data via SmartCard helper. If this error appears again try another login method.";
} else if ($error_code == "smartcard_not_genuine") {
    $error_message = "SmartCard is not genuine: SmartCard serial ID is invalid";
    $suggestion = "Please plug in valid SmartCard. Note: you can not simply move /smartcard/fwid to a new SmartCard. Please use SmartCard helper.";
} else if ($error_code == "bio_canceled") {
    $error_message = "Authentication canceled: Invalid fingerprint or fingerprint sensor not found";
    $suggestion = "Please back to login page and follow login link again.";
} else {
    $error_code = "error_inside_error";
    $error_message = "Invalid error code";
    $suggestion = "Try to back to login page and authenticate again.";
}

$app = <<<EOL
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content= "width=device-width, user-scalable=no">
        <title>Login error</title>
        <style>
            html, body {
                padding: 0;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <h3>An error occured</h3>
        <span>Error code: $error_code</span>
        <br>
        <span>Error message: $error_message</span>
        <br>
        <span>Suggestion how to fix: $suggestion</span>
        <br>
        <a href = "https://id.teslasoft.org/oauth">Back to login page</a>
    </body>
</html>
EOL;

echo($app);
?>