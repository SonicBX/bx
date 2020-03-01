<?php

//bx/modules/api/help/intro.bx.php
global $bx_dir;
$tail = exec("tail -1 $bx_dir/.git/FETCH_HEAD");
$tail = explode("\t", $tail);
bxapi_success($tail[2]);
