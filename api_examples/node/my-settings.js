'use strict';
const path = require('path');
const fs = require('fs');

function secretFromFile(...args){
    var filePath = path.join(...args);
    let secret;
    if (fs.existsSync(filePath)){
        if(fs.statSync(filePath).isFile()){
            secret = fs.readFileSync(filePath).toString('utf-8');
        }
    }
    return secret;
}

class MySettings{
    constructor(){
        var appName = process.env.APP_NAME ?? 'my_node_api';
        this.APP_NAME = appName;
        var modIdentifier = process.env.MOD_IDENTIFIER ?? 'my_node_api';
        this.MOD_IDENTIFIER = modIdentifier;
        var secretsDir = process.env.SECRETS_DIR ?? `/var/run/secrets/${appName}`;
        this.SECRETS_DIR = secretsDir;
        this.CHACHA20_KEY = secretFromFile(secretsDir,modIdentifier,'chacha20/key') ?? 
            process.env.CHACHA20_KEY ?? 'MEe5PTFa/8tKguOxto91gaYixTiVEY3nowCKhQdlrNk=';//'AAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8=';
        var initCounter = secretFromFile(secretsDir,modIdentifier,'chacha20/init-counter') ?? 
            process.env.CHACHA20_INIT_COUNTER ?? 1;
        this.CHACHA20_INIT_COUNTER = !isNaN(initCounter) && initCounter!=null ? parseInt(initCounter) : 1;
    }
}

const mySettings = new MySettings();
module.exports = mySettings;