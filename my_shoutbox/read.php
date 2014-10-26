<?php
/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/

require_once("config.php");

function isTime($timestamp){
    return ((string) (int) $timestamp === $timestamp) 
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

//$time=$_GET['time'];

header('Content-type: application/json');
if(!isTime($time)) {
	$q=mysql_query("SELECT * FROM `$tbl3` ORDER BY id DESC LIMIT 30");
} else {
	$q=mysql_query("SELECT * FROM `$tbl3` WHERE time >= '$time' ORDER BY id DESC LIMIT 30");
}

if(!$q){ die(); }
$data=array();
while($r=mysql_fetch_array($q, MYSQL_ASSOC)){
$name=$r['name'];
$r['name']=stripslashes($name);
$message=$r['message'];
$message=preg_replace("/[\r\n]+/", "\n", $message);

$r['message']=nl2br(stripslashes($message));
$url=$r['url'];
$data[]=$r;
}
echo json_encode($data);
?>