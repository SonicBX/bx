<?php //bx/modules/session.bx.php
function bxsession_validate()
{
	global $bx;
	if(!isset($bx["api"]["packet"]["session"])) bxapi_failure("session not set");
	$bxsession_id = $bx["api"]["packet"]["session"];
	if(!bxcrypto_validate($bxsession_id)) bxapi_failure("session is formatted incorrectly");
	$bxsql_result = bxsql_read("bx","SELECT FROM * FROM `bxsession` WHERE `bxsession_id` = '$bxsession_id'");
	if(!bxsql_rows($bxsql_result)) bxapi_failure("session_id never existed");
	$bxsession_data = bxsql_fetch($bxsql_result);
	$bx["api"]["session"] = $bxsession_data;
	if($bxsession_expired) bxapi_failure("id is expired");
	if($idle > $bxconfig)
	{
		bxapi_warn("session max time limit exceeded");
		return(bxexpire());
	}
	extract(bxsql_fetch_read("SELECT count(1) as `bxsession_allowed` FROM `objects` WHERE `id` = '$idid' AND `bxsession_key` = '$bxsession_key' AND `value` = '$cert' AND `deletor` IS NULL AND `disabled` = '0'"));
	if(!isset($bxsession_allowed) || !$bxsession_allowed)
	{
		bxapi_warn("one of the following conditions is true...");
		bxapi_warn("the id for this session is no longer in the database");
		bxapi_warn("the key for this id has changed since the session started");
		bxapi_warn("the cert for this id has changed since the session started");
		bxapi_warn("the id for this session is marked disabled");
		bxapi_warn("the id for this session is marked deleted");
		return(bxexpire());
	}
	bxsql_write("bx","UPDATE `bxsessions` SET `bxsession_updated` = current_timestamp() WHERE `bxsession_id` = '$bxsession_id'");
	return(true);
}

function bxsession_start()
{
	global $bx;
	if(!isset($bx["api"]["packet"]["id"]["key"])) bxapi_failure("key not set");
	if(!isset($bx["api"]["packet"]["id"]["cert"])) bxapi_failure("cert not set");
	if(!isset($bx["api"]["packet"]["id"]["image_id"])) bxapi_failure("image_id not set");
	if(!isset($bx["api"]["packet"]["id"]["person_id"])) bxapi_failure("person_id not set");
	if(!isset($bx["api"]["packet"]["id"]["org_id"])) bxapi_failure("org_id not set");
	$bxid_key = $bx["api"]["packet"]["id"]["key"];
	$bxid_cert = $bx["api"]["packet"]["id"]["cert"];
	$bxid_image_id = $bx["api"]["packet"]["id"]["image_id"];
	$bxid_person_id = $bx["api"]["packet"]["id"]["person_id"];
	$bxid_org_id = $bx["api"]["packet"]["id"]["org_id"];
	if(!bxcrypto_validate($bxid_key)) bxapi_failure("invalid key format");
	if(!bxcrypto_validate($bxid_cert)) bxapi_failure("invalid cert format");
	if(!bxcrypto_validate($bxid_image_id)) bxapi_failure("invalid image_id format");
	if(!bxcrypto_validate($bxid_person_id)) bxapi_failure("invalid person_id format");
	if(!bxcrypto_validate($bxid_org_id)) bxapi_failure("invalid org_id format");
	extract(bxsql_fetch_read("bx","SELECT count(1) as `bxid_allowed` FROM `bxid` WHERE `bxid_key` = '$bxid_key' AND `bxid_cert` = '$bxid_cert' AND `bxid_deletor` IS NULL"));
	if(!$bxid_allowed) bxapi_failure("id denied");
	$bxsession_created = false;
	while(!$bxsession_created)
	{
		$bxsession_id = bxcrypto_generate("session");
		extract(bxsql_fetch_read("bx","SELECT count(1) as `bxsession_id_used` FROM `bxsession` WHERE `bxsession_id` = '$bxsession_id'"));
		if(!$bxsession_id_used)
		{
			bxsql_write("bx","INSERT INTO `bxsessions` (`bxsession_id`,`bxsession_image_id`,`bxsession_person_id`,`bxsession_org_id`,`bxsession_key`,`bxsession_cert`) VALUES ('$bxsession_id','$bxsession_image_id,'$bxsession_person_id','$bxsession_org_id','$bxsession_key','$bxsession_cert')");
			$bx["api"]["packet"]["session"] = $bxsession_id;
			$bxsession_created = true;
		}
	}
	return(true);
}

function bxexpire()
{
	global $bx;
	$bxsession_id = $bx['api']['packet']['session'];
	bxsql_read("bx","UPDATE `bxsession` SET `bxsession_expired` = current_timestamp() WHERE `bxsession_id` = '$bxsession_id'");
	return(false);
}
