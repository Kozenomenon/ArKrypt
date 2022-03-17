# my_chacha20.py
# Encapsulates the chacha20 cipher usage so it is easier to plunk into your own project. 
import base64 
from Crypto.Cipher import ChaCha20
from Crypto.Random import get_random_bytes
from pydantic import BaseModel, validator
from my_settings import settings

class Ciphered(BaseModel):
    nonce: str 
    cipher: str 

    def GetNonceBase64(self):
        if isinstance(self.nonce,str):
            return self.nonce
        if isinstance(self.nonce,bytes):
            return base64.b64encode(self.nonce)
        else:
            return ""

    # validation for request post body, ensuring base64, and decoding it to bytes to same field
    @validator("nonce","cipher")
    def is_valid_b64(cls,v,field):
        if isinstance(v,str):
            try:
                v = base64.b64decode(v)
            except Exception as err:
                raise ValueError("not valid base64! " + str(err))
        if not isinstance(v,bytes):
            raise ValueError("not valid type! " + type(v))
        if field.name=="nonce" and len(v)!=12:
            raise ValueError("not correct length! Len was: " + str(len(v)))
        return v

class MyChaCha20:
    def encrypt(plaintext:str):
        # initialize a cipher obj from key and new random 12-byte nonce
        chacha20_cipher = ChaCha20.new(key=base64.b64decode(settings.CHACHA20_KEY),
                                       nonce=get_random_bytes(12))
        # initialize block counter based on initial counter setting 
        # kind of dumb this was needed, but alas... 
        chacha20_cipher.seek(settings.CHACHA20_INIT_COUNTER.value * 64) # chacha20 uses 64 byte blocks
        # encrypt the plaintext to produce cipher bytes
        cipher_bytes = chacha20_cipher.encrypt(plaintext.encode('utf-8'))
        # get the nonce, recipient will need this! 
        nonce = chacha20_cipher.nonce
        return  base64.b64encode(cipher_bytes).decode(),base64.b64encode(nonce).decode()


    def decrypt(ciphered:Ciphered):
        chacha20_decipher = ChaCha20.new(key=base64.b64decode(settings.CHACHA20_KEY),
                                         nonce=ciphered.nonce)
        # initialize block counter based on initial counter setting 
        # kind of dumb this was needed, but alas... 
        chacha20_decipher.seek(settings.CHACHA20_INIT_COUNTER.value * 64) # chacha20 uses 64 byte blocks
        # decrypt the ciphertext decode to utf-8 str
        return chacha20_decipher.decrypt(ciphered.cipher).decode('utf-8')

