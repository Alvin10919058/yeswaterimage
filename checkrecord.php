<?php

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Mon, 1 Mon 1990 00:00:00 GMT");
header("Last-Modified: ".gmdate('D, d M Y H:i:s') . " GMT");
if(strtotime(date('Y-m-d'))>=strtotime("2014-08-05")) {echo '004'; return;}
include('protected/db_con.php');
include('protected/public.php');
include('protected/parse_signed_request.php');
if(!empty($_GET['sr']))
	$signed_request=parse_signed_request($_GET['sr'],$secret);
else return;

$rSql="SELECT `fbid` FROM `vote` WHERE `date` =  '".date('Y-m-d')."' AND `fbid`='".$signed_request['user_id']."'";

$query=mysql_query($rSql);
if(mysql_fetch_array($query)) { echo '002'; } //repeat:002
else {echo '003'; } //valid:003 
return;
?>