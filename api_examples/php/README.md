# ArKrypt - PHP API Example

## Credit 
The ChaCha20 logic for this PHP example is credited to:  
Discord: SmallGarfield#4404   
GitHub: https://github.com/xiaojiafei520

## Prerequisites / Setup 
To run [PHP](https://www.php.net/downloads.php) you will also need a webserver to run it on, such as [Apache](https://downloads.apache.org/).  
My dev machine being Windows, I found [XAMPP](https://www.apachefriends.org/) to be a convenient way to get it setup.  
Be sure to edit the Apache config to set the port to run it on. I used port 8181 for this example.  
_You may also want to make a symlink as I do below._  

Open the Apache Config:  
![Open Apache Config](/images/XAMPP_ApacheConfig1.PNG)  
Set the Apache Port:  
![Set Apache Port](/images/XAMPP_ApacheConfig2.PNG)  
Confirm document root & symlinks:  
![Confirm Apache Doc root](/images/XAMPP_ApacheConfig3.PNG)  
Make symlink:  
`mklink /D "K:\xampp\htdocs\arkrypt" "K:\GitHub\ArKrypt\api_examples\php"`   
Go to doc root folder, add `.htaccess` file:  
![Add .htaccess file](/images/XAMPP_PHPHtDocs.PNG)  
Put these contents in the file:  
_Now all PHP Requests will go to this example_  
```
RewriteEngine On
RewriteBase /arkrypt/
RewriteRule ^index\.php＄ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /arkrypt/my-api.php [L]
```

## API Routes
All routes handle a cipher/nonce, decrypt & log them, then reply with a similarly ciphered response.  
_The Request's 'nonce' is returned as 'req_id' for correlation._
```json
{
    "req_id":"NonceFromRequest",
    "nonce":"Base64Nonce",
    "cipher":"Base64Ciphertext"
}
```
_Use-case examples only, requests/responses are fake/random to demo the encryption._
- `/test-message` 
  - Send/receive secure message text with API. 
- `/player-is` 
  - Check API if player is patron or is... _[bad word]_.
- `/server-paywall` 
  - Notify API that mod is paywalled.
- `/global-config` 
  - Retrieve a mod's global config.  

## Code Files
- `my-api.php` 
  - API request routing & init.  
- `my-chacha20.php` 
  - Handles the ChaCha20 logic courtesy of [SmallGarfield](https://github.com/xiaojiafei520). 
- `my-settings.php` 
  - Access to API settings such as the encryption key. 
- `my-log.php` 
  - Logging to file since php has no console. 
- `/routes/` 
  - Processing responses:  
  - `test-message.php` 
  - `player-is.php` 
  - `server-paywall.php` 
  - `global-config.php` 

## Screenshots
### Send Message - PHP
![Send Message - Python](/images/ArKrypt_SendMessageCmd_API_PHP.PNG)
### Demo UI - Player Is... - PHP
![Player Is... Python](/images/ArKrypt_UI_PlayerIs_API_PHP.PNG)
### Demo UI - Server Paywall - PHP
![Server Paywall - Python](/images/ArKrypt_UI_SvrPaywall_API_PHP.PNG)
### Demo UI - Global Config - PHP
![Global Config - Python](/images/ArKrypt_UI_GlobalConf_API_PHP.PNG)
