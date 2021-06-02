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

> Open https://id.teslasoft.org/oauth (or click the button "Login with SmartCard")
> Hold your smartcard to the back of the phone
> Click "Authenticate"
> Enter your pincode. (Make note that you have only 3 attempts).
> You will be redirected automatically to the site.

### How to get SmartCard

> Contact your administrator

### Which types of smartcards are supported

> We're tested Mifare Classic and Mifare Light with 4 and 7 bytes serial numbers. Other types try at your own risk.

#### You can develop your own backend to authenticate