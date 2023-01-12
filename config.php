<?php
 $host = "localhost"; 
 $username = "root"; 
 $password = ""; 
 $database = "db_brg"; 
 $link = mysqli_connect($host, $username, $password, $database); 

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


               
?>