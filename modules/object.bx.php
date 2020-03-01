<?php //bx/modules/object.bx.php
function bxobject_view($id)
{
	global $bxapi_packet;
	$bxsql_result = bxsql_read("SELECT * FROM `objects` WHERE `id` = '$id'");
	if(!bxsql_rows($bxsql_result)) bxapi_failure("object id not found");
	if(!bxpermission_can_view($bxapi_packet["bxsession"]["bxsession_user_id"],$id)) bxapi_failure("permission denied");
	bxapi_success(bxsql_fetch($bxsql_result));
}

