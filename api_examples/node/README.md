# ArKrypt - NodeJS API Example

## Prerequisites
- First, you need to install [NodeJS](https://nodejs.org/en/download/) (windows installer)
- Then, in terminal from this folder, get [Express](https://github.com/expressjs/express) 
  - `npm i express`

## API Routes
All routes handle a cipher/nonce, decrypt & log them, then reply with a similarly ciphered response.  
/send-message  
Request/Response
```json
{
    "nonce":"Base64Nonce",
    "cipher":"Base64Ciphertext"
}
```
/player-is  
/server-paywall  
/global-config  
Request/Response 
```json
{
    "req_id":"RequestID",
    "nonce":"Base64Nonce",
    "cipher":"Base64Ciphertext"
}
```
