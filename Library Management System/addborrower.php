<?php
	$key=$_GET["keyword"];
	$parts = explode('@', $key);
	$con = new mysqli("localhost","root","juju","library");
	$sql = "select max(card_id) from borrower";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$i = $row["max(card_id)"];
	$i=$i+1;
	$sql = "insert into borrower values($i,'$parts[0]','$parts[1]','$parts[2]','$parts[3]')";
	if ($con->query($sql) === TRUE)
	{
		echo "Borrower successfully updated!!!";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	}
	else 
	{
		echo "SSN already exists!!!";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	}

?>