# ArKrypt - Secure API Calls
 A standard encryption implementation for Ark mods to securely communicate with an APIs.
 <img src="images/ArKrypt_Demo_UI_Sm.gif" alt="ArKrypt Demo UI" width="550">
 
 _[See Other Images](images)_
## Included in this Source
  - ArKrypt mod located at `\mod\ArKrypt`. 
    - _Close ADK, then copy this folder into your Mods folder._
    - `ArKrypt_Functions` - ArKrypt Function Object BP
      - _This is all you need to use the encryption in your mod; has no dependencies._
      - _Also includes some encoding/conversion functionality._
    - Demo UI 
      - Access in PIE: `admincheat scriptcommand arkrypt test_ui`
    - CCA / Buff to enable demo functionality
    - Blutility BPs to test functions without running PIE (output log)
  - API Examples
    - Python located at `\api_examples\py`
    - NodeJS located at `\api_examples\node`
    - Both API examples have the same functionality. 
      - Used by CCA for cmd: `admincheat scriptcommand arkrypt send_cipher <message>`
        - `/test-message` - Send/receive secure message text with API. 
      - Used by Demo UI
        - `/player-is` - Securely check API if player is patron or is... _[bad word]_.
        - `/server-paywall` - Securely notify API that mod is paywalled.
        - `/global-config` - Securely retrieve a mod's global config.
    - *APIs have comments that indicate pre-requisite modules needed.*

## Encryption Details
  - ChaCha20 Stream Cipher _(Used by [Wireshark VPN protocol](https://en.wikipedia.org/wiki/WireGuard), its solid!)_ 
  - [The RFC if you're interested](https://datatracker.ietf.org/doc/html/rfc8439)
  - [Wikipedia on ChaCha20](https://en.wikipedia.org/wiki/ChaCha20)
