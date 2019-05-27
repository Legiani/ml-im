<?php
//DB config
$config["DBuser"]  = "a183248_quiz";
$config["DBpassword"] = "F?P365il,v";
$config["DBserver"]    = "md14.wedos.net";
$config["DBdatabase"]  = "d183248_quiz";

$file = file_get_contents(__DIR__ .'/assets/lang/cz.json');
$js_data = json_decode($file);
foreach ($js_data as $value) {
    foreach ($value as $key => $val) {
        $config[$key] = $val;
    }
}


