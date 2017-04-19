<?php
	$card_id=$_GET["card_id"];
	$con = new mysqli("localhost","root","juju","library");
	$sql = "select * from book_loans natural join borrower where date_in is null and (isbn like '%$card_id%' or card_id=CAST('$card_id' AS UNSIGNED))";
	$sql1 = "select * from book_loans natural join borrower where date_in is null and bname like '%$card_id%'";
	$result = $con->query($sql);
	$result1 = $con->query($sql1);
	if ($result->num_rows > 0 || $result1->num_rows > 0) 
	{
		$sql = "select bw.card_id,b.isbn,b.title from book as b NATURAL JOIN book_loans as bw where date_in is null and isbn in (select isbn from book_loans natural join borrower where isbn like '%$card_id%' or bname like '%$card_id%' or card_id=CAST('$card_id' AS UNSIGNED)) group by isbn";
		$result = $con->query($sql);
		if ($result->num_rows > 0) 
		{
			echo "<table border='2' style='width:100%'><tr><th>Card ID</th><th>ISBN</th><th>Title</th><th>Check IN</th></tr>";
			while($row = $result->fetch_assoc()) 
			{
				echo "<tr>";
				echo "<td>" . $row['card_id'] . "</td>";
				echo "<td>" . $row['isbn'] . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td><button type='button' onclick=bookreturn('$row[isbn].$row[card_id]');>Return</td>";
				echo "</tr>";
			}	
			echo "</table>";
		}
	}
	else 
	{
		echo " Sorry! You have not borrowed any books!!! ";
		echo "<br><br><button type='button' onclick=fun();>Go Back to main page";	
	}
	$con->close();
?>