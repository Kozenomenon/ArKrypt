<?php
class MySettings
{
    public $APP_NAME = 'my_php_api';
    public $MOD_IDENTIFIER = 'my_php_pi';
    public $CHACHA20_KEY = 'MEe5PTFa/8tKguOxto91gaYixTiVEY3nowCKhQdlrNk=';
    public $CHACHA20_INIT_COUNTER = 1;

    function __construct()
    {
        if (array_key_exists("APP_NAME",$_ENV) && strlen($_ENV["APP_NAME"])>0) {
            $this->$APP_NAME = $_ENV["APP_NAME"];
        }
        if (array_key_exists("MOD_IDENTIFIER",$_ENV) && strlen($_ENV["MOD_IDENTIFIER"])>0) {
            $this->$MOD_IDENTIFIER = $_ENV["MOD_IDENTIFIER"];
        }
        if (array_key_exists("CHACHA20_KEY",$_ENV) && strlen($_ENV["CHACHA20_KEY"])>0) {
            $this->$CHACHA20_KEY = $_ENV["CHACHA20_KEY"];
        }
        if (array_key_exists("CHACHA20_INIT_COUNTER",$_ENV)){
            $tmpCounter = $_ENV["CHACHA20_INIT_COUNTER"];
            if (strlen($tmpCounter)>0 && is_numeric($tmpCounter)==1) {
                $this->$CHACHA20_INIT_COUNTER = intval($tmpCounter);
            }
        }
    }
}