<?php
// decipher the request, expects 'cipher' and 'nonce' to be there on $data
$plaintext = $chacha20->chacha20_decrypt($data["cipher"],$settings->CHACHA20_KEY,$data["nonce"],true,$settings->CHACHA20_INIT_COUNTER);
$log->log("DECIPHER >>> ",$plaintext);
// decode the expected json plaintext to an object
$pw_request = json_decode($plaintext);
$log->log("PAYWALL REQUEST >>> ",$pw_request);
// random choice for demo purposes
$choice = random_int(0,2);
// Response is our generic empty class we use to make proper json results with
$pw_response = new Response();
// nonce of the request becomes the request ID on the response
$pw_response->req_id = $data['nonce'];
switch($choice){
    case 0:
        $pw_response->_revert = true;
        $pw_response->_freemode = true;
        break;
    case 1:
        $pw_response->_revert = true;
        $pw_response->_freemode = false;
        break;
    case 2:
        $pw_response->_ignore = true;
        break;
}
$pw_response->_ts = time();
$pw_response_json = json_encode($pw_response,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
$log->log("REPLY >>>",$pw_response_json);
// cipher reply
$nonce_bin = random_bytes(12);
$nonce_b64 = base64_encode($nonce_bin);
$cipher = $chacha20->chacha20_encrypt($pw_response_json,$settings->CHACHA20_KEY,$nonce_b64,true,$settings->CHACHA20_INIT_COUNTER);
$log->log("REPLY NONCE >>> ",$nonce_b64);
$log->log("REPLY CIPHER >>> ",$cipher);
// return json w/ nonce & ciphertext
$response = new Response();
$response->req_id = $data["nonce"];
$response->nonce = $nonce_b64;
$response->cipher = $cipher;
// send back json. flag is cuz PHP dumb and will by default escape / 
echo json_encode($response,JSON_UNESCAPED_SLASHES)."\n";

