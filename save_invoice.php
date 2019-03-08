<?php
include "dbcon.php";
require "fpdf.php";



session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}


class myPDF extends FPDF{

  function header(){

    $invoice_number = $_POST['invoice_number'];
    $date    =$_POST['date'];


    $this->SetFont('Arial','B',20);
    $this->Cell(276,10,'Pharmacy Invoice',0,0,'C');
    $this->Ln(20);
    $this->Cell(80,40,'Invoice Number:'.$invoice_number,0,0,'C');
    $this->Ln();
    $this->Cell(50,-10,$date,0,0,'C');
    $this->Ln(10);
    
  }

  function footer(){

        $this->Cell(276,10,'Thank you',0,0,'C');
        $this->Ln(20);

  }

  function headerTable(){

    $this->SetFont('Times','B',15);
    $this->Cell(40,10,'Product Name',1,0,'C');
    $this->Cell(40,10,'Category',1,0,'C');
    $this->Cell(40,10,'Qty',1,0,'C');
    $this->Cell(50,10,'Price',1,0,'C');
    $this->Cell(100,10,'Amount',1,0,'C');
    $this->Ln();
  }
 function viewTable(){

  include "dbcon.php";

     $paid_amount = $_POST['paid_amount'];
     $invoice_number = $_POST['invoice_number'];

       $select_sql = "SELECT * FROM on_hold where invoice_number = '$invoice_number'";

         $select_query =mysqli_query($con,$select_sql);

          while($row = mysqli_fetch_array($select_query)){
    $this->SetFont('Times','',12);
    $this->Cell(40,10,$row['medicine_name'],1,0,'C');
    $this->Cell(40,10,$row['category'],1,0,'C');
    $this->Cell(40,10,$row['qty']."(".$row['type'].")",1,0,'C');
    $this->Cell(50,10,$row['cost'],1,0,'C');
    $this->Cell(100,10,$row['amount'],1,0,'C');
    $this->Ln();

  }

    $select_sql = "SELECT sum(amount) from on_hold where invoice_number = '$invoice_number'";

          $select_sql = mysqli_query($con,$select_sql); 

          while($row = mysqli_fetch_array($select_sql)){

            $amount =  $row['sum(amount)'];


    $this->Cell(170,10,'Total',1,0,'C');
    $this->Cell(100,10,$amount,1,0,'C');
    $this->Ln();
  
      $this->SetFont('Times','B',15);
     $this->Cell(170,10,'Paid Amount',1,0,'C');
    $this->Cell(100,10,$paid_amount,1,0,'C');
    $this->Ln();
    $this->SetFont('Times','B',20);
     $this->Cell(170,10,'Change Amount',1,0,'C');
    $this->Cell(100,10,$paid_amount-$amount,1,0,'C');
    $this->Ln(20);

  }

  

 }
 function invoice_number(){//*****Outputting a New Voucher code*******

    $chars = "09302909209300923";

    srand((double)microtime()*1000000);

    $i = 1;

    $pass = '';

    while($i <=7){

      $num  = rand()%10;
      $tmp  = substr($chars, $num,1);
      $pass = $pass.$tmp;
      $i++;
    }
    return $pass;

  }
  /*****Outputting a New Voucher code*******/
}

$date1 = date("YMd");
    

  if(!file_exists("C:/invoices")){

    mkdir("C:/invoices");


  }
  if(!file_exists("C:/invoices/$date1")){

    mkdir("C:/invoices/$date1");

  }
  if(!file_exists("C:/invoices/all_invoices")){

    mkdir("C:/invoices/all_invoices");
  }

if(isset($_POST['submit'])){

  $invoice_number = $_POST['invoice_number'];
  $date = $_POST['date'];
   $medicine_name = $_POST['medicine_name'];
   @$medicines = implode($medicine_name, ",");
   $quantity = $_POST['qty'];
   $qty = implode($quantity, ",");
   $qty_type = $qty;
   $filename = "i-".$invoice_number.".pdf";
   $dir      = "";

  $pdf = new myPDF();
 $pdf->AddPage('L','A4',0);
 $pdf->headerTable();
 $pdf->viewTable();
 $pdf->Output('C:/invoices/'.$date1.'/'.$filename,'F');
 $pdf->Output('C:/invoices/all_invoices/'.$filename,'F');

 $select_on_hold = "SELECT * From on_hold where invoice_number = '$invoice_number'";

 $select_on_hold_query = mysqli_query($con,$select_on_hold);

  $row = mysqli_fetch_array($select_on_hold_query);

  $med_name = $row['medicine_name'];
  $category = $row['category'];
  $expire_date = $row['expire_date'];

  $select_stock = "SELECT * from stock where medicine_name = '$med_name' and category = '$category' and expire_date = '$expire_date'";

  $select_stock_query = mysqli_query($con,$select_stock);

  $row = mysqli_fetch_array($select_stock_query);

  $remain_quantity = $row['remain_quantity'];

	$select_sql = "SELECT invoice_number ,sum(amount) ,sum(profit_amount) FROM on_hold where invoice_number = '$invoice_number'";
	$select_query  = mysqli_query($con,$select_sql);

	while ($row = mysqli_fetch_array($select_query)) {
     $on_hold_invoice=$row['invoice_number'];
		 $total_amount =$row['sum(amount)'];
		  $total_profit = $row['sum(profit_amount)'];
	}

  $insert_sql = "INSERT INTO sales values('','$invoice_number','$medicines','$qty_type','$total_amount','$total_profit','$date')";
	$insert_query = mysqli_query($con,$insert_sql);
  if($insert_query){

      $update_stock = "UPDATE stock SET act_remain_quantity = '$remain_quantity' where medicine_name = '$med_name' and category = '$category' and expire_date = '$expire_date'";

      $update_stock_query = mysqli_query($con,$update_stock);

    if($update_stock_query){

      echo "Hello woer";
    }else{

      echo "Sorry";
    }
  }else{

    echo "slekfjs";
  }
  $new_invoice_number  = "RS-".$pdf->invoice_number();
  header("location:home.php?invoice_number=$new_invoice_number");
}

?>

