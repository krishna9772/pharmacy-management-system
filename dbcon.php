<?php


$host ="localhost";
$user ="root";
$password= "";
$dbname = "pharmacy";


$con =mysqli_connect($host,$user,$password,$dbname);

if(!$con){

	echo mysqli_connect_error($con);
}

?> 