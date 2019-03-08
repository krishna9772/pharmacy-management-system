<?php

require_once('vendor/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');
require_once('../dbcon.php');


session_start();

  if(!isset($_SESSION['user_session'])){
    
      header("location:../index.php");

  }

if(isset($_POST['submit'])){

	@$invoice_number = $_GET['invoice_number'];

 $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'upload_xls/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);

        $sheetCount = count($Reader->sheets());

         for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);

            foreach($Reader as $Row){

            	$medicine_name = "";

            	if(isset($Row[0])){

                    $medicine_name = mysqli_real_escape_string($con,$Row[0]);

                    echo $medicine_name;

            	}

            	$category = "";

            	if(isset($Row[1])){

                    $category = mysqli_real_escape_string($con,$Row[1]);

                    echo $category;


            	}
            	$quantity = "";

            	if(isset($Row[2])){

                    $quantity = mysqli_real_escape_string($con,$Row[2]);

                    echo $quantity;

            	}
            	$used_quantity = "";

            	if(isset($Row[3])){

                    $used_quantity = mysqli_real_escape_string($con,$Row[3]);

                    echo $used_quantity;

            	}

            	$remain_quantity = "";

            	if(isset($Row[4])){

                    $remain_quantity = mysqli_real_escape_string($con,$Row[4]);

                    echo $remain_quantity;


            	}
            	$act_remain_quantity = "";

            	if(isset($Row[5])){

                    $act_remain_quantity = mysqli_real_escape_string($con,$Row[5]);

                    echo $act_remain_quantity;


            	}
            	$register_date = "";

            	if(isset($Row[6])){

                    $register_date = mysqli_real_escape_string($con,$Row[6]);

                    echo $register_date;

            	}
            	$expire_date = "";

            	if(isset($Row[7])){

                    $expire_date = mysqli_real_escape_string($con,$Row[7]);

                    echo $expire_date;

            	}
            	$company = "";

            	if(isset($Row[8])){

                    $company = mysqli_real_escape_string($con,$Row[8]);

                    echo $company;

            	}
            	$sell_type = "";

            	if(isset($Row[9])){
            		$sell_type = mysqli_real_escape_string($con,$Row[9]);

            		echo $sell_type;
            	}
            	$actual_price = "";

            	if(isset($Row[10])){

                    $actual_price = mysqli_real_escape_string($con,$Row[10]);

                    echo $actual_price;

            	}
            	$selling_price = "";

            	if(isset($Row[11])){

                    $selling_price = mysqli_real_escape_string($con,$Row[11]);

                    echo $selling_price;

            	}
            	$profit_price = "";

            	if(isset($Row[12])){

                    $profit_price = mysqli_real_escape_string($con,$Row[12]);

                    echo $profit_price;

            	}
            	$status = "";

            	if(isset($Row[13])){

                    $status = mysqli_real_escape_string($con,$Row[13]);

                   echo  $status;

            	}

            	  if (!empty($medicine_name) || !empty($category) || !empty($quantity) || !empty($used_quantity) || !empty($remain_quantity) || !empty($act_remain_quantity) || !empty($register_date) ||  !empty($expire_date) ||  !empty($company) || !empty($sell_type) || !empty($actual_price) || !empty($selling_price) || !empty($profit_price) || !empty($status)) {

                    $query = "INSERT INTO stock(medicine_name, category, quantity,used_quantity,remain_quantity,act_remain_quantity, register_date, expire_date, company, sell_type , actual_price,selling_price, profit_price,status)  values('".$medicine_name."','".$category."','".$quantity."','".$used_quantity."','".$remain_quantity."','".$remain_quantity."','".$register_date."','".$expire_date."','".$company."','".$sell_type."','".$actual_price."','".$sell_type."','".$profit_price."','".$status."')";

                    $result = mysqli_query($con, $query);
                
                    if (!empty($result)) {
                        echo  "Excel Data Imported into the Database";

                        header("location:view.php?invoice_number=$invoice_number");
                    } else{
                        echo "Problem in Importing Excel Data";
                    }
                }
            }
        }
  } else
  
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }


}


?>