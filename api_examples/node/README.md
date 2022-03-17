# ArKrypt - NodeJS API Example

## Prerequisites
- First, you need to install [NodeJS](https://nodejs.org/en/download/) (windows installer)
- Then, in terminal from this folder, get [Express](https://github.com/expressjs/express) 
  - `npm i express`

## API Routes
- /send-message
  Request/Response
```json
{
    "nonce":"Base64Nonce",
    "cipher":"Base64Ciphertext"
}
```

