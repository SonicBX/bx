<?php

//bx/modules/api.bx.php
$bxapi_dir = __DIR__ . "/api";
$bx["api"]["packet"] = array();
$bx["api"]["capture"] = array();
$bx["api"]["output"] = array();

function bxapi_post()
{
    global $bx, $_POST;
    if (!isset($_POST)) bxapi_get();
    if (!isset($_POST["packets"])) bxapi_failure("no packets in post");
    if (!$bx["api"]["packets"] = json_decode($_POST["packets"], true)) bxapi_failure("packets parse error");
    if (!sizeof($bx["api"]["packets"])) bxapi_failure("packets empty");
    bxapi_process_packets();
}

function bxapi_get()
{
    print_r($_SERVER);
}

function bxapi_search($bxapi_command)
{
    global $bx;
    foreach (scandir($bxapi_command) as $bxapi_file) if (substr($bxapi_file, 0, 1) != ".") $bx["api"]["packet"]["options"][] = str_replace(".bx.php", "", $bxapi_file);
    bxapi_success();
}

function bxapi_packet()
{
    global $bx, $bxapi_dir;
    $bxapi_command = "$bxapi_dir/";
    $bxapi_command .= $bx["api"]["packet"]["command"];
    if (is_dir($bxapi_command)) bxapi_search($bxapi_command);
    else
    {
        $bxapi_command .= ".bx.php";
        if (!file_exists($bxapi_command)) bxapi_failure("command invalid");
        if (!include($bxapi_command)) bxapi_failure("command failure");
    }
}

function bxapi_capture()
{
    global $bx;
    foreach ($bx["api"]["capture"] as $bx["api"]["packet_id"] => $bx["api"]["packet"]) bxapi_packet();
    if (isset($bx["debug"])) die(json_encode($bx, JSON_PRETTY_PRINT) . "\n");
    die(json_encode($bx["api"]["output"], JSON_PRETTY_PRINT) . "\n");
}

function bxapi_output($bxapi_output)
{
    global $bx;
    $bx["api"]["packet"]["output"] = $bxapi_output;
}

function bxapi_info($bxapi_msg)
{
    global $bx;
    $bx["api"]["packet"]["info"][] = $bxapi_msg;
}

function bxapi_debug($bxapi_msg, $bxapi_var)
{
    global $bx;
    $bx["api"]["packet"]["debug"][$bxapi_msg] = $bxapi_var;
}

function bxapi_warn($bxapi_msg)
{
    global $bx;
    $bx["api"]["packet"]["WARNING"][] = $bxapi_msg;
}

function bxapi_failure($bxapi_msg = NULL)
{
    global $bx;
    if ($bxapi_msg) $bx["api"]["packet"]["FAILURE"] = $bxapi_msg;
    unset($bx["api"]["packet"]["command"]);
    $bx["api"]["packet"]["success"] = false;
    $bx["api"]["output"][$bx["api"]["packet_id"]] = $bx["api"]["packet"];
    die(json_encode($bx["api"]["output"], JSON_PRETTY_PRINT) . "\n");
}

function bxapi_success($bxapi_msg = NULL)
{
    global $bx;
    if ($bxapi_msg) bxapi_info($bxapi_msg);
    unset($bx["api"]["packet"]["command"]);
    $bx["api"]["packet"]["success"] = true;
    $bx["api"]["output"][$bx["api"]["packet_id"]] = $bx["api"]["packet"];
}
