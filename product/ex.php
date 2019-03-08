<?php

session_start();
include("../dbcon.php");
error_reporting(1);

  if(!isset($_SESSION['user_session'])){
    
      header("location:../index.php");

  }

  $invoice_number = $_GET['invoice_number'];

  $sql = "SELECT * FROM stock order by id DESC";

  $result = mysqli_query($con,$sql);

  if(mysqli_num_rows($result)>0){

  	while($row = mysqli_fetch_array($result)){
  		$output .="

  		<tr>
  		   <td>". $row['medicine_name']."</td>
            <td>".$row['category']."</td>
            <td>".$row['quantity']."</td>              
            <td>".$row['used_quantity']."</td>
            <td>".$row['remain_quantity']."</td>
            <td>".$row['act_remain_quantity']."</td>
            <td>".date('d-m-Y', strtotime($row['register_date']))."</td>
            <td>".date('d-m-Y', strtotime($row['expire_date']))."</td>
            <td>".$row['company']."</td>
            <td>".$row['sell_type']."</td>
            <td>".$row['actual_price']."</td>
            <td>".$row['selling_price']."</td>
            <td>".$row['profit_price']."</td>
            <td>".$row['status']."</td><br>
  		</tr>
  		";
  	}

  	$output .= '</table>';
  	header("Content-Type: application/xls");
  	header("Content-Disposition: attachment; filename=download.xls");
  	echo $output;
    echo "<script type='text/javascript'>window.top.location='view.php?invoice_number=$invoice_number';</script>";
  }
?>