<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Mon, 1 Mon 1990 00:00:00 GMT");
header("Last-Modified: ".gmdate('D, d M Y H:i:s') . " GMT");

include('protected/db_con.php');
if(!empty($_GET['ip']))
	$iSql="INSERT INTO `vote`(`date`,`fbid`,`target`,`ip`) VALUES ('".date('Y-m-d')."' , '".$_GET['uid']."' , '".$_GET['target']."' , '".$_GET['ip']."')";
mysql_query($iSql,$conn);
?>