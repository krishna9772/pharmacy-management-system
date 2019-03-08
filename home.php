<?php

session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
}                       

?>
<!DOCTYPE html>
<html>
<head>
  <title>POS SYSTEM</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/jquery.css">
  <link rel="stylesheet" type="text/css" href="src/facebox.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style type="text/css">

  </style>
    
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="src/facebox.js"></script>

 
    <script type="text/javascript">
       jQuery(document).ready(function($) {
    $("a[id*=popup]").facebox({
      loadingImage : 'src/img/loading.gif',
      closeImage   : 'src/img/closelabel.png'
    })
  })
    </script>

<script type="text/javascript">


//GET Medicine Name And Expire Date

  $(document).ready(function(){

       $("#qty").focus(

            function(){

              var medicine_name = $("#product_hidden").val();
              var expire_date   = $("#date_hidden").val();

            $.ajax({
              type:'POST',
              url :'auto.php',
              dataType:"json",
              data:{medicine_name:medicine_name,expire_date:expire_date},
              success:function(data){

                $("#avai_qty").val(data);
              },

            });
    });

//GET Medicine Name And Expire Date

         //Disabled Button If Quantity Not Available

          $("#qty").blur(function(){

             var avai_qty = $("#avai_qty").val();
             var in_qty = parseInt($("#qty").val());
             var avai_qty_int = parseInt($("#avai_qty").val());
             if(avai_qty == "" ||  in_qty > avai_qty_int || in_qty <= 0){
                    
                    $("#btn_submit").attr('disabled','disabled');
                    alert("Something went wrong");

             }
             else{

              $("#btn_submit").removeAttr('disabled');

             }

          });

         //Disabled Button If Quantity Not Available
});
     </script>

     <script language="javascript" type="text/javascript">

      //Clock

 var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;

   //Clock
       
     </script>
    

</head>
<body>
 <div class="navbar navbar-inverse navbar-fixed-top"><!--*****Header******-->

      <div class=" navbar-inner" style="background: #000;">
        <div class="container-fluid">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
          </a>

          <a class="brand" href="#"><b>Pharmacy System</b></a>
           <div class="nav-collapse">

            <ul class="nav pull-right">
               <li style="color: #ffffff ;padding: 10px;"><font color="green" size="5">Sales:</font>
                <strong><?php

                  include("dbcon.php");

                  $date = date("Y-m-d");

                  $select_sql = "SELECT sum(total_amount) from sales where Date = '$date'";

                  $select_query = mysqli_query($con,$select_sql);

                  while($row = mysqli_fetch_array($select_query)){

                             echo $row['sum(total_amount)'];


                  }



                ?></strong>

              </li> 


               <li>

               
        <?php 
        include("dbcon.php");

          $quantity = "10";
          $select_sql1 = "SELECT * FROM stock where remain_quantity <= '$quantity' and status='Available'";
          $result1 = mysqli_query($con,$select_sql1);
          $row2 = $result1->num_rows;

         if($row2 == 0){

            echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-exclamation-sign icon-large"></span></a>';

          }else{
            echo ' <a  href="qty_alert.php" class="notification label-inverse" id="popup">
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
            echo ' <a  href="ex_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-bell icon-large"></span>
                <span class="badge">'.$row1.'</span></a>';

            }
            ?>
            
          </li>
         <li><a href="product/view.php?invoice_number=<?php echo $_GET['invoice_number']?>"><span class="icon-bar-chart"></span>Products</a></li>
          <li><a href="sales_report.php?invoice_number=<?php echo $_GET['invoice_number']?>"><span class="icon-bar-chart"></span>Sales Report</a></li>   
         <li><a href="logout.php" class="link"><font color='red'><span class="icon-off"></span></font>Logout</a></li>
         <li><a href="backup.php?invoice_number=<?php echo $_GET['invoice_number']?>"><span class="icon-folder-open"></span>Backup</a></li>
       </ul>
         </div>
        </div>
      </div>
  </div><!--*****Header******-->

 
 <div class="container">

    <i class="icon-calendar icon-large"></i>
                <?php
                $Today = date('y:m:d',mktime());
                $new = date('l, F d, Y', strtotime($Today));
                echo $new;
                ?><br><br>
     

     <form name="clock" method="POST" action="#"><!--*****Clock******-->
     <input style="width:150px;background: #000;color: #fff;border-radius: 5px;height: 30px;" readonly type="submit" class="trans" name="face" value="">
      </form><!--*****Clock******-->
  </div>
   
   <div class="container">
     <div class="contentheader" style="width: 300px;">
      <h1>Sell Here</h1>
     </div><br><br>
   
  <div class="col-md-6">
     <form method="POST" action="insert_invoice.php?invoice_number=<?php echo $_GET['invoice_number']?> " >
      <input type="text" name="bar_code" id="bar_code" autocomplete="off" placeholder="Barcode scan here" style="width:300px;height: 30px;"><br>
  <input type="text" id="product" required  autocomplete="off" placeholder="Enter Medicine Name" style="width:300px;height: 30px;"><br>
  <div class="ui-widget">
  <input type="hidden" name="product" id="product_hidden" required class="form-control" autocomplete="off" placeholder="Enter Medicine Name" style="width:300px;height: 30px;">
