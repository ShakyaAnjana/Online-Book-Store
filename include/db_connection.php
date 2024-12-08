<?php
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $db_name = "obs";
    $conn =new mysqli( $serverName, $userName, $password, $db_name);
    if ($conn->connect_error)
    {
        die("Connection Error");
    }
?>