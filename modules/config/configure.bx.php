<?php

//bx/config/configure.bx.php
$bx["client"]["view"] = "administrator";
$bx["client"]["views"]["administrator"]["branch"] = "bxbranch_";
$bx["client"]["views"]["administrator"]["user"] = "bxuser_";
$bx["client"]["views"]["administrator"]["cert"] = "bxcert_";
$bx["client"]["views"]["administrator"]["key"] = "bxkey_";
$bx["server"]["sql"]["servers"][] = "localhost";
$bx["server"]["sql"]["servers"][] = "127.0.0.1";
$bx["server"]["sql"]["username"] = "bxsql_user_";
$bx["server"]["sql"]["password"] = "bxsql_pass_";
file_put_contents("bx.json", json_encode($bx, JSON_PRETTY_PRINT));
