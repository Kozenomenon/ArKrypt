<?php
// decipher the request, expects 'cipher' and 'nonce' to be there on $data
$plaintext = $chacha20->chacha20_decrypt($data["cipher"],$settings->CHACHA20_KEY,$data["nonce"],true,$settings->CHACHA20_INIT_COUNTER);
$log->log("DECIPHER >>> ",$plaintext);
// decode the expected json plaintext to an object
$conf_request = json_decode($plaintext);
$log->log("CONFIG REQUEST >>> ",$conf_request);
// random choice for demo purposes
$choice = random_int(0,2);
// Response is our generic empty class we use to make proper json results with
$conf_response = new Response();
// nonce of the request becomes the request ID on the response
$conf_response->req_id = $data['nonce'];
switch($choice){
    case 0:
        // some sort of multipliers for dmg and eggs
        $conf_response->_dmg_mult = 1+(30*lcg_value());
        $conf_response->_egg_rate = 5+(6*lcg_value());
        $conf_response->_cheater_detect_on = boolval(lcg_value()>0.5);
        $conf_response->_egg_rate = 5+(6*lcg_value());
        $conf_response->_egg_rate = 5+(6*lcg_value());
        break;
    case 1:
        // some kind of secure event config
        $event_name = array("Christmas","Easter","IndependenceDay","Halloween","ValentinesDay","Thanksgiving")[random_int(0,5)];
        $conf_response->_event = $event_name;
        $conf_response->_event_rate = random_int(1,20);
        $conf_response->_cheater_detect_on = boolval(lcg_value()>0.5);
        break;
    case 2:
        // some kind of secure boss config
        $conf_response->_boss_config = array(
            array(
                "_name"=>"Lumbrr",
                "_hp"=>random_int(9,17)*10000000,
                "_dmg_hi"=>random_int(100,220)*1000,
                "_dmg_lo"=>random_int(20,80)*1000,
                "_loot_level"=>random_int(5,15),
                "_enrage"=>random_int(24,36)*100
            ),
            array(
                "_name"=>"Rektiill",
                "_hp"=>random_int(24,39)*10000000,
                "_dmg_hi"=>random_int(160,320)*1000,
                "_dmg_lo"=>random_int(50,120)*1000,
                "_loot_level"=>random_int(9,25),
                "_enrage"=>random_int(32,50)*100
            )
        );
        break;
}
$conf_response->_ts = time();
$conf_response_json = json_encode($conf_response,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
$log->log("REPLY >>>",$conf_response_json);
// cipher reply
$nonce_bin = random_bytes(12);
$nonce_b64 = base64_encode($nonce_bin);
$cipher = $chacha20->chacha20_encrypt($conf_response_json,$settings->CHACHA20_KEY,$nonce_b64,true,$settings->CHACHA20_INIT_COUNTER);
$log->log("REPLY NONCE >>> ",$nonce_b64);
$log->log("REPLY CIPHER >>> ",$cipher);
// return json w/ nonce & ciphertext
$response = new Response();
$response->req_id = $data["nonce"];
$response->nonce = $nonce_b64;
$response->cipher = $cipher;
// send back json. flag is cuz PHP dumb and will by default escape / 
echo json_encode($response,JSON_UNESCAPED_SLASHES)."\n";

