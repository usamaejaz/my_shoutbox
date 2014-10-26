<?php
/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/

session_start();

#############################################################################

######## Base URL where the script is installed or files are present ########
$base_url="http://www.domain.com/my_shoutbox/";


######## Username for Admin Panel (admin.php) ########
$admin_username="admin";

######## Password for Admin Panel ########
$admin_password="t00r";


######## MySQL Hostname (usually localhost) ########
$host="localhost";

######## DB Username ########
$username="DATABASE_USERNAME_HERE";

######## DB Password ########
$password="DATABASE_PASSWORD_HERE";

######## DB NAME ########
$db_name="DATABASE_NAME_HERE";

######## DB TABLE NAME ########
/* TABLE NAME */
$tbl3="my_shoutbox"; 

#############################################################################


mysql_connect("$host", "$username", "$password");
mysql_select_db("$db_name");
mysql_set_charset("utf8") or error_log(mysql_error()); 
mysql_query("SET character_set_client = utf8, character_set_connection = utf8, character_set_database = utf8, character_set_filesystem = binary, character_set_results = utf8, character_set_server = latin1") or error_log(mysql_error()); 
function clean($str){
return mysql_real_escape_string($str);
}


?>