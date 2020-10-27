<?php
$server="localhost";
$username="root";
$pass="";
$dbname="idiscuss";

$conn=mysqli_connect($server, $username, $pass, $dbname);
if(!$conn){
    die("you are not conneted");
}

?>