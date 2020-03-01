<?php

//bx/api/index.php
$bxdir = __DIR__ . "/..";
require_once("$bxdir/modules/bx.php");

if (!isset($_POST))
    bxapi_failure("no post");
if (!isset($_POST["packets"]))
    bxapi_failure("no packets in post");
if (!$bx["api"]["packets"] = json_decode($_POST["packets"], true))
    bxapi_failure("packets parse error");
if (!sizeof($bx["api"]["packets"]))
    bxapi_failure("packets empty");

bxapi_process_packets();

