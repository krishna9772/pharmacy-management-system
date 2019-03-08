<?php
   
session_start();

if(!isset($_SESSION['user_session'])){  //User_session

  header("location:index.php");
 
}else{  


  backup_tables('localhost','root','','pharmacy');


}
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	$link = mysqli_connect($host,$user,$pass,$name);
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysqli_query($link,'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query($link,'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		@$return.= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";

		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	//save file
	if(!file_exists("C:\db_backup")){

		mkdir("C:\db_backup");
	}
	    $date = date("dMY");
	    @$invoice_number = $_GET['invoice_number'];


        if(!file_exists('C:\db_backup\db-backup-'.$date.'-'.implode(',',$tables).'.sql')){
		$handle = fopen('C:\db_backup\db-backup-'.$date.'-'.implode(',',$tables).'.sql','w+');
		fwrite($handle,$return);
	    fclose($handle);


	    echo "
	  
	   <input type='hidden' value=$invoice_number id='invoice_number'>

       <script type='text/javascript' src='js/jquery.js'></script>
	     <script type='text/javascript'>
  
              if(window.confirm('Backup Successfully')){

             	var invoice_number=$('#invoice_number').val();

           	window.location.href='home.php?invoice_number='+invoice_number;

           }

	
            </script>";
            
         }else{

         	echo "

         		   <input type='hidden' value=$invoice_number id='invoice_number'>

            <script type='text/javascript' src='js/jquery.js'></script>
              
              <script type='text/javascript'>
  
              if(window.confirm('Already Backup')){

             	var invoice_number=$('#invoice_number').val();


           	window.location.href='home.php?invoice_number='+invoice_number;

           }

            </script>";
         }

}

?>	

<!-- <?php

 // include("dbcon.php");

 // $select_query = "SELECT * FROM stock order by id desc";

 // $result = mysqlii_query($con,$select_query);

 // echo "<table border='1'>";
 // echo "<th>Id</th>";
 // echo "<th>Medicine</th>";
 // echo "<th>Category</th>";
 // echo "<th>Registered Quantity</th>";
 // echo "<th>Used Quantity</th>";
 // echo "<th>Remain Quantity</th>";
 // echo "<th>Registered Date</th>";
 // echo "<th>Expired Date</th>";
 // echo "<th>Remark</th>";
 // echo "<th>Type</th>";

 //  		echo "<tr>";

 // while($row = mysqlii_fetch_array($result)){

 // 	for($i=0;$i<10;$i++){

 // 		echo "<td>".$row[$i]."</td>";

 // 	}
 // 	 echo "</tr>";

 // }
 // $date = date('d-m-y');

 // header("Content-Type: application/xls");
 // header("Content-Disposition: attachment; filename=backup\stock($date).xls");
 //  echo "</table>";
?> -->