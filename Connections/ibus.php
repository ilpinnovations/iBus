<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ibus = "localhost";
$database_ibus = "ibus";
$username_ibus = "root";
$password_ibus = "";
$ibus = mysql_pconnect($hostname_ibus, $username_ibus, $password_ibus) or trigger_error(mysql_error(),E_USER_ERROR); 
?>