</div>
   <input type="hidden" name="expire_date" id="date_hidden" required class="form-control" autocomplete="off" placeholder="Enter Medicine Name" style="width:300px;height: 30px;">
  <input type="number" name="avai_qty" id="avai_qty"  readonly placeholder="Available qty" style="width: 100px; height:30px;">

  <input type="number" name="qty" id="qty"  placeholder="Qty" autocomplete="off"  style="width: 100px; height:30px;" required>
  <input type="hidden" name="date" value="<?php echo date("m/d/Y");?>">
  <Button type="submit"  name="submit" class="btn btn-info" id="btn_submit" style="width: 123px; height:40px; margin-top:-8px;" />Add</button>
   </form> 
   </div>

  </div>

  
<div class="container" style="overflow-x:auto; overflow-y: auto;">
  <table class="table table-bordered" id="resultTable" data-responsive="table">

  <thead>
    <tr>
      <th> Medicine Name </th>
      <th> Category</th>
      <th style="background: red;"> Expire_date</th>
      <th> Price </th>
      <th> Qty </th>
      <th> Amount </th>
      <th> Action </th>
    </tr>
  </thead>

         <tbody>
          <?php
      $invoice_number= $_GET['invoice_number'];
      $medicine_name = "";
      $category= "";
      $quantity= "";

          include("dbcon.php");

          $select_sql = "SELECT * from on_hold where invoice_number = '$invoice_number' ";

          $select_query = mysqli_query($con ,$select_sql);

             $i = 0;
              
            while($row = mysqli_fetch_array($select_query)):

              $i++;
          ?>

          <tr class="record">
               <td><?php


                 $med_id = $row['id'];
                 $medicine_name=$row['medicine_name'];
                 echo $medicine_name;
                 echo "<input type='hidden' value=$med_id id='med_id$i' name='med_id'>";
                 echo "<input type='hidden' value=$medicine_name id='med_name$i' name='med_name'>"
                ?></td>
               <td><?php $category = $row['category'];
               echo $category;
                ?>
                   <input type="hidden" value='<?php echo $category?>' id='med_cat<?php echo $i?>' name='med_cat'>
                  
                </td>
                <td>
                  <?php 
                  $ex_date=$row['expire_date'];
                  echo $ex_date;
                   ?>
                   <input type="hidden" id="ex_date<?php echo $i?>" value='<?php echo $ex_date?>'' name='ex_date'>

                </td>
               <td><?php echo  $row['cost']; ?></td>
               <td>
               <?php

                  $quantity =  $row['qty'];
                  $type     =  $row['type'];
                  echo "<input type='hidden' id='hid_quantity$i' value='$quantity' name='hid_quantity'>";
                  echo "<input type='number' id='quantity$i' name='quantity' value='$quantity' min='1' max='10' style='width:50px'>"."&nbsp;(".$type.")&nbsp;&nbsp;&nbsp;&nbsp;";
                  echo "<a href='#' class='qty_upd$i'><span class='icon-refresh'></span></a>";
                  echo "<div class='ajax-loader$i' style='visibility:hidden'>

                       <img src='src/img/loading.gif'>

                       </div>
                     ";
                               ?>
               </td>
               
               <td><?php echo $row['amount']; ?></td>
     <td><a href="delete_invoice.php?invoice_number=<?php echo $_GET['invoice_number']?>&id=<?php echo $row['id'];?>&name=<?php echo $row['medicine_name']?>&expire_date=<?php echo $row['expire_date']?>&quantity=<?php echo $row['qty'];?>" class="btn btn-warning">Cancel</a></td>

            <?php endwhile; ?>  
          </tr>
          <tr>
        <th colspan="5" ><font size=6><strong> Total:</strong></font></th>
        <td  colspan="2"><strong>

          <?php

          $select_sql = "SELECT sum(amount) , sum(profit_amount) from on_hold where invoice_number = '$invoice_number'";

          $select_query= mysqli_query($con,$select_sql);

          while($row = mysqli_fetch_array($select_query)){

            $grand_total = $row['sum(amount)'];
            $grand_profit =$row['sum(profit_amount)'];
            echo $grand_total;
          }
          ?>
        </td>
      </tr>
  </tbody>
