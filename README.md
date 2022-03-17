# ArKrypt
 ChaCha20 encryption implementation for Ark mods to securely communicate with their APIs.
 Includes: 
  ArKrypt mod located at `\mod\ArKrypt`. 
    _Copy this folder into your ADK's Mods folder._
    `ArKrypt_Functions` - ArKrypt Function Object BP
      _This is all you need to use the encryption in your mod, has no depedencies._
      _Also includes some encoding/conversion functionality._
    Demo UI 
      Access in PIE: `admincheat scriptcommand arkrypt test_ui`
    CCA / Buff to enable demo functionality
    Blutility BPs to test functions without running PIE (output log)
    
  API Examples
    Python located at `\api_examples\py`
    NodeJS located at `\api_examples\node`
    Both API examples have same functionality, which culminates in 4 routes: 
      Used by CCA for cmd: `admincheat scriptcommand arkrypt send_cipher <message>`
        `/test-message` - Send/receive secure message text with API. 
      Used by Demo UI
        `/player-is` - Securely check API if player is patron or <bleep>.
        `/server-paywall` - Securely notify API that mod is paywalled.
        `/global-config` - Securely retrieve a mod's global config.
    *APIs have comments that indicate pre-requisite modules needed.*