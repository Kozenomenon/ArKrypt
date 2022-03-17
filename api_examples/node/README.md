# ArKrypt - NodeJS API Example

## Prerequisites
- First, you need to install [NodeJS](https://nodejs.org/en/download/) (windows installer)
- Then, in terminal from this folder, get [Express](https://github.com/expressjs/express) 
```
K:\GitHub\ArKrypt\api_examples\node> npm i express
```

## API Routes
All routes handle a cipher/nonce, decrypt & log them, then reply with a similarly ciphered response. 
```json
{
    "req_id":"RequestID",
    "nonce":"Base64Nonce",
    "cipher":"Base64Ciphertext"
}
```
- `/test-message` 
  - Send/receive secure message text with API. 
- `/player-is` 
  - Check API if player is patron or is... _[bad word]_.
- `/server-paywall` 
  - Notify API that mod is paywalled.
- `/global-config` 
  - Retrieve a mod's global config.  
_Use-case examples only, requests/responses are fake/random to demo the encryption._

## Code Files
- `my-api.js` 
  - API requests/responses using Express.
- `my-chacha20.js` 
  - Uses node's native `crypto` module to do ChaCha20.
- `my-settings.js` 
  - Access to API settings such as the encryption key.

## Screenshots
### Send Message - NodeJS
![Send Message - NodeJS](ArKrypt_SendMessageCmd_API_NodeJS.PNG)
### Demo UI - Player Is... - NodeJS
![Player Is... NodeJS](ArKrypt_UI_PlayerIs_API_NodeJS.PNG)
### Demo UI - Server Paywall - NodeJS
![Server Paywall - NodeJS](ArKrypt_UI_SvrPaywall_API_NodeJS.PNG)
### Demo UI - Global Config - NodeJS
![Global Config - NodeJS](ArKrypt_UI_GlobalConf_API_NodeJS.PNG)
