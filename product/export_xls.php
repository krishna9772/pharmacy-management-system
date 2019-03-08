<?php 

namespace Chirp;


include("../dbcon.php");

session_start();

  if(!isset($_SESSION['user_session'])){
    
      header("location:../index.php");

  }

  @$invoice_number = $_GET['invoice_number'];

  // $sql = "SELECT * FROM stock order by id DESC";

  // $result = mysqli_query($con,$sql);

  // if(mysqli_num_rows($result)>0){

  //   while($row = mysqli_fetch_array($result)){

  //     $medicine_name = $row['medicine_name'];
  //     $category      = $row['category'];
  //     $quantity      = $row['quantity'];
  //     $used_quantity = $row['used_quantity'];
  //     $remain_quantity = $row['remain_quantity'];
  //     $act_remain_quantity = $row['act_remain_quantity'];
  //     $register_date   = $row['register_date'];
  //     $expire_date     = $row['expire_date'];
  //     $company          = $row['company'];
  //     $sell_type        =$row['sell_type'];
  //     $actual_price     = $row['actual_price'];
  //     $selling_price    = $row['selling_price'];
  //     $profit_price     = $row['profit_price'];
  //     $status           = $row['status'];
  //   }

  //   $data = array(

  //     array("medicine_name"=>$medicine_name,"category"=>$category,"quantity"=>$quantity,"used_quantity"=>$used_quantity,"remain_quantity"=>$remain_quantity,"act_remain_quantity"=>$act_remain_quantity,"register_date"=>$register_date,"expire_date"=>$expire_date,"company"=>$company,"sell_type"=>$sell_type,"actual_price"=>$actual_price,"selling_price"=>$selling_price,
  //       "profit_price"=>$profit_price,"status"=>$status));
    
  // }
function cleanData(&$str){


  if($str == 't') $str = 'TRUE';
  if($str == 'f') $str = 'FALSE';
  if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4} . \d{1,2} . \d{1,2}/", $str)){

    $str = "'$str'";
  }

  if(strstr($str,'"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

  $filename = "products.xls";

   // header("Content-Disposition:attachment; filename=\"$filename\"");
   // header("Content-Type:text/csv");

   $out = fopen("php://output",'w');

   $flag = false;
  
    $result =mysqli_query($con,"SELECT medicine_name,category,quantity,used_quantity,remain_quantity,act_remain_quantity,register_date,expire_date,company,sell_type,actual_price,selling_price,profit_price,status FROM stock order by id")or die("Query failed");

    while(false !== ($row = mysqli_fetch_assoc($result))){

    array_walk($row,__NAMESPACE__.'\cleanData');
    fputcsv($out,array_values($row),',', '"');

    }

    fclose($out);
    exit;

   ?>