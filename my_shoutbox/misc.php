<?php
/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/

require_once("config.php");


if($_GET['action']=='getname'){

if($_SESSION['chatter_name']){
echo $_SESSION['chatter_name'];
}

} elseif($_GET['action']=='logout'){
session_unset();
session_destroy();
}

?>
