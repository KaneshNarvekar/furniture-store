<?php
    $connection = mysqli_connect("localhost", "dava", "password");
    if (!$connection) die("<ERROR: Cannot connect to database>");
    $database = mysqli_select_db($connection, "projects");
    if (!$database) die("<ERROR:Cannot select database>");

    
?>
