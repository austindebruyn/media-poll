<?php
	require_once 'connect.php';
?>

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<style type="text/css">

			#results {
				width: 900px;
				margin: 0 auto;
				min-height: 200px;
				background-color: #c6dcf4;
				border-radius: 5px;
			}

			#results .firstplace {

			}


		</style>
	</head>
	<body>
		<h1>results.php</h1>
		<div id="results">
		<ol>
		<?php
			$sql = "SELECT * from votes ORDER BY tally DESC";
			$result = $con->query($sql);

			while($row = $result->fetch_assoc())
    			echo "<li>".$row['name']." ".$row['tally']." votes<br>";
		?>
		</ol>
		</div>
	</body>
</html>