<?php

//bx/api/create/keypair.bx.php
$bxid_output["bxsession_key"]  = bxid_generate("key");
$bxid_output["bxsession_cert"] = bxid_generate("cert");
bxapi_success(bxapi_output($bxid_output));
