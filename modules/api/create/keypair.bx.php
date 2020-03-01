<?php //bx/api/create/keypair.bx.php
$bxcrypto_output["bxsession_key"] = bxcrypto_generate("key");
$bxcrypto_output["bxsession_cert"] = bxcrypto_generate("cert");
bxapi_success(bxapi_output($bxcrypto_output));
