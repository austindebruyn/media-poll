<?php

	require_once 'connect.php';

	$url = $_POST['url'];

	$start = strpos($url, "v=")+2;

	if ($start==FALSE)
		abort("Malformed video url");

	$vid = substr($url, $start);

	$url = "http://gdata.youtube.com/feeds/api/videos/".$vid."?v=2&alt=json";
	$ch = curl_init($url); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

	$output = curl_exec($ch); 
	curl_close($ch);  

	json_decode($output);

	$result = json_decode($output, true); //adding true, objects is converted to array 
	$viewCount = $result['entry']['yt$statistics']['viewCount']; //view count
	$dislikes = $result['entry']['yt$rating']['numDislikes']; //dislikes
	$likes = $result['entry']['yt$rating']['numLikes']; //likes
	$title = $result['entry']['title']['$t']; //name

	$sql = "SELECT * from votes WHERE vid='".$vid."'";
	$result = $con->query($sql);
	if ($result->num_rows < 1) {
		$sql = "INSERT INTO votes (vid, name, tally) VALUES ('".$vid."', '".$title."', 1)";
		$con->query($sql);
	}
	else
	{
		$cnt = $result->fetch_assoc()['tally']+1;
		$sql = "UPDATE votes SET tally = $cnt WHERE vid='".$vid."'";
		$con->query($sql);
	}

?>
<!DOCTYPE HTML>
<html>
	<head>

	</head>

	<body>

		<h1>thanks for voting</h1>

		<p>
			you voted for <strong><?php echo $title; ?></strong><br>
			it has <?php echo $likes." likes, ".$dislikes." dislikes, and ".$viewCount." views."; ?>
		</p>

		<p>
			<a href="/">Return to results</a>
		</p>
	</body>
</html>