<?php

//bx/inc/bx.php
$bx_dir = __DIR__ . "/..";
exec("ls $bx_dir/modules/*.bx.php", $bx['modules']);
exec("ls $bx_dir/modules/submodules/*.bx.php", $bx['submodules']);
foreach ($bx['modules'] as $bxmodule)
    require_once($bxmodule);
foreach ($bx['submodules'] as $bxmodule)
    require_once($bxmodule);
