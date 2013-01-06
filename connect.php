<?php
    $connection = mysql_connect("localhost", "root", "");
    if (!$connection) die("<ERROR: Cannot connect to database>");
    $database = mysql_select_db("davaasuren");
    if (!$database) die("<ERROR:Cannot select database>");
?>
