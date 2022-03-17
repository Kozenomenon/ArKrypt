'use strict';

const crypto = require('crypto');
const mySettings = require('./my-settings');

class MyChaCha20{
    constructor(){}

    // only used internally to fix IV for dumb openssl
    prependCounterToNonce(nonce_buffer){
        // should not have to do this, but openssl included counter in the IV... 
        var ctr_buffer = Buffer.allocUnsafe(4);
        // and they read it in LE the same as chacha20 specifies for nonce 
        // so we write the initial counter value as LE to this buffer
        ctr_buffer.writeUIntLE(mySettings.CHACHA20_INIT_COUNTER, 0, 4);
        // then slap at the beginning of the actual nonce buffer
        var out_buffer = Buffer.concat([ctr_buffer,nonce_buffer]);
        //console.log('CONCAT NONCE >>> ',out_buffer.toString('hex'));
        return out_buffer;
    }

    /**
     * @param {String} plaintext The plaintext string to encrypt.
     * @returns {Promise<{nonce:string,cipher:string}} Object containing the nonce and cipher as base64 string.
     */
    async encrypt(plaintext){
        const me = this;
        return new Promise(async (resolve,reject) => {
            // get the key as a buffer
            let key_buffer = Buffer.from(mySettings.CHACHA20_KEY,'base64');
            // generate a nonce 12-byte
            let nonce_buffer = crypto.generateKeySync("hmac",{length:12*8}).export();
            let out_nonce_b64 = nonce_buffer.toString('base64');
            // fix nonce so openssl (what node crypto uses) accepts the 'iv' 
            let full_nonce_buffer = me.prependCounterToNonce(nonce_buffer);
            // create the cipher object 
            let chacha20_cipher = crypto.createCipheriv('chacha20',key_buffer,full_nonce_buffer);
            // cipher the plaintext to cipher bytes 
            let cipher_buffer = chacha20_cipher.update(Buffer.from(plaintext));
            cipher_buffer = Buffer.concat([cipher_buffer,chacha20_cipher.final()]);
            // generate base64 cipher string
            let out_cipher_b64 = cipher_buffer.toString('base64');
            resolve({
                nonce:out_nonce_b64,
                cipher:out_cipher_b64
            });
        });
    }

    /**
     * @param {Ciphered} ciphered The ciphered object containing the nonce and cipher as buffers for decryption.
     * @returns {Promise<String>} The decrypted plaintext as utf-8 string.
     */
    async decrypt(ciphered){
        const me = this;
        return new Promise(async (resolve,reject) => {
            if(ciphered instanceof Ciphered && ciphered.valid){
                // get the key as a buffer
                let key_buffer = Buffer.from(mySettings.CHACHA20_KEY,'base64');
                // fix nonce so openssl (what node crypto uses) accepts the 'iv' 
                let full_nonce_buffer = me.prependCounterToNonce(ciphered.nonce);
                // create the decipher object
                const chacha20_decipher = crypto.createDecipheriv('chacha20',key_buffer,full_nonce_buffer);
                // decipher to plaintext
                let plaintext = chacha20_decipher.update(ciphered.cipher).toString('utf-8');
                plaintext += chacha20_decipher.final().toString('utf-8');
                resolve(plaintext);
            }
            else{
                reject('Invalid input.');
            }
        });
    }
}

function validateCipher(in_cipher){
    let cipher_buffer; 
    try{
        cipher_buffer = Buffer.from(in_cipher,'base64');
    }catch(cipher_err){
        // bad nonce!
        console.error('BAD CIPHER >>> ',cipher_err);
        return `Invalid Cipher! Not valid base64!`;
    }
    if(cipher_buffer.byteLength == 0){
        return `Invalid Cipher! Cannot be empty.`;
    }
    return cipher_buffer;
}
function validateNonce(in_nonce){
    let nonce_buffer; 
    try{
        nonce_buffer = Buffer.from(in_nonce,'base64');
    }catch(nonce_err){
        // bad nonce!
        console.error('BAD NONCE >>> ',nonce_err);
        return `Invalid Nonce! Not valid base64!`;
    }
    if(nonce_buffer.byteLength != 12){
        return `Invalid Nonce! Length should be 12. Len was: ${nonce_buffer.byteLength}`;
    }
    return nonce_buffer;
}

class Ciphered{
    constructor(data){
        const me = this;
        if (!data?.nonce || !data?.cipher){
            me.input_error = 'Bad Input. Missing nonce or cipher fields.';
        }
        else{
            let val_cipher = validateCipher(data.cipher);
            if (val_cipher instanceof Buffer){
                me.cipher = val_cipher;
                let val_nonce = validateNonce(data.nonce);
                if (val_nonce instanceof Buffer){
                    me.nonce = val_nonce;
                    me.valid = true;
                    me.req_id = data.nonce;
                }
                else{
                    me.input_error = val_nonce;
                }
            }
            else{
                me.input_error = val_cipher;
            }
        }
    }    
}

const myChaCha20 = new MyChaCha20();
module.exports ={myChaCha20,Ciphered}
