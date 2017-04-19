<?php
	$con = new mysqli("localhost","root","juju","library");
	$l=$_GET["loan_id"];
	$x = intval($l);
	$sql = "update fines set paid=true where loan_id=$x";
	if ($con->query($sql) === TRUE) 
		echo "Fine Payment Successfull";
	echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	$con->close();
?>