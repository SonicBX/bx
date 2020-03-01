<?php

//bx/api/session/expire.bx.php
bxsession_validate();
if (isset($bx["cli"])) bxcli_expire();
bxapi_success(bxsession_expire());
