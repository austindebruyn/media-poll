<?php
	session_start();
	require_once 'includes/connect.php';

	if ($_SESSION['confirmcheck'] !== "CONFIRMED")
		die("<h1>eror</h1>");

	$totalvotes = $_SESSION['totalvotes'];

	for ($i=0; $i<$totalvotes; $i+=1) {
		$vid 			= $_SESSION['ballotData'][$i]['vid'];
		$title 			= $_SESSION['ballotData'][$i]['title'];
		$smallthumb 	= $_SESSION['ballotData'][$i]['smallthumb'];
		$bigthumb 		= $_SESSION['ballotData'][$i]['bigthumb'];
		$artist 		= $_SESSION['ballotData'][$i]['artist'];
		$artisturl 		= $_SESSION['ballotData'][$i]['artisturl'];

		$sql = "SELECT * from `votes` WHERE `vid`='".$_SESSION['ballotData'][$i]['vid']."'";
		$result = $con->query($sql);
		if ($result->num_rows < 1) {
			$sql = 	"INSERT INTO votes (vid, name, tally, smallthumb, bigthumb, artist, artisturl) ".
					"VALUES ('$vid', '$title', 1, '$smallthumb', '$bigthumb', '$artist', '$artisturl')";
			$con->query($sql);
		}
		else
		{
			//Add 1 to the tally already recorded and update
			$cnt = $result->fetch_assoc()['tally']+1;
			$sql = "UPDATE `votes` SET `tally` = $cnt WHERE `vid`='".$vid."'";
			$con->query($sql);
		}
	}

	header("Location: /thanks");
	exit();
?>