<?php

//bx/api/create/keypair.bx.php
$bxid_output["cert"] = bxid_generate("cert");
$bxid_output["key"] = bxid_generate("key");
bxapi_success(bxapi_output($bxid_output));
