<?php
	session_start();
	require_once 'includes/connect.php';

	//Make sure you aren't trying to double vote
	if (hasVoted()) {
		header("Location: /thanks");
		exit();
	}

	if ($_SESSION['confirmcheck'] !== "CONFIRMED")
		die("<h1>eror</h1>");

	$totalvotes = $_SESSION['totalvotes'];

	for ($i=0; $i<$totalvotes; $i+=1) {
		$vid 			= $_SESSION['ballotData'][$i]['vid'];
		$title 			= $_SESSION['ballotData'][$i]['title'];
		$viewCount 		= $_SESSION['ballotData'][$i]['viewCount'];
		$smallthumb 	= $_SESSION['ballotData'][$i]['smallthumb'];
		$bigthumb 		= $_SESSION['ballotData'][$i]['bigthumb'];
		$artist 		= $_SESSION['ballotData'][$i]['artist'];
		$artisturl 		= $_SESSION['ballotData'][$i]['artisturl'];

		$title = $con->escape_string($title);
		$artist = $con->escape_string($artist);

		$sql = "SELECT * from `votes` WHERE `vid`='".$_SESSION['ballotData'][$i]['vid']."'";
		$result = $con->query($sql);
		if ($result->num_rows < 1) {
			$sql = 	"INSERT INTO votes 	(`vid`, `name`, `tally`, `views`, `smallthumb`, `bigthumb`,
										 `artist`, `artisturl`, `dAdded`, `dLastvoted`) ".
					"VALUES 	('$vid', '$title', 1, $viewCount, '$smallthumb', '$bigthumb',
								'$artist', '$artisturl', CURDATE(), CURDATE())";
			$con->query($sql);
		}
		else
		{
			//Add 1 to the tally already recorded and update
			$fetcher = $result->fetch_assoc();
			$cnt = $fetcher['tally']+1;
			$sql = "UPDATE `votes` SET `tally` = $cnt WHERE `vid`='".$vid."'";
			$con->query($sql);
		}
	}

	//Mark this browser/IP/session as voted
	$_SESSION['voteCompleted'] = TRUE;

	header("Location: /thanks");
	exit();
?>