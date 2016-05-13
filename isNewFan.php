<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Mon, 1 Mon 1990 00:00:00 GMT");
header("Last-Modified: ".gmdate('D, d M Y H:i:s') . " GMT");
include('protected/db_con.php');
/*include('protected/public.php');
include('protected/parse_signed_request.php');
if(!empty($_GET['sr']))
	$signed_request=parse_signed_request($_GET['sr'],$secret);
else 
	return;*/

$iSql="INSERT INTO `newfan`( `fbid`) VALUES ('".$_GET['uid']."')";
echo json_encode(mysql_query($iSql,$conn));
?>