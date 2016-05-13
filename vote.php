<?php

	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: Mon, 1 Mon 1990 00:00:00 GMT");
	header("Last-Modified: ".gmdate('D, d M Y H:i:s') . " GMT");
	include('protected/db_con.php');
	include('protected/public.php');
	include('protected/parse_signed_request.php');

//if(strtotime(date('Y-m-d'))>=strtotime("2014-09-13")) {echo '004'; return;}
if(strtotime(date('Y-m-d H:i:s'))<strtotime("2014-11-25 12:00:00") || strtotime(date('Y-m-d H:i:s'))>=strtotime("2016-12-28 23:59:59")) {echo '004'; return;}

if(!empty($_GET['sr']))
	$signed_request=parse_signed_request($_GET['sr'],$secret);
else return;

$rSql="SELECT `ip` FROM `vote` WHERE `date`= '".date('Y-m-d')."' AND `ip`='".$_GET['ip']."';";
$result=mysql_query($rSql);
if(mysql_num_rows($result)>=5) { echo '006';return; } //相同IP位址一天只能投五票

$rSql="SELECT `fbid` FROM `vote` WHERE `date` =  '".date('Y-m-d')."' AND `fbid`='".$signed_request['user_id']."';";

$result=mysql_query($rSql);
if(mysql_num_rows($result)>=1) { echo '002';return; } //一組帳號一天只能投一次
else 
{	
	if($signed_request!=null && $_GET['target']!=null && $_GET['fbname']!=null && $_GET['targetname']!=null)
	{
		$iSql="INSERT INTO `vote`(`date`, `fbid`, `target`, `fbname`, `time`, `targetname`,`ip`) VALUES ('".date('Y-m-d')."' , '".$signed_request['user_id']."' , '".$_GET['target']."'
		, '".$_GET['fbname']."' , '".date('H:i:s')."' , '".$_GET['targetname']."' , '".$_GET['ip']."')";
		mysql_query($iSql,$conn);
		
		//投完票之後還要更新參賽者的票
		//先比對參賽者，將票數抓出
		$iSql2 = "SELECT * FROM `candidate` WHERE `candidno` = '".$_GET['target']."' ";
		$query2 = mysql_query($iSql2,$conn);
		while($result=mysql_fetch_array($query2))
			$count = $result['count'];
		$count = $count + 1;
		
		//將票數更新到資料庫
		$iSql3 = "UPDATE `candidate` SET `count`= '$count' WHERE `candidno` = '".$_GET['target']."' ";
		mysql_query($iSql3,$conn);
		
		echo '003';
	}
	else
		echo '005';
}
?>