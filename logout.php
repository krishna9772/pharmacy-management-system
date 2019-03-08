<?php

session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}

session_start();
session_unset();
session_destroy();
header('location:index.php');

?>