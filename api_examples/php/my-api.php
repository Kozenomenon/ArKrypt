<?php

header('Content-Type: application/json');
//header("Access-Control-Allow-Methods: POST");
  
class Response
{

}

include "my-settings.php";
include "my-chacha20.php";
include "my-log.php";

$settings = new MySettings();
$chacha20 = new MyChaCha20();

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

$log = new MyLog(__DIR__ . "/" . $request_uri . "-log.txt");

if ($request_method==="POST")
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (is_null($data) || !is_array($data)){
        http_response_code(400);
    }
    elseif (!array_key_exists('nonce',$data) || !array_key_exists('cipher',$data)){
        http_response_code(400);
    }
    else{
        switch ($request_uri) {

            case '/test-message':
                require __DIR__ . '/routes/test-message.php';
                break;
        
            case '/player-is':
                require __DIR__ . '/routes/player-is.php';
                break;
        
            case '/server-paywall':
                require __DIR__ . '/routes/server-paywall.php';
                break;
        
            case '/global-config':
                require __DIR__ . '/routes/global-config.php';
                break;
        
            default:
                http_response_code(404);
                break;
        }
    }
}
else
{
    http_response_code(404);
}

