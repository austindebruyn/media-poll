<?php
	session_start();
	require_once '../../includes/connect.php';
	require_once '../../includes/config.php';
	require_once '../../includes/functions.php';
	require_once '../../includes/forceadmin.php';

	$video = $_POST['video'];
	$vid = '';

	//More error checking
	if (strlen($video) < 1) {
		$_SESSION['pageerror'] = "You didn't enter a video.";
		header("Location: /admin/banned");
		exit();
	}

	//Convert any titles to VIDs
	$list = getVideoNames();

	function titleToVID($name) {
		global $list;
		foreach ($list as $video)
			if ($video[0] == $name)
				return $video[1];
		return false;
	}

	//Determine if any of the YouTube links are valid
	//Strip from url format 1: http://youtube.com/watch?v=xxx
	if (preg_match("/^(?:http[s]?:\/\/)?(?:www\.)?youtube.com\/watch\?(?=.*v=[a-zA-Z0-9_-]{11})(?:\S+)?$/",
						$video, $matches))
	$vid = substr($video, strpos($video, "v=")+2, 11);

	//Strip from url format 1: http://youtube.com/watch?v=xxx
	else if (preg_match("/^(?:http[s]?:\/\/)?(?:www\.)?youtu.be\/([a-zA-Z0-9_-]{11})(?:\S+)?$/",
						$video, $matches))
		$vid = substr($video, strpos($video, ".be")+4, 11);

	else {
		//Maybe they entered an exact title?
		$ttv = titleToVID($video);
		if ($ttv)
			$vid = $ttv;
	}

	if (strlen($vid) != 11) {
		$_SESSION['pageerror'] = "Invalid URL: ".$video;
		header("Location: /admin/banned");
		exit();
	}

	//Already banned?
	$sql = "SELECT * FROM `votes` WHERE `banned` = b'1' AND `vid`='$vid'";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		$_SESSION['pageerror'] = "This video is already banned.";
		header("Location: /admin/banned");
		exit();
	}

	//Otherwise, fetch some data and ban it

	//But first, check if it's already been voted for?
	$sql = "SELECT * FROM `votes` WHERE `vid` = '$vid'";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		$sql = "UPDATE `votes` SET `banned` = b'1' WHERE `vid`='$vid'";
		$result = $con->query($sql);
		if (!$result) $_SESSION['pageerror'] = "Something went wrong.";
		header("Location: /admin/banned");
		exit();
	}

	//Fetch some data via cURL
	$url = "http://gdata.youtube.com/feeds/api/videos/".$vid."?v=2&alt=json";
	$ch = curl_init($url); 

	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

	$output = curl_exec($ch);
	curl_close($ch);  

	$result = json_decode($output, true); //adding true, objects is converted to array 

	if (!$result) {
		//This was an invalid YouTube vid
		$_SESSION['pageerror'] = "YouTube reported and error on video ".$vid;
		header("Location: /");
		exit();
		break;
	}

	$viewCount 		= $result['entry']['yt$statistics']['viewCount']; 				//view count
	$dislikes 		= $result['entry']['yt$rating']['numDislikes']; 				//dislikes
	$likes 			= $result['entry']['yt$rating']['numLikes']; 					//likes
	$title 			= $result['entry']['title']['$t']; 								//name
	$smallthumb 	= $result['entry']['media$group']['media$thumbnail'][0]['url']; //thumbnail
	$bigthumb 		= $result['entry']['media$group']['media$thumbnail'][1]['url']; //thumbnail
	$artist			= $result['entry']['author'][0]['name']['$t'];					//artist
	$artisturl		= $result['entry']['author'][0]['yt$userId']['$t'];				//artisturl

	$sql = 	"INSERT INTO votes 	(`vid`, `name`, `tally`, `views`, `smallthumb`, `bigthumb`,
								 `artist`, `artisturl`, `dAdded`, `dLastvoted`, `banned`) ".
			"VALUES 	('$vid', '$title', 0, $viewCount, '$smallthumb', '$bigthumb',
						'$artist', '$artisturl', CURDATE(), NULL, b'1')";

	die($sql);

	$result = $con->query($sql);

	if (!$result) {
		//This was an invalid YouTube vid
		$_SESSION['pageerror'] = "Database error.";
		header("Location: /admin/banned");
		exit();
	}

	header("Location: /admin/banned");