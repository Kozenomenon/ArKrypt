# ArKrypt - Secure API Calls
 A standard encryption implementation for Ark mods to securely communicate with their APIs.
 <img src="images/ArKrypt_Demo_UI_Sm.gif" alt="ArKrypt Demo UI" width="600">

## Contents
  - [ArKrypt Demo Mod](/mod)
  - [API Examples](/api_examples)
  - [Screenshots](/images) 

## Encryption Details
  - ChaCha20 Stream Cipher _(Used by [WireGuard VPN protocol](https://en.wikipedia.org/wiki/WireGuard), its solid!)_ 
  - [The RFC if you're interested](https://datatracker.ietf.org/doc/html/rfc8439)
  - [Wikipedia on ChaCha20](https://en.wikipedia.org/wiki/ChaCha20)
  - Implementations: 
    - Mod: `ArKrypt_Functions` _(Func Object BP)_ 
    - Python: `my_chacha20.py` _(uses pycryptodome module)_
    - NodeJS: `my-chacha20.js` _(uses crypto module)_
