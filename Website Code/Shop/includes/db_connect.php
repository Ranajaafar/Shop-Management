<?php 
    $servername="HP-PC\SQLEXPRESS";
    $connectionInfo = array("Database"=>"shop", "UID"=>"USER", "PWD"=>"SHOP");

    $conn = sqlsrv_connect($servername,$connectionInfo);
    
    if(!$conn)
       die("Connection failed".sqlsrv_errors());
?>

