<?php

session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}

$of=opendir("C:/invoices/all_invoices");
while($file=readdir($of))
{
	 $f = "i-".$_GET['invoice_number'].".pdf";
}

$file = ("C:/invoices/all_invoices/$f");
$filetype=filetype($file);
$filename=basename($file);
header ("Content-Type: $filetype");
header ("Content-Length: ".filesize($file));
header ("Content-Disposition: attachment; filename=".$filename);
readfile($file);
header("sales_report.php?invoice_number=$f");


?>