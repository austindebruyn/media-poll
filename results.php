<?php require_once 'header.php'; ?>

<head>
	<style type="text/css">

		#results {
			width: 800px;
			margin: 0 auto;
			padding: 5px;
			min-height: 400px;
			background-color: #c6dcf4;
			border-radius: 5px;
		}

		#results a {
			text-decoration: none;
			color: black;
		}

		#results a:hover {
			color: red;
		}

		#results .vid {
			width:  790px;
			height: 44px;
			background-color: white;
			border-radius: 5px;
			padding: 3px;
			margin: 2px;
			display: inline-block;

			font-size: 11px;
			transition: height 0.2s;
		}

		#results .vid:hover {
			height: 80px;
		}

		#results .vid .thumb {
			width: 142px;
			height: 100%;
			display: inline-block;
			overflow: hidden;
		}

		#results .vid .thumb img {
			width: 100%;
		}

		#results .vid .cdiv {
			width: 400px;
			height: 74px;
			display: inline-block;
			font-size: 1.4em;
			margin: 3px 3px 0 3px;
			font-family: 'Roboto Condensed', Tahoma;

			text-overflow: ellipsis;
			white-space: nowrap;
			vertical-align: top;
		}

		#results .vid .rdiv {
			width: 236px;
			height: 74px;
			display: inline-block;
			font-size: 1.4em;
			margin: 3px 3px 0 3px;
			font-family: 'Roboto Condensed', Tahoma;
			text-align: right;

			text-overflow: ellipsis;
			white-space: nowrap;
			vertical-align: top;
		}

	</style>
</head>

<div id="results">
<?php
	$sql = "SELECT * FROM votes ORDER BY tally DESC";
	$result = $con->query($sql);

	$i = 1;
	while($row = $result->fetch_assoc()) {

		print("<div class='vid'>");
			print("<div class='thumb'><img src='".$row['bigthumb']."' /></div>");
			print("<div class='cdiv'><strong><a href='http://youtube.com/watch?v=".$row['vid'].
				"''>".$row['name']."</strong></a><br>");
			print("".$row['artist']."</div>");

			print("<div class='rdiv'>");
				print("<strong>#$i</strong><br>");
				print("".$row['tally']." votes<br>");
			print("</div>");
		print("</div>");

		$i += 1;
	}
?>
</div>

<?php require_once 'footer.php'; ?>