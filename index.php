<?php
	require_once 'connect.php';
?>

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
	</head>
	<body>
		<h1>index.php</h1>
		<h2>form</h2>
		<form action="vote.php" method="post">
			<input type="text" name="url" value="put link here">
			<input type="submit" value="vote">
		</form>

		<h2>results</h2>
		<ol>
		<?php
			$sql = "SELECT * from votes ORDER BY tally DESC";
			$result = $con->query($sql);

			while($row = $result->fetch_assoc())
    			echo "<li>".$row['name']." ".$row['tally']." votes<br>";
		?>
		</ol>
	</body>
</html>