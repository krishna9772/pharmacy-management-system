<?php

   include("../dbcon.php");


	session_start();

	if(!isset($_SESSION['user_session'])){

	    header("location:index.php");
	}


   if(isset($_POST['submit'])){//***INSERTING NEW  MEDICEINES******
$invoice_number = $_GET['invoice_number'];
	   echo "<h1>....LOADING</h1>";
$bar_code= $_POST['bar_code'];
$med_name= $_POST['med_name'];  
$category= $_POST['category'];    
$quantity=  $_POST['quantity']; 
$reg_date = strtotime($_POST['reg_date']);
$new_reg_date = date('Y-m-d',$reg_date);
$exp_date= strtotime($_POST['exp_date']); 
$new_exp_date = date('Y-m-d',$exp_date);
$company =  $_POST['company']; 
$sell_type = $_POST['sell_type'];
$actual_price = $_POST['actual_price'];  
$selling_price = $_POST['selling_price'];
$profit_price = $_POST['profit_price'];
$status = "Available";
 $sql="INSERT INTO stock(bar_code,medicine_name, category, quantity,remain_quantity,act_remain_quantity, register_date, expire_date, company, sell_type , actual_price,selling_price, profit_price,status) 
 VALUES ('$bar_code','$med_name','$category','$quantity','$quantity','$quantity','$new_reg_date','$new_exp_date','$company','$sell_type','$actual_price','$selling_price','$profit_price','$status')";

   $result =mysqli_query($con,$sql);

   if($result){

   echo "<script type='text/javascript'>window.top.location='view.php?invoice_number=$invoice_number';</script>";

}

}
 

?>