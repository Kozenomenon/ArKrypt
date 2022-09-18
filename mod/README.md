# ArKrypt - Demo Mod
This mod contains the ArKrypt functions object blueprint as well as other assets to demo the secure API functionality.  

### To Use
- Close your Ark Dev Kit
- Place this 'ArKrypt' folder in your ADK's `\ShooterGame\Content\Mods` directory 
- Start the Ark Dev Kit 
- Open the level `TestMapArea_ArKrypt` 
- Run PIE, then hit `[tab]` to open the console
- To send a test message to the API: 
```
admincheat scriptcommand arkrypt send_cipher <message>
```
- To open the Demo UI: 
```
admincheat scriptcommand arkrypt test_ui
```
_You need to have at least one of the [API examples](/api_examples) running of course!_  
- Toggle which APIs to use in the `ArKrypt_CCA` BP.  
![ArKrypt_CCA API Toggles](/images/ArKrypt_CCA_API_Toggles.png)  

### Contents
- `ArKrypt_Functions` - ArKrypt Function Object BP
  - _This is all you need to use the encryption in your mod; has no dependencies._
  - _Also includes some encoding/conversion functionality._
- Demo UI 
- CCA / Buff to enable demo functionality
- Blutility BPs to test functions without running PIE (output log) 
- Other miscellaneous things to support demo of ArKrypt  

### Send Message - PIE
![Send Message - PIE](/images/ArKrypt_SendMessageCmd_PIE.PNG)
### Demo UI - Player Is... - PIE
![Player Is... PIE](/images/ArKrypt_UI_PlayerIs_PIE.PNG)
### Demo UI - Server Paywall - PIE
![Server Paywall - PIE](/images/ArKrypt_UI_SvrPaywall_PIE.PNG)
### Demo UI - Global Config - PIE
![Global Config - PIE](/images/ArKrypt_UI_GlobalConf_PIE.PNG)
