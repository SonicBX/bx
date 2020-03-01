<?php

//bx/inc/bx.php
$bx_dir_modules = __DIR__;
exec("ls $bx_dir_modules/*.bx.php", $bx['modules']);
exec("ls $bx_dir_modules/submodules/*.bx.php", $bx['submodules']);
foreach ($bx['modules'] as $bxmodule) require_once($bxmodule);
foreach ($bx['submodules'] as $bxmodule) require_once($bxmodule);
