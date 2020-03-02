<?php

//bx/modules/sql.bx.php

$bx["sql"]["read_connection"] = array();
$bx["sql"]["write_connection"] = array();

function bxsql_fetch($bxsql_result)
{
    return(mysqli_fetch_assoc($bxsql_result));
}

function bxsql_num_rows($bxsql_result)
{
    return(mysqli_num_rows($bxsql_result));
}

function bxsql_fetch_read($bxsql_query)
{
    global $bx;
    if ($bx["sql"]["read_connection"] == array()) bxsql_read_connect();
    if (!$bxsql_result = mysqli_query($bx["sql"]["read_connection"], $bxsql_query))
    {
        bxsql_debug("bxsql_query", $bxsql_query);
        bxsql_debug("mysqli_error", mysqli_error($bx["sql"]["read_connection"]));
        bxsql_failure("sql fetch failed");
    }
    return(mysqli_fetch_assoc($bxsql_result));
}

function bxsql_read($bxsql_query)
{
    global $bx;
    if ($bx["sql"]["read_connection"] == array()) bxsql_read_connect();
    if (!$bxsql_result = mysqli_query($bx["sql"]["read_connection"], $bxsql_query))
    {
        bxapi_debug("bxsql_query", $bxsql_query);
        bxapi_debug("mysqli_error", mysqli_error($bx["sql"]["read_connection"]));
        bxapi_failure("sql read failed");
    }
    return($bxsql_result);
}

function bxsql_write($bxsql_query)
{
    global $bx;
    if ($bx["sql"]["write_connection"] == array()) bxsql_write_connect();
    if (!$bxsql_result = mysqli_query($bx["sql"]["write_connection"], $bxsql_query))
    {
        bxapi_debug("bxsql_query", $bxsql_query);
        bxapi_debug("mysqli_error", mysqli_error($bx["sql"]["write_connection"]));
        bxapi_failure("sql write failed");
    }
    return($bxsql_result);
}

function bxsql_select_image($bxsql_image)
{
    global $bx;
    if ($bx["sql"]["read_connection"] != array()) mysqli_select_db($bx["sql"]["read_connection"], $bxsql_image);
    if ($bx["sql"]["write_connection"] != array()) mysqli_select_db($bx["sql"]["write_connection"], $bxsql_image);
}

function bxsql_read_connect()
{
    global $bx;
    $bxsql_server = array_rand($bx["sql"]["read_servers"]);
    $bxsql_server = $bx["sql"]["read_servers"][$bxsql_server];
}

function bxsql_write_connect()
{
    
}
