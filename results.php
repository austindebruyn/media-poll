<?php
	require_once 'connect.php';
?>

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<style type="text/css">

			#results {
				width: 910px;
				margin: 0 auto;
				padding: 5px;
				min-height: 200px;
				background-color: #c6dcf4;
				border-radius: 5px;
			}

			#results .vid {
				width:  200px;
				height: 90px;
				background-color: white;
				border-radius: 5px;
				padding: 3px;
				margin: 2px;
				display: inline-block;
				float: left;
			}

			#results .vid img {
				height: 80%;
			}

			#results .vid:first-child {
				width:	480px;
				height: 190px;
			}


		</style>
	</head>
	<body>
		<div id="results">
		<?php
			$sql = "SELECT * FROM votes ORDER BY tally DESC";
			$result = $con->query($sql);

			$i = 1;
			while($row = $result->fetch_assoc()) {

					print("<div class='vid'>");

					print("<img src='".$row['bigthumb']."' />");

					print($row['name']);


					print("</div>");

    			//echo "<li><img src='".$row['smallthumb']."'/>".$row['name']." ".$row['tally']." votes<br>";

    		}
		?>
		</div>
	</body>
</html>