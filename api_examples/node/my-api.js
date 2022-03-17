// my-api.js
// This example is to show how Ark mod can do the ChaCha20 encryption with an api. 
// The api is by design very simple and for verifying/testing the encryption.
// 
// Requires NodeJS: https://nodejs.org/en/download/
//
// Setup: (run from this script's dir)
// npm i express
// npm i env
//
// then run this from the dir with this script: 
// node .\my-api.js
//
// you can end the web server process using ctrl+c in the terminal
//
'use strict';
const express = require('express');
const {myChaCha20,Ciphered} = require('./my-chacha20');

const app = express();
app.use(express.json());

const port = 5555; // load from ENV or config file

// route for simple text message to be encrypted (comes from admin cmd in mod)
app.post('/test-message', async (req, res) => {
    // validate input json
    const ciphered = new Ciphered(req.body);
    if(!ciphered.valid){
        res.status(400).send({
            error:ciphered.input_error
        });
        return;
    }
    console.log('REQUEST NONCE >>> ',ciphered.nonce.toString('hex'));
    console.log('REQUEST CIPHER >>> ',ciphered.cipher.toString('hex'));

    // decrypt and get the plaintext
    let receivedPlaintext = await myChaCha20.decrypt(ciphered)
        .catch(dec_err => {
            res.status(dec_err?.status ?? 400).send({
                error:ciphered.input_error
            }); return;});
    console.log('DECIPHER >>> ',receivedPlaintext);
    
    // create an arbitrarily dynamic reply message text
    const replyMessage = `NODEJS got "${receivedPlaintext}" at ${new Date().toISOString()}`;
    console.log('REPLY MSG >>> ',replyMessage);
    // cipher the reply plaintext
    let reply = await myChaCha20.encrypt(replyMessage);
    reply.req_id = ciphered.req_id;

    console.log('REPLY NONCE >>> ',reply.nonce);
    console.log('REPLY CIPHER >>> ',reply.cipher);

    res.send(reply);
});

function lerp(a, b, n) {
    return (1 - n) * a + n * b;
  }
function getRandomInt(min,max){
    return Math.round(lerp(min,max,Math.random()));
}

// comes from ArKrypt Test UI - Player Is
app.post('/player-is', async (req, res) => {
    // validate input json
    const ciphered = new Ciphered(req.body);
    if(!ciphered.valid){
        res.status(400).send({
            error:ciphered.input_error
        });
        return;
    }
    console.log('REQUEST NONCE >>> ',ciphered.nonce.toString('hex'));
    console.log('REQUEST CIPHER >>> ',ciphered.cipher.toString('hex'));
    var req_id = ciphered.req_id;

    // decrypt and get the plaintext
    let receivedPlaintext = await myChaCha20.decrypt(ciphered)
        .catch(dec_err => {
            res.status(dec_err?.status ?? 400).send({
                error:ciphered.input_error
            }); return;});
    console.log('DECIPHER >>> ',receivedPlaintext);

    // parse plaintext to json to confirm is good
    let player_request;
    try{
        player_request = JSON.parse(receivedPlaintext);
    }
    catch(jsnErr){
        console.error(`Bad Player Request JSON, could not parse! ${jsnErr} \r\n${receivedPlaintext}`);
        res.status(400).send({
            error:"Bad Player Request JSON, could not parse."
        });
        return;
    }
    console.log("PLAYER REQUEST >>> ",player_request);

    // select random reply
    var choice = getRandomInt(0,2);
    let player_response;
    switch(choice){
        case 0:{
            var p_tier = ["BRONZE","SILVER","GOLD","PLATINUM"][getRandomInt(0,3)];
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_patron":p_tier,"_ts":new Date().getTime() / 1000}
            break;
        }
        case 1:{
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_shithead":true,"_ts":new Date().getTime() / 1000}
            break;
        }
        case 2:{
            player_response = {"req_id":req_id,"_sid":player_request["_sid"],"_ts":new Date().getTime() / 1000}
            break;
        }
    }
    console.log("REPLY >>>",player_response);

    // cipher the reply 
    let reply = await myChaCha20.encrypt(JSON.stringify(player_response));
    reply.req_id = req_id;

    console.log('REPLY NONCE >>> ',reply.nonce);
    console.log('REPLY CIPHER >>> ',reply.cipher);

    res.send(reply);
});