</table><br>

    <?php
     if($medicine_name && $category && $quantity !=null){
      ?>

      <a id="popup"  href="checkout.php?invoice_number=<?php echo $_GET['invoice_number']?>&medicine_name=<?php echo $medicine_name?>&category=<?php echo $category?>&ex_date=<?php echo $ex_date?>&quantity=<?php echo $quantity?>&total=<?php echo $grand_total?>&profit=<?php echo $grand_profit?>" style="width:400px;" class="btn btn-primary btn-large">Submit</a>

    <?php
     }else{


      ?>

      <h1>No Sale Available</h1>

    <?php
 
          }

    ?>
    </div>
 
  </body>
 </html>
<script type="text/javascript">


  $(document).ready(function(){

     $("#product").focus(

            function(){

              var bar_code = $("#bar_code").val();

            $.ajax({
              type:'POST',
              url :'bar_code.php',
              dataType:"json",
              data:{bar_code:bar_code},
              success:function(data){

                $("#product").val(data);
              },

            });
    });

      //****AUTO COMPLETE*****
    $("#product").typeahead({

               source: function(drug_result, result){

            $.ajax({

          url : 'autocomplete.php',
          method :'POST',
          data :{drug_result:drug_result},
          dataType:"json",

          success:function(data){

            result($.map(data,function(item){



              return item;

            }));
          },

        });
      },

    });

      //****AUTO COMPLETE*****



     //****Medicine name and Date*****
     $("#product").focusout(function(){
         
               var value = $("#product").val();

               var res= value.split(",");

               var name = res[0];

               var date = res[1];

            $("#product_hidden").val(name);
          $("#date_hidden").val(date);

    });
    //****Medicine name and Date*****

    //*******Qty Update*******
  for(var i=1;i<=100;i++){

  $("a.qty_upd"+i).click(function(){

        for(var i1=1;i1<=100;i1++){

                var med_id=$("#med_id"+i1).val();
                var med_name=$("#med_name"+i1).val();
                var med_cat=$("#med_cat"+i1).val();
                var ex_date=$("#ex_date"+i1).val();
                var hid_qty = $("#hid_quantity"+i1).val();
                var qty=$("#quantity"+i1).val();

                if(qty <= 0){

                  alert("Sorry Error");

                }else{

             $.ajax({
              type:'POST',
               beforeSend:function(){
                 $('.ajax-loader'+i1).css("visibility", "visible");
              },
              url :'quantity_upd.php',
              data:{med_id:med_id,med_name:med_name,med_cat:med_cat,ex_date:ex_date,hid_qty:hid_qty,qty:qty},

              success:function(){

                location.reload();

              },

            });

           }

         }
  });

}
     //*******Qty Update*******

  });
</script>
 