<?php
	$date=$_GET["card_id"];
	$l='';
	$d='';
	$con = new mysqli("localhost","root","juju","library");
	$sql1 = "select loan_id,due_date from book_loans where due_date<'$date' and date_in is null";
	$result1 = $con->query($sql1);
	if ($result1->num_rows > 0) 
	{
		while($row1 = $result1->fetch_assoc())
		{
			$l=$row1['loan_id'];
			$d=$row1['due_date'];
			$sql = "select loan_id from fines where loan_id=$l and paid=0";
			$result = $con->query($sql);
			if($result->num_rows > 0)
			{	
				$sql2="update fines set fine_amt=((SELECT DATEDIFF('$date','$d') AS days)*0.25) where loan_id=$l";
				$con->query($sql2); 
			}
			else
			{
				$sql3="insert into fines values($l,(SELECT DATEDIFF('$date','$d') AS days)*0.25,FALSE)";
				$con->query($sql3); 
			}
		}
	}
	echo "Update Successfull.";
	echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	$con->close();
?>