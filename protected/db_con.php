<?php
if(!isset($ac)){
    $host = 'localhost';
    $ac = 'youngfbc';
    $pwd = '29SC_Lab49 SISU';
    $db = 'youngfbc_yeswaterimage';
}
$conn = mysql_connect($host,$ac,$pwd);
if (empty($conn)) {
    print ("Unable to Connect to Database!!");
    print mysql_error();
    exit;
}else {
    if (mysql_select_db($db,$conn) != True) {            
        print ("Unable to Select Database!!");
        exit;
    } else {
        mysql_query("SET NAMES 'utf8'"); 
        mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
        mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
    }
}
?>