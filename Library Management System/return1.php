<?php
	$con = new mysqli("localhost","root","juju","library");
	$isbn=$_GET["isbn"];
	$parts = explode('.', $isbn);
	$x = intval($parts[1]);
	$sql = "update book_loans set date_in='$parts[2]' where isbn='$parts[0]' and card_id=$x";
	if ($con->query($sql) === TRUE) 
		echo "Book Successfully Returned.";
	$date=$parts[2];
	$sql = "select loan_id,due_date from book_loans where isbn='$parts[0]' and card_id=$x";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$l = $row['loan_id'];
	$d = $row['due_date'];
	$sql = "select loan_id from fines where loan_id=$l";
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
	echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	$con->close();
?>