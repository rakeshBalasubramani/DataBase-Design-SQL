<?php
	$con = new mysqli("localhost","root","juju","library");
	$card_id=$_GET["card_id"];
	$x = intval($card_id);
	$sql = "select * from book_loans natural join fines where card_id=$x";
	$result = $con->query($sql);
	if ($result->num_rows > 0) 
	{
		echo "<table border='2' style='width:100%'><tr><th>Loan_ID</th><th>ISBN</th><th>Card_ID</th><th>Fine_Amount</th><th>Paid</th><th></th></tr>";
		while($row = $result->fetch_assoc()) 
		{
			$c=$row['card_id'];
			$f=$row['fine_amt'];
			$l=$row['loan_id'];
			$sql2 = "select date_in from book_loans where loan_id=$l";
			$result2 = $con->query($sql2);
			$row2 = $result2->fetch_assoc();
			$i = $row2['date_in'];
			echo "<tr>";
			echo "<td>" . $row['loan_id'] . "</td>";
			echo "<td>" . $row['isbn'] . "</td>";
			echo "<td>" . $row['card_id'] . "</td>";
			echo "<td>" . $row['fine_amt'] . "</td>";
			if($row['paid']==0 && $i!=null)
				echo "<td><button type='button' onclick=pay($c,$f,$l);>Pay</td>";
			else if($i==null)
				echo "<td><button type='button' disabled>Pay</td>";
			else
				echo "<td>Paid</td>";
			echo "</tr>";
		}	
		echo "</table>";
		$sql1="select sum(fine_amt) from fines natural join book_loans where card_id=$x and paid=0 group by card_id";
		$result1 = $con->query($sql1);
		$row = $result1->fetch_assoc();
		$i = $row['sum(fine_amt)'];
		if($i>0)
			echo "Total outstanding balance = $i $.";
		else
			echo "No outstanding balance";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	}	
	else
	{
		echo "No fine amounts to show";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";
	}
	$con->close();
?>