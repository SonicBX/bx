<?php

//bx/modules/config.bx.php
$bx["config_file"] = __DIR__ . "/config/bx.json";
bxconfig_get();

function bxconfig_get()
{
    global $bx;
    if (!file_exists($bx["config_file"]))
        die("fatal error: config file is missing\n");
    if (!$bx["config"] = json_decode(file_get_contents($bx["config_file"]), true))
        die("fatal error: invalid config file format\n");
}

function bxconfig_put()
{
    global $bx;
    if (!file_put_contents($bx["config_file"], json_encode($bx['config'], JSON_PRETTY_PRINT) . "\n"))
        die("ERROR: cannot write to $bxconfig_file\n");
}
