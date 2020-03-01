<?php

//bx/modules/api/help/intro.bx.php
global $bx_dir;
exec("cat $bx_dir/LICENSE", $license);
bxapi_success($license);
