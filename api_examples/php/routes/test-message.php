<?php

$log->log("REQUEST NONCE >>> ",bin2hex(base64_decode($data["nonce"])));
$log->log("REQUEST CIPHER >>> ",bin2hex(base64_decode($data["cipher"])));

$plaintext = $chacha20->chacha20_decrypt($data["cipher"],$settings->CHACHA20_KEY,$data["nonce"],true,$settings->CHACHA20_INIT_COUNTER);
$log->log("DECIPHER >>> ",$plaintext);

$reply_message = "PHP got \"" . $plaintext . "\" at " . date('Y-m-d H:i:s');
$log->log("REPLY MSG >>> ",$reply_message);

$nonce_bin = random_bytes(12);
$nonce_b64 = base64_encode($nonce_bin);

$cipher = $chacha20->chacha20_encrypt($reply_message,$settings->CHACHA20_KEY,$nonce_b64,true,$settings->CHACHA20_INIT_COUNTER);

$log->log("REPLY NONCE >>> ",$nonce_b64);
$log->log("REPLY CIPHER >>> ",$cipher);

$response = new Response();
$response->req_id = $data["nonce"];
$response->nonce = $nonce_b64;
$response->cipher = $cipher;

echo json_encode($response)."\n";