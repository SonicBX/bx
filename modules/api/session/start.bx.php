<?php

//bx/api/session/start.bx.php
bxsession_start();
if (isset($bxcli_dir))
    bxcli_start();
bxapi_success();

