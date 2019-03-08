<?php

session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">

		function med_name() {//***Search For Medicine *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("name_med");
  filter = input.value.toUpperCase();
  table = document.getElementById("table1");
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

		
	</script>
</head>
<body>

	   <div class="expire" color="green" >
    	  <font size="5">Medicine Going to Expire</font><br><hr>
    	  <input type="text"  id="name_med" size="4"  onkeyup="med_name()" placeholder="Search for Medicine names.." title="Type in a name">
 <div style="overflow-x:auto; overflow-y: auto; height: 200px;">
 
    	   <table class="table table-bordered" id="table1">

    	  	<tr>
    	  		<th>Medicine</th>
    	     	<th>Expire Date</th>
    	     	<th>Avai Qty</th>
    	  		<th>Cost</th>
			<th>Total Cost </th>
    	  	</tr>

    	    <?php
    	   include("dbcon.php");
           $date = date('d-m-Y');    
           $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date))); 
           $select_sql = "SELECT  * FROM stock WHERE expire_date <= '$inc_date' and status='Available' ORDER BY expire_date ASC ";
           $result =  mysqli_query($con,$select_sql); 
           while ($row = mysqli_fetch_array($result)):  
    	  ?> 
    	  <tr>
    	  	<td><?php echo $row['medicine_name']?></td>
    	    <td><font color="red"><?php echo $row['expire_date']?></font></td>
    	  	<td><?php echo $row['remain_quantity']."(".$row['sell_type'].")"?></td>
		      <td><?php echo $row['actual_price']?></td>
    	  	<td><?php echo $row['actual_price']*$row['remain_quantity']?></td>

    	  </tr>
    	<?php endwhile;?>
</table>
</div>
    </div>  

</body>
</html>