// comes from ArKrypt Test UI - Server Paywall
app.post('/server-paywall', async (req, res) => {
    // validate input json
    const ciphered = new Ciphered(req.body);
    if(!ciphered.valid){
        res.status(400).send({
            error:ciphered.input_error
        });
        return;
    }
    console.log('REQUEST NONCE >>> ',ciphered.nonce.toString('hex'));
    console.log('REQUEST CIPHER >>> ',ciphered.cipher.toString('hex'));
    var req_id = ciphered.req_id;

    // decrypt and get the plaintext
    let receivedPlaintext = await myChaCha20.decrypt(ciphered)
        .catch(dec_err => {
            res.status(dec_err?.status ?? 400).send({
                error:ciphered.input_error
            }); return;});
    console.log('DECIPHER >>> ',receivedPlaintext);

    // parse plaintext to json to confirm is good
    let pw_request;
    try{
        pw_request = JSON.parse(receivedPlaintext);
    }
    catch(jsnErr){
        console.error(`Bad Server Paywall Request JSON, could not parse! ${jsnErr} \r\n${receivedPlaintext}`);
        res.status(400).send({
            error:"Bad Server Paywall  Request JSON, could not parse."
        });
        return;
    }
    console.log("PAYWALL REQUEST >>> ",pw_request);

    // select random reply
    var choice = getRandomInt(0,2);
    let pw_response;
    switch(choice){
        case 0:{
            pw_response = {"req_id":req_id,"_revert":true,"_freemode":true,"_ts":new Date().getTime() / 1000}
            break;
        }
        case 1:{
            pw_response = {"req_id":req_id,"_revert":true,"_freemode":false,"_ts":new Date().getTime() / 1000}
            break;
        }
        case 2:{
            pw_response = {"req_id":req_id,"_ignore":true,"_ts":new Date().getTime() / 1000}
            break;
        }
    }
    console.log("REPLY >>>",pw_response);

    // cipher the reply 
    let reply = await myChaCha20.encrypt(JSON.stringify(pw_response));
    reply.req_id = req_id;

    console.log('REPLY NONCE >>> ',reply.nonce);
    console.log('REPLY CIPHER >>> ',reply.cipher);

    res.send(reply);
});


// comes from ArKrypt Test UI - Global Config
app.post('/global-config', async (req, res) => {
    // validate input json
    const ciphered = new Ciphered(req.body);
    if(!ciphered.valid){
        res.status(400).send({
            error:ciphered.input_error
        });
        return;
    }
    console.log('REQUEST NONCE >>> ',ciphered.nonce.toString('hex'));
    console.log('REQUEST CIPHER >>> ',ciphered.cipher.toString('hex'));
    var req_id = ciphered.req_id;

    // decrypt and get the plaintext
    let receivedPlaintext = await myChaCha20.decrypt(ciphered)
        .catch(dec_err => {
            res.status(dec_err?.status ?? 400).send({
                error:ciphered.input_error
            }); return;});
    console.log('DECIPHER >>> ',receivedPlaintext);

    // parse plaintext to json to confirm is good
    let conf_request;
    try{
        conf_request = JSON.parse(receivedPlaintext);
    }
    catch(jsnErr){
        console.error(`Bad Global Config Request JSON, could not parse! ${jsnErr} \r\n${receivedPlaintext}`);
        res.status(400).send({
            error:"Bad Global Config  Request JSON, could not parse."
        });
        return;
    }
    console.log("CONFIG REQUEST >>> ",conf_request);

    // select random reply
    var choice = getRandomInt(0,2);
    let conf_response;
    switch(choice){
        case 0:{
            // some sort of multipliers for dmg and eggs
            conf_response = {
                "req_id":req_id,
                "_dmg_mult":1+(30* Math.random()),
                "_egg_rate":5+(6* Math.random()),
                "_cheater_detect_on":Math.random()>0.5,
                "_ts":new Date().getTime() / 1000
            }
            break;
        }
        case 1:{
            // some kind of secure event config
            var event_name = ["Christmas","Easter","IndependenceDay","Halloween","ValentinesDay","Thanksgiving"][getRandomInt(0,5)]
            conf_response = 
            {
                "req_id":req_id,
                "_event":event_name,
                "_event_rate":getRandomInt(1,20),
                "_cheater_detect_on":Math.random()>0.5,
                "_ts":new Date().getTime() / 1000
            }
            break;
        }
        case 2:{
            // some kind of secure boss config
            conf_response = 
            {
                "req_id":req_id,
                "_boss_config":[
                    {
                        "_name":"Lumbrr",
                        "_hp":getRandomInt(9,17)*10000000,
                        "_dmg_hi":getRandomInt(100,220)*1000,
                        "_dmg_lo":getRandomInt(20,80)*1000,
                        "_loot_level":getRandomInt(5,15),
                        "_enrage":getRandomInt(24,36)*100
                    },
                    {
                        "_name":"Rektiill",
                        "_hp":getRandomInt(24,39)*10000000,
                        "_dmg_hi":getRandomInt(160,320)*1000,
                        "_dmg_lo":getRandomInt(50,120)*1000,
                        "_loot_level":getRandomInt(9,25),
                        "_enrage":getRandomInt(32,50)*100
                    },
                ],                
                "_ts":new Date().getTime() / 1000
            }
            break;
        }
    }
    console.log("REPLY >>>",conf_response);

    // cipher the reply 
    let reply = await myChaCha20.encrypt(JSON.stringify(conf_response));
    reply.req_id = req_id;

    console.log('REPLY NONCE >>> ',reply.nonce);
    console.log('REPLY CIPHER >>> ',reply.cipher);

    res.send(reply);
});


// general 404 handler middleware
app.use((req, res, next) => {
    res.status(404).send({
        error: 'Not found'
    });
});

// general error handler middleware
app.use((error, req, res, next) => {
    console.error(error.stack);
    res.status((error?.expose && (error.status ?? error.statusCode)) ?? 500)
        .send((error?.expose && error?.type=="entity.parse.failed" && {
            error:'JSON Expected!'
        }) ?? {
            error:'Something Broke!'
        });
});

app.listen(port);
console.log(`WebServer started listening on http://127.0.0.1:${port} (Press CTRL+C to quit)`);


