<?php


$servername = "localhost";
$username = "root";
//$password = "TeamUp!306";
$password = "";
$db="hd_Rx";


$con = new mysqli($servername, $username, $password, $db);


if($con->connect_error)
{
    die("connection failed");
}