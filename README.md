# Teslasoft ID

*Teslasoft ID* is a powerful identification system which allow to use RFID or NFC Smart-Cards directly with android devices.

### How to setup

> Firstly create folder /path/to/server-side/users.
> In this folder create subfolders, named <USER_ID> (ex /users/userid).
> Every user have 3 types of data - public, private and security.
> Public data can be accessed by anyone. There are a email, public name, avatar, user ID, etc.
> Private data can be accessed only by user (owner). There are a birthday, original name/surname, etc.
> Security data can be accessed only by server. There are security markers, tokens, etc. We don't keep your passwords or pincodes. It generates while user signs in.

### How to use

> Open https://id.teslasoft.org/oauth?continue=YOUR_URL (or click the button "Login with SmartCard")
> Hold your smartcard to the back of the phone
> Click "Authenticate"
> Enter your pincode (PIN1). (Make note that you have only 3 attempts).
> You will be redirected automatically to the target site.

### How to get SmartCard

> Contact your IT-Administrator. (Currently SmartCards can be issued only for Teslasoft members)

### Which types of smartcards are supported

> We're tested Mifare Classic and Mifare UltraLight with 4 and 7 bytes serial numbers. Other types try at your own risk.

### API

> You can get user data by using our API
> On the page place this button:

```html
<a href = "intent://id.teslasoft.org/smartcard/open#Intent;scheme=https;package=com.teslasoft.id.smartcard;S.cont=https://YOUR_URL;end">Login with SmartCard</a>
```

> If login will successfull user will be redirected to https://YOUR_URL?secret=API_KEY&userid=USER_ID
> 
> Now you can call api by using API_KEY and USER_ID params:

```
https://id.teslasoft.org/smartcard/api?secret=API_KEY&userid=USER_ID
```

> Now you will get response in a JSON format
> 
> User's avatar and background are located here (this operation does not require api key because avatar and background are public information):
>
> Avatar:

```
https://usercontent.teslasoft.org/a/USER_ID/icon.png
```

> Background:

```
https://usercontent.teslasoft.org/a/USER_ID/background.png
```

> ***Please note that you can access user data only with read permissions for security purposes.***
>
> ***This API can be used to create new accounts on your site/app based on the SmartCard information.***
