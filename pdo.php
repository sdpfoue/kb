<?php
// configuration
$dbtype     = "mysql";
$dbhost     = "127.0.0.1";
$dbname     = "task1";
$dbuser     = "root";
$dbpass     = "";
 
// database connection
return $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
