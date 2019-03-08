<?php

   session_start();

  if(!isset($_SESSION['user_session'])){
    
      header("location:../index.php");

  }

?>
<!DOCTYPE html>
<html>
<head>
 <title>Pharmacy Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="../src/facebox.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../src/facebox.js"></script>
    <script type="text/javascript">

       jQuery(document).ready(function($) {//*****POP_UP FORMS*********
    $("a[id*=popup").facebox({
      loadingImage : '../src/img/loading.gif',
      closeImage   : '../src/img/closelabel.png'
    })
  })//*****POP_UP FORMS*********

    </script>
     
</head>
<body>
  <body style="height: 100%">
  <div class="navbar navbar-inverse navbar-fixed-top"><!--***HEADER****---->
      <div class="navbar-inner" style="background: #000;">
        <div class="container-fluid">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
          </a>

          <a class="brand" href="#"><b>Pharmacy System</b></a>
        <div class="nav-collapse">
            <ul class="nav pull-right">
               
               <li>

               
        <?php 
        include("../dbcon.php");

          $quantity = "5";
          $select_sql1 = "SELECT * FROM stock where remain_quantity <= '$quantity' and status='Available'";
          $result1 = mysqli_query($con,$select_sql1);
          $row2 = $result1->num_rows;

         if($row2 == 0){

            echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-exclamation-sign icon-large"></span></a>';

          }else{
            echo ' <a  href="../qty_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-exclamation-sign icon-large"></span>
                <span class="badge">'.$row2.'</span></a>';

    
          }


          ?> 
        </li>
          <li>
            <?php
              $date = date('d-m-Y');    
        $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date))); 
        $select_sql = "SELECT  * FROM stock WHERE expire_date <= '$inc_date' and status='Available' ";
         $result =  mysqli_query($con,$select_sql); 
          $row1 = $result->num_rows;

            if($row1 == 0){

                 echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-bell icon-large"></span></a>';

          }else{
            echo ' <a  href="../ex_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-bell icon-large"></span>
                <span class="badge">'.$row1.'</span></a>';

            }
            ?>
            
          </li>
        

      <li><a href="../home.php?invoice_number=<?php echo $_GET['invoice_number']?>"><span class="icon-home"></span>Home</a></li>
        
         <li><a href="../sales_report.php?invoice_number=<?php echo $_GET['invoice_number']?>"><span class="icon-bar-chart"></span>Sales Report</a></li>
         <li><a href="../logout.php" class="link"><font color='red'><span class="icon-off"></span></font>Logout</a></li>
       </ul>
      </div>
         
        </div>
      </div>
  </div><br><br><!--***HEADER****---->



     <div class="container"><!---****SEARCHES_CONTENT*****--->

      <div class="contentheader">
      <h1>Products</h1>
       </div><br>

        <input type="text"  id="name_med1" size="4"  onkeyup="med_name1()" placeholder="Search for Medicine names.." title="Type in a name">
        <input type="text" size="4"  id="med_quantity" onkeyup="quanti()" placeholder="Search for Category.." title="Type in a quantity">
        <input type="text" size="4" id="med_exp_date" onkeyup="exp_date()" placeholder="Search for Expire date.." title="Type in a date">
        <input type="text" size="4" id="med_status" onkeyup="stat_search()" placeholder="Search for Status.." title="Type in a Status">
       <a href="index.php?invoice_number=<?php echo $_GET['invoice_number']?>" id="popup"><button class="btn-primary btn-large" name="submit"><span class="icon-plus-sign icon-large"></span>Add New Medicine</button></a>
           <form action="import_xls.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
          
       
           <input type="file" name="file"
               id="file" accept=".xls,.xlsx" required>
            </div>

       <button class="btn-danger btn-large" name="submit"><span class="icon-download icon-large">Import Excel file</span></button>

        <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
          
        </div>
    
          
        </form>
 

    </div><br><!---****SEARCHES_CONTENT*****--->

 
    <?php

       include('../dbcon.php');

         $select_sql = "SELECT * FROM stock order by quantity";
         $select_query = mysqli_query($con,$select_sql);
         $row = mysqli_num_rows($select_query);

    ?>

      <div style="text-align:center;">
        Total Medicines : <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $row;?>]</font>
      </div>
    <div class="container" style="overflow-x:auto; overflow-y: auto;"><!---***CONTENT****----->
    <form method="POST">
          <div style="overflow-x:auto; overflow-y: auto; height: 370px;">
          <table id="table0" class="table table-bordered" style="width: 100%; border-color: #000000 " >
           <thead>
             <tr style="background-color: #002233; color: #FFFFFF;" >
             <th width="3%">Medicine name</th>
             <th width="1%">Catgory</th>
             <th style="background-color: green;" width="5%">Register qty</th>
             <th style="background-color: orange;" width="1%">Used qty</th>
             <th  width="1%">Remain qty</th>
             <th style="background-color: green;" width="1%">Registred date</th>
             <th style="background-color: red;" width="1%">Expire date</th>
             <th width="1%">Remark</th>     
             <th width="2%">Acutal Price</th>
             <th style="background-color: orange" width="2%">Selling Price</th>
             <th style="background-color: green;" width="2%">Profit Price</th>
             <th width = "3%">Status</th>
             <th width = "5%">Action</th>
             </tr>
           </thead>
            <tbody>
   
        <?php include("../dbcon.php"); ?>
        <?php $sql = "SELECT  id, medicine_name, category, quantity,used_quantity, remain_quantity,act_remain_quantity, register_date, expire_date, company, sell_type , actual_price, selling_price, profit_price, status FROM stock order by id desc"; ?>
        <?php $result =  mysqli_query($con,$sql); ?>
      <!--Use a while loop to make a table row for every DB row-->
        <?php while( $row =  mysqli_fetch_array($result)) : ?>


        <tr style="background-color: #C0C0C0;">
            <!--Each table column is echoed in to a td cell-->
              <td><?php echo $row['medicine_name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['quantity']."&nbsp;&nbsp;(<strong><i>".$row['sell_type']."</i></strong>)"?></td>              
            <td><?php echo $row['used_quantity']; ?></td>
            <td><?php echo $row['remain_quantity']; ?></td>
            <td><?php echo  date("d-m-Y", strtotime($row['register_date'])); ?></td>
            <td><?php echo date("d-m-Y", strtotime($row['expire_date'])); ?></td>
            <td><?php echo $row['company']; ?></td>
            <td><?php echo $row['actual_price']; ?></td>
            <td><?php echo $row['selling_price']; ?></td>
            <td><?php echo $row['profit_price']; ?></td>
            <td><?php $status = $row['status'];

                if($status == 'Available'){
                  echo '<span class="label label-success">'.$status.'</span>';
                }else{
                  echo '<span class="label label-danger">'.$status.'</span>';
                }

            ?></td>
            <td><a id="popup" href="update_view.php?id=<?php echo $row['id']?>&invoice_number=<?php echo $_GET['invoice_number']?>"><button class="btn btn-warning"><span class="icon-edit"></span></button></a>
          <button class="btn btn-danger delete" id="<?php echo $row['id']?>"><span class="icon-trash"></span>&nbsp;</button></td>

            </tr>
        <?php endwhile ?>
    </tbody>
           </table>
         </div>
      </form> 
    </div>
 </body>
</html>

<script type="text/javascript">
function med_name1() {//***Search For Medicine *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("name_med1");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


function quanti() {//***Search For quantity *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_quantity");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function exp_date() {//***Search For expireDate *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_exp_date");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


function stat_search() {//***Search For Status*****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_status");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[11];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

$(".delete").click(function(){//***Showing Alert When Deleting*****

  var element = $(this);

  var del_id = element.attr("id");

  var info = 'id='+del_id;

  if(confirm("Delte This Product!!Are You Sure??")){

    $.ajax({

      type :"GET",
      url  :'delete.php',
      data :info,
      success:function(){
        location.reload(true);
      },
      error:function(){
        alert("error");
      }

    });
    
  }
  return false;

});//***Showing Alert When Deleting********



</script>

