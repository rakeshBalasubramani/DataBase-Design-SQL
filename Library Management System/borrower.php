<?php
	$con = new mysqli("localhost","root","juju","library");
	$isbn=$_GET["isbn"];
	$parts = explode(' ', $isbn);
	$sql = "SELECT max(loan_id) FROM book_loans";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$id = $row["max(loan_id)"];
	$id = $id+1;
	$x = intval($parts[1]);
	$sql = "SELECT count(*) FROM book_loans WHERE card_id='$x' and date_in is null";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$i = $row["count(*)"];
	if($i>=3)
	{
		echo "Sorry,you have already reached the limit of 3 books!!";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	}
	else
	{
		$sql1 = "INSERT INTO book_loans(loan_id,isbn,card_id,date_out,due_date,date_in) VALUES ('$id','$parts[0]','$x',CURDATE(),DATE_ADD(CURDATE(),INTERVAL 14 DAY),null)";
		if ($con->query($sql1) === TRUE) 
		{
			echo "Book Successfully added to your account.";
			echo "<br><br><button type='button' onclick=fun();>Go Back to main page";	
		}	
		else
		{
			echo "Invalid Card ID or Card ID does not exixt in database!!!";
			echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
		}	
	}
$con->close();
?>