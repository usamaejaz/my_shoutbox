<?php
/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/

require_once("config.php");

$time=time();


if($_POST['message']){
$_POST['name']=trim(strip_tags($_POST['name']));

if(!$_SESSION['chatter_name']){
if(empty($_POST['name'])){
die("error");
}

$na=strtolower($_POST['name']);
if($na=='fuck' || $na=='admin'){
die('error');
}


$_SESSION['chatter_name']=$_POST['name'];
}
$_POST['name']=$_SESSION['chatter_name'];

$name=clean($_POST['name']);

$url=$_POST['url'];

if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
$url=$base_url."?utm_source=chat_nourl";
}

$parse = parse_url($url);
$parse_baseurl= parse_url($base_url);
$my_hostname=$parse_baseurl['host'];

if($parse['host']!=$my_hostname){
$name2=strip_tags($_POST['name']);
$url=$base_url."?utm_source=chatter_".$name2;
}

$message=clean(trim(htmlentities($_POST['message'])));


if(empty($message) || empty($name)){

die("error");
}

$q=mysql_query("INSERT INTO `$tbl3` (url,name,message,time) VALUES ('$url', '$name', '$message','$time')");
if(!$q) echo "error";
}



?>