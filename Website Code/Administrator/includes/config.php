<?php
$servername = "HP-PC\SQLEXPRESS";
$connectionInfo = array("Database" => "shop", "UID" => "ADMIN", "PWD" => "admin123");

$conn = sqlsrv_connect($servername, $connectionInfo);

if (!$conn)
   die("Connection failed" . sqlsrv_errors());

?>