<?php

/*
    Since PHP has no console to log stdout/stderr to, we have to do this instead. 
    This just logs to a file specified when the object is constructed. 
*/
class MyLog
{
    private string $Log_File = '';

    function __construct(string $logFile)
    {
        $this->Log_File = $logFile;
        if (file_exists($this->Log_File)){
            // if log file already exists, we wipe its contents
            // so the file only contains the 'last run' 
            // because this is meant to be ephemeral, like a console window :P
            file_put_contents($this->Log_File,"");
        }
    }

    // log a variable number of args as single "log entry" 
    // thankfully this language at least has varargs support :D 
    // (so this func can work like js console.log or py print does...)
    function log(...$args)
    {
        // prep the array of strings we will join at the end
        $logArgs = array();
        // iterate the varargs 
        foreach($args as $a){
            $tmp = '';
            if (is_array($a) || is_object($a)){
                // if arg is an obj or array convert to json, easiest way to display as string for log
                $tmp = json_encode($a,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            }
            elseif (is_string($a)){
                // arg already a string
                $tmp = $a;
            }
            else{
                // primitive non-string, convert to string value
                $tmp = strval($a);
            }
            // plunk it into the string array
            array_push($logArgs,$tmp);
        }
        // join string array to one string for log, delimit with space
        // this is what other langs do
        $msg = implode(" ",$logArgs)."\n";
        // finally, write to our log file, appending 
        file_put_contents($this->Log_File,$msg,FILE_APPEND);
    }
}