<?php
    $connection = mysql_connect("localhost", "21174777", "21174777");
    if (!$connection) die("<ERROR: Cannot connect to database>");
    $database = mysql_select_db("21174777");
    if (!$database) die("<ERROR:Cannot select database>");
?>
