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
