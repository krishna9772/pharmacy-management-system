<?php



    error_reporting(1);
 
    include("dbcon.php");


session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}
    
    $hid_qty = $_POST['hid_qty'];
    $upd_qty  =  $_POST['qty'];
    $med_id   = $_POST['med_id'];
    $med_name = $_POST['med_name'];
    $med_cat  = $_POST['med_cat'];
    $ex_date  = $_POST['ex_date'];


    $select_sql = "SELECT * from stock where medicine_name = '$med_name' and category = '$med_cat' and expire_date = '$ex_date' ";

    $result1 = mysqli_query($con,$select_sql);

     while($row=mysqli_fetch_array($result1)){

    $amount =$upd_qty * $row['selling_price'];

    $profit_amount =$upd_qty * $row['profit_price'];

    $quantity  = $row['act_remain_quantity'];
     }

     echo $avai_qty;

     if($upd_qty > $quantity){


   }else{
      
    $update_sql = "UPDATE stock SET used_quantity = (used_quantity - '$hid_qty') + '$upd_qty' , remain_quantity = (remain_quantity + '$hid_qty')-'$upd_qty'  where medicine_name = '$med_name' and category = '$med_cat' and expire_date = '$ex_date' ";

    $result = mysqli_query($con,$update_sql);

    $update_sql1 = "UPDATE on_hold SET qty = '$upd_qty' , amount = '$amount' , profit_amount = '$profit_amount' where id = '$med_id'";

   $result2 = mysqli_query($con,$update_sql1);  


   $select_sql1= "SELECT remain_quantity from stock where medicine_name = '$med_name' and category = '$med_cat' and expire_date = '$ex_date' ";

   $result3 = mysqli_query($con,$select_sql1);

    while($row = mysqli_fetch_array($result3)){

        $remain_quantity = $row['remain_quantity'];

    }

   if($remain_quantity <= 0){

           $update_quantity_sql = "UPDATE stock set status =  'Unavailable' where medicine_name = '$med_name' and expire_date = '$ex_date' ";//********Updating Unavailable if medicine_qty  is zero***********

           $update_quantity_query = mysqli_query($con,$update_quantity_sql);
       }

       if($remain_quantity > 0){

         $update_quantity_sql1 = "UPDATE stock set status =  'Available' where medicine_name = '$med_name' and expire_date = '$ex_date'";//********Updating Unavailable if medicine_qty  is zero***********

           $update_quantity_query1 = mysqli_query($con,$update_quantity_sql1);
           
       }

   }

?>