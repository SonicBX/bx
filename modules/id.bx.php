<?php

//bx/bxs/id.bx.php
$bxid_chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

function bxid_generate($bxid_type)
{
    global $bxid_chars;
    $bxid_result = "bx" . $bxid_type . "_";
    while (strlen($bxid_result) < 32)
        @$bxid_result .= $bxid_chars[rand(0, strlen($bxid_chars) - 1)];
    return $bxid_result;
}

function bxid_validate($bxid_val)
{
    if (strlen($bxid_val) != 32)
        bxapi_failure("id is not exactly 32 characters");
    if (substr($bxid_val, 0, 2) != "bx")
        bxapi_failure("id does not begin with bx");
    if (!strpos($bxid_val, "_"))
        bxapi_failure("id does not contain an underscore");
    return true;
}
