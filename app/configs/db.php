<?php 

define("configs_db_host", getenv("MYSQLHOST") ?: "localhost");
define("configs_db_name", getenv("MYSQLDATABASE") ?: "reseller");
define("configs_db_username", getenv("MYSQLUSER") ?: "root");
define("configs_db_password", getenv("MYSQLPASSWORD") ?: "1234");
define("configs_db_port", getenv("MYSQLPORT") ?: "3306");

?>
