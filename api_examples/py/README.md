# ArKrypt - Python API Example

## Prerequisites
First, install [Python3.6+](https://www.python.org/downloads/) (windows installer)  
Then, install module [FastAPI](https://fastapi.tiangolo.com/):
```
K:\GitHub\ArKrypt\api_examples\py> python -m pip install fastapi
```
Then, install module [Uvicorn](https://www.uvicorn.org/):
```
K:\GitHub\ArKrypt\api_examples\py> python -m pip install uvicorn[standard]
```
Then, install module [PyCryptoDome](https://www.pycryptodome.org/): _(remove 'pycrypto' if you have that)_
```
K:\GitHub\ArKrypt\api_examples\py> python -m pip install pycryptodome
```
Finally, run it like so:
```
K:\GitHub\ArKrypt\api_examples\py> uvicorn my_api:app --reload
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
- `my_api.py` 
  - API requests/responses using FastApi.
- `my_chacha20.py` 
  - Uses `pycryptodome` module to do ChaCha20.
- `my_settings.py` 
  - Access to API settings such as the encryption key.

## Screenshots
### Send Message - Python
![Send Message - Python](/images/ArKrypt_SendMessageCmd_API_Python.PNG)
### Demo UI - Player Is... - Python
![Player Is... Python](/images/ArKrypt_UI_PlayerIs_API_Python.PNG)
### Demo UI - Server Paywall - Python
![Server Paywall - Python](/images/ArKrypt_UI_SvrPaywall_API_Python.PNG)
### Demo UI - Global Config - Python
![Global Config - Python](/images/ArKrypt_UI_GlobalConf_API_Python.PNG)
