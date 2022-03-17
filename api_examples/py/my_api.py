# my_api.py
# This example is to show how Ark mod can do the ChaCha20 encryption with an api. 
# The api is by design very simple and your actual api would be different! 
#
# Requires Python3.6+ -> https://www.python.org/downloads/
# 
# Setup: You need to install FastAPI & uvicorn using pip: 
# python -m pip install fastapi
# python -m pip install uvicorn[standard]
# python -m pip install pycryptodome
#
# then from the dir containing this script you run it by doing: 
# uvicorn my_api:app --reload
#

from fastapi import FastAPI
from datetime import datetime
import json
import random

from my_chacha20 import MyChaCha20,Ciphered

app = FastAPI()

# route for simple text message to be encrypted (comes from admin cmd in mod)
@app.post("/test-message", status_code=200)
async def post_cipher(ciphered: Ciphered):
    print("REQUEST NONCE >>> ",ciphered.nonce.hex())
    print("REQUEST CIPHER >>> ",ciphered.cipher.hex())
    # decipher request
    plaintext = MyChaCha20.decrypt(ciphered)
    print("DECIPHER >>> ",plaintext)
    # generate reply msg
    reply_message = "PY got \"" + plaintext + "\" at " + str(datetime.now())
    print("REPLY MSG >>> ",reply_message)    
    # cipher reply
    reply_cipher,reply_nonce = MyChaCha20.encrypt(reply_message)
    print("REPLY NONCE >>> ",reply_nonce)
    print("REPLY CIPHER >>> ",reply_cipher)
    # return json w/ nonce & ciphertext
    return {"req_id":ciphered.GetNonceBase64(),"nonce":reply_nonce,"cipher":reply_cipher}


# comes from ArKrypt Test UI - Player Is
@app.post("/player-is", status_code=200)
async def player_is(ciphered: Ciphered):
    # decipher request
    plaintext = MyChaCha20.decrypt(ciphered)
    print("DECIPHER >>> ",plaintext)
    player_request = json.loads(plaintext)
    print("PLAYER REQUEST >>> ",player_request)
    # generate player response
    choice = random.randint(0,2)
    player_response = None
    req_id = ciphered.GetNonceBase64().decode()
    # choose random player is X response 
    match choice:
        case 0:
            p_tier = ["BRONZE","SILVER","GOLD","PLATINUM"][random.randint(0,3)]
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_patron":p_tier,"_ts":datetime.now().timestamp()}
        case 1:
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_shithead":True,"_ts":datetime.now().timestamp()}
        case 2:
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_ts":datetime.now().timestamp()}
    print("REPLY >>>",player_response)
    # cipher reply
    reply_cipher,reply_nonce = MyChaCha20.encrypt(json.dumps(player_response,indent=4))
    print("REPLY NONCE >>> ",reply_nonce)
    print("REPLY CIPHER >>> ",reply_cipher)
    # return json w/ nonce & ciphertext
    return {"req_id":req_id,"nonce":reply_nonce,"cipher":reply_cipher}


# comes from ArKrypt Test UI - Server Paywall
@app.post("/server-paywall", status_code=200)
async def server_paywall(ciphered: Ciphered):
    # decipher request
    plaintext = MyChaCha20.decrypt(ciphered)
    print("DECIPHER >>> ",plaintext)
    pw_request = json.loads(plaintext)
    print("PAYWALL REQUEST >>> ",pw_request)
    # generate player response
    choice = random.randint(0,2)
    pw_response = None
    req_id = ciphered.GetNonceBase64().decode()
    # decide on a random paywall response instruction
    match choice:
        case 0:
            pw_response = {"req_id":req_id,"_revert":True,"_freemode":True,"_ts":datetime.now().timestamp()}
        case 1:
            pw_response = {"req_id":req_id,"_revert":True,"_freemode":False,"_ts":datetime.now().timestamp()}
        case 2:
            pw_response = {"req_id":req_id,"_ignore":True,"_ts":datetime.now().timestamp()}
    print("REPLY >>>",pw_response)
    # cipher reply
    reply_cipher,reply_nonce = MyChaCha20.encrypt(json.dumps(pw_response,indent=4))
    print("REPLY NONCE >>> ",reply_nonce)
    print("REPLY CIPHER >>> ",reply_cipher)
    # return json w/ nonce & ciphertext
    return {"req_id":req_id,"nonce":reply_nonce,"cipher":reply_cipher}


# comes from ArKrypt Test UI - Global Config
@app.post("/global-config", status_code=200)
async def global_config(ciphered: Ciphered):
    # decipher request
    plaintext = MyChaCha20.decrypt(ciphered)
    print("DECIPHER >>> ",plaintext)
    conf_request = json.loads(plaintext)
    print("CONFIG REQUEST >>> ",conf_request)
    # generate player response
    choice = random.randint(0,2)
    conf_response = None
    req_id = ciphered.GetNonceBase64().decode()
    # select a random sort of secure mod config to return 
    match choice:
        case 0:
            # some sort of multipliers for dmg and eggs
            conf_response = \
            {
                "req_id":req_id,
                "_dmg_mult":1+(30* random.random()),
                "_egg_rate":5+(6* random.random()),
                "_cheater_detect_on":bool(random.random()>0.5),
                "_ts":datetime.now().timestamp()
            }
        case 1:
            # some kind of secure event config
            event_name = ["Christmas","Easter","IndependenceDay","Halloween","ValentinesDay","Thanksgiving"][random.randint(0,5)]
            conf_response = \
            {
                "req_id":req_id,
                "_event":event_name,
                "_event_rate":random.randint(1,20),
                "_cheater_detect_on":bool(random.random()>0.5),
                "_ts":datetime.now().timestamp()
            }
        case 2:
            # some kind of secure boss config
            conf_response = \
            {
                "req_id":req_id,
                "_boss_config":[
                    {
                        "_name":"Lumbrr",
                        "_hp":random.randint(9,17)*10000000,
                        "_dmg_hi":random.randint(100,220)*1000,
                        "_dmg_lo":random.randint(20,80)*1000,
                        "_loot_level":random.randint(5,15),
                        "_enrage":random.randint(24,36)*100
                    },
                    {
                        "_name":"Rektiill",
                        "_hp":random.randint(24,39)*10000000,
                        "_dmg_hi":random.randint(160,320)*1000,
                        "_dmg_lo":random.randint(50,120)*1000,
                        "_loot_level":random.randint(9,25),
                        "_enrage":random.randint(32,50)*100
                    },
                ],                
                "_ts":datetime.now().timestamp()
            }
    print("REPLY >>>",conf_response)
    # cipher reply
    reply_cipher,reply_nonce = MyChaCha20.encrypt(json.dumps(conf_response,indent=4))
    print("REPLY NONCE >>> ",reply_nonce)
    print("REPLY CIPHER >>> ",reply_cipher)
    # return json w/ nonce & ciphertext
    return {"req_id":req_id,"nonce":reply_nonce,"cipher":reply_cipher}
    