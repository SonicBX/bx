<?php

//bx/modules/cli.bx.php

function bxcli_start()
{
    global $bx, $argv;
    if (isset($argv[1]) && $argv[1] == ".config")
        die("config mode\n");
    if (isset($argv[1]) && $argv[1] == ".debug")
    {
        $bxdebug["debug"]["bx"]   = $bx;
        $bxdebug["debug"]["argv"] = $argv;
        unset($argv[1]);
    }
    bxcli_parse();
    $bx["api"]["capture"]["cli"] = $bx["api"]["packet"];
    bxapi_capture();
}

function bxcli_parse()
{
    global $bx, $argv;
    $bx["api"]["packet"]["input"]   = array();
    $bxcli_command                  = array();
    unset($argv[0]);
    foreach ($argv as $bxcli_arg)
        if (!bxcli_eval($bxcli_arg))
            $bxcli_command[]                = $bxcli_arg;
    $bx["api"]["packet"]["command"] = implode("/", $bxcli_command);
    if (isset($bx["api"]["packet"]["input"]) && count($bx["api"]["packet"]["input"]))
        $bx["api"]["packet"]["input"]   = $bx["api"]["packet"]["input"];
}

function bxcli_eval($bxcli_arg)
{
    global $bx;
    if (!strpos($bxcli_arg, "="))
        return false;
    $bxcli_arg_array              = explode("=", $bxcli_arg);
    $bxcli_arg_key                = $bxcli_arg_array[0];
    unset($bxcli_arg_array[0]);
    $bxcli_arg                    = implode(array_values($bxcli_arg_array), "=");
    $bx["api"]["packet"]["input"] = array_merge_recursive($bx["api"]["packet"]["input"], array($bxcli_arg_key => bxcli_merge($bxcli_arg)));
    return true;
}

function bxcli_merge($bxcli_arg)
{
    if (!strpos($bxcli_arg, "="))
        return $bxcli_arg;
    $bxcli_arg_array = explode("=", $bxcli_arg);
    $bxcli_arg_key   = $bxcli_arg_array[0];
    unset($bxcli_arg_array[0]);
    $bxcli_arg       = implode(array_values($bxcli_arg_array), "=");
    return array($bxcli_arg_key => bxcli_merge($bxcli_arg));
}

function bxcli_session_set()
{
    global $bx;
    $bx["config"]["client"][bxcli_get_view()]["session_id"] = $bxsession_id;
    bxconfig_put("cli");
}

function bxcli_session_unset()
{
    global $bx;
    unset($bx["config"]["client"]["session"]);
    bxconfig_put();
}

function bxcli_get_view()
{
    global $bx;
    return($bx["config"]["client"]["view"]);
}
