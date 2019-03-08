<?php

   session_start();

   include("../dbcon.php");

  if(!isset($_SESSION['user_session'])){
    
      header("location:../index.php");

  }

  //****SELECTINg FROM stock******

$id = $_GET['id'];

$invoice_number = $_GET['invoice_number'];

$select_sql = "SELECT * FROM stock where id = '$id' ";
  
$select_query = mysqli_query($con,$select_sql);

  while($row = mysqli_fetch_array($select_query)):



?>
<body>  
    <form method="POST" action="update.php?invoice_number=<?php echo $invoice_number?>">
          <table id="table" style="width: 400px; margin: auto;">
         <td><input type="hidden" name="id" value="<?php echo $row['id']?>"></td>

         <tr id="row">
         <td>Medicine Name:</td>
         <td><input type="text" name="med_name"  id="med_name" size="10" value="<?php echo $row['medicine_name']?>" required ></td>
        </tr>

        <tr>
                   <td>Category:</td>

          <td><input type="text" name="category" id="category" size="10" value="<?php echo $row['category']?>"  required></td>
        </tr>
         <tr>
                   <td>Quantity:</td>

        <td><input type="number" style="width: 95px;" name="quantity" value="<?php echo $row['quantity']?>">

             <select style="width: 95px; height: 28px; border-color: #000080" name="sell_type" > 
                 <option value="<?php echo $row['sell_type']?>" disabled><?php echo $row['sell_type']?></option>
                 <option value="Bot">Bot</option>
                 <option value="Stp">Stp</option>
                  <option value="Tab">Tab</option>
		 <option value="Sachet">Sachet</option>	
		<option value="Unit">Unit</option>
		<option value="Tube">Tube</option>
                 </select></td>
        
        </tr> 
        <tr>
                   <td>Used Quantity:</td>

          <td><input type="number" name="used_quantity" readonly id="used_quantity"  value="<?php echo $row['used_quantity']?>" ></td>
        </tr>

        <tr>

        <td>Remain Quantity:</td>

        <td><input type="number" name="remain_quantity" readonly id="remain_quantity" value="<?php echo $row['remain_quantity']?>" ></td>

        </tr>

        <tr>
                   <td>Registered Date:</td>

          <td><input type="date"  name="reg_date" id="reg_date" size="5" value="<?php echo $row['register_date']?>"  required>  </td>
        </tr>
        <tr>
                   <td>Expired Date:</td>

          <td><input type="date" name="exp_date" id="exp_date" size="5" value="<?php echo $row['expire_date']?>"  required></td>
        </tr>
        <tr>
                   <td>Remark:</td>

          <td><input type="text" name="company" id="company" size="10" value="<?php echo $row['company']?>"></td>
        </tr>
    
          <tr>
                     <td>Actual Price:</td>

          <td><input type="number" name="actual_price" id="actual_price" value="<?php echo $row['actual_price']?>" ></td>
        </tr>
        <tr>
                   <td>Selling Price:</td>

          <td><input type="number" name="selling_price" id="selling_price"   value="<?php echo $row['selling_price']?>" ></td>
        </tr>
        <tr>
                   <td>Profit:</td>

          <td><input type="text" name="profit_price" id="profit_price" value="<?php echo $row['profit_price']?>"  readonly></td>
        </tr>

        <tr>
            <td>Status:</td>
            <td>
                <select style="width: 230px; height: 35px; border-color: #000080" name="status"> 
                 <option  disabled><?php echo $row['status']?></option>
                 <option value="Available">Available</option>
                 <option value="Not Available">Unavailable</option>
                 </select></td>
        </tr>
      <?php endwhile; ?>
        <tr>
          <td></td>
          <td> <input type="submit" name="update" class="btn btn-primary btn-large" style="width: 225px" value="Save"> </td>
        </tr>

         </table> 
        <br>
         </form><br>
</body>

<script type="text/javascript">
    $(document).ready(function(){//***AUTO CALCULATION****

        $(document).on('keyup','#med_name', 

        function(){
             var med_name_cap = $("#med_name").val();
              
              $("#med_name").val(med_name_cap.charAt(0).toUpperCase()+med_name_cap.slice(1));
      
        });


      $(document).on('keyup','#category', 

        function(){
             var category_cap = $("#category").val();
              
              $("#category").val(category_cap.charAt(0).toUpperCase()+category_cap.slice(1));
      
        });


      $(document).on('keyup','#actual_price', 

        function(){
             var act_price = $("#actual_price").val();
      var sell_price = $("#selling_price").val();
      var pro_price = parseInt(sell_price) - parseInt(act_price);
	var percentage = Math.round((parseInt(pro_price)/parseInt(act_price))*100);
	var output = pro_price.toString().concat("(")+percentage.toString().concat("%)");
        $("#profit_price").val(output);
        });

       $(document).on('keyup','#selling_price', 
        function(){
      var act_price = $("#actual_price").val();
      var sell_price = $("#selling_price").val();
      var pro_price = parseInt(sell_price) - parseInt(act_price);
	var percentage = Math.round((parseInt(pro_price)/parseInt(act_price))*100);
	var output = pro_price.toString().concat("(")+percentage.toString().concat("%)");
        $("#profit_price").val(output);
            });
});
    
  </script>
</html>

