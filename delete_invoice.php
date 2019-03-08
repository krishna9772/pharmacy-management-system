<?php

session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}
?>
<?php

include("dbcon.php");

$product_id= $_GET['id'];
$medicine_name= $_GET['name'];
$expire_date = $_GET['expire_date'];
$quantity  = $_GET['quantity'];
$invoice_number=$_GET['invoice_number'];


$update_sql = "UPDATE stock set used_quantity = used_quantity-'$quantity', remain_quantity = remain_quantity + '$quantity' , status = 'Available' where medicine_name = '$medicine_name' and expire_date = '$expire_date' "; //***UPDATE STOCK when medicine deleted from Sale *******

$update_query = mysqli_query($con,$update_sql);
    

	     $delete_sql = "DELETE FROM `on_hold` WHERE id = '$product_id'";//****DELETE on_hold when medicine deleted from Sale ******
	     $delete_query =mysqli_query($con,$delete_sql);

	     if($delete_query){

	     	header("location:home.php?invoice_number=$invoice_number");
	     }else{

	     	echo "Sorry";
	     }

	  
?>