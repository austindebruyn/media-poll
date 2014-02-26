<?php
	session_start();
	require_once 'includes/connect.php';
	require_once 'includes/config.php';
	require_once 'includes/forceopen.php';

	//Make sure you aren't trying to double vote
	if (hasVoted()) {
		header("Location: /thanks");
		exit();
	}


	$url = array();
	array_pad($url, $config->maxVotes(), "");

	for ($i=1; $i<=$config->maxVotes(); $i+=1)
		$_SESSION['text'.$i] = $_POST['url'.$i];


	$i = 0;

	for ($j=1; $j<$config->maxVotes(); $j+=1)	
		if (isset($_POST['url'.$j]) && strlen($_POST['url'.$j]) > 0) {$url[$i] = $_POST['url'.$j]; $i += 1;}

	$totalvotes = $i;

	//Force 5-vote rule
	if ($config->forceMin() && $totalvotes < $config->minVotes()) {
		$_SESSION['pageerror'] = "You need to vote for at least ".$config->minVotes()." videos.";
		header("Location: /");
		exit();
	}

	//More error checking
	if ($totalvotes < 1) {
		$_SESSION['pageerror'] = "You have to at least vote for something.";
		header("Location: /");
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
	for ($i=0; $i<$totalvotes; $i+=1) {
		$vid[$i] = "";

		//Strip from url format 1: http://youtube.com/watch?v=xxx
		if (preg_match("/^(?:http[s]?:\/\/)?(?:www\.)?youtube.com\/watch\?(?=.*v=[a-zA-Z0-9_-]{11})(?:\S+)?$/",
							$url[$i], $matches))
			$vid[$i] = substr($url[$i], strpos($url[$i], "v=")+2, 11);

		//Strip from url format 1: http://youtube.com/watch?v=xxx
		else if (preg_match("/^(?:http[s]?:\/\/)?(?:www\.)?youtu.be\/([a-zA-Z0-9_-]{11})(?:\S+)?$/",
							$url[$i], $matches))
			$vid[$i] = substr($url[$i], strpos($url[$i], ".be")+4, 11);

		else {
			//Maybe they entered an exact title?
			$ttv = titleToVID($url[$i]);
			if ($ttv)
				$vid[$i] = $ttv;
		}
	}

	//Make sure all were valid links
	for ($i=0; $i<$totalvotes; $i+=1)
		if (strlen($vid[$i]) != 11) {
		$_SESSION['pageerror'] = "Invalid URL: ".$url[$i];
		header("Location: /");
		exit();
	}

	//Fetch some data via cURL
	for ($i=0; $i<$totalvotes; $i+=1) {

		$url = "http://gdata.youtube.com/feeds/api/videos/".$vid[$i]."?v=2&alt=json";
		$ch = curl_init($url); 

		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

		$output = curl_exec($ch);
		curl_close($ch);  

		$result = json_decode($output, true); //adding true, objects is converted to array 

		if (!$result) {
			//This was an invalid YouTube vid
			$_SESSION['pageerror'] = "Invalid youtube vid: ".$vid[$i];
			header("Location: /");
			exit();
			break;
		}

		$viewCount[$i] 		= $result['entry']['yt$statistics']['viewCount']; 				//view count
		$dislikes[$i] 		= $result['entry']['yt$rating']['numDislikes']; 				//dislikes
		$likes[$i] 			= $result['entry']['yt$rating']['numLikes']; 					//likes
		$title[$i] 			= $result['entry']['title']['$t']; 								//name
		$smallthumb[$i] 	= $result['entry']['media$group']['media$thumbnail'][0]['url']; //thumbnail
		$bigthumb[$i] 		= $result['entry']['media$group']['media$thumbnail'][1]['url']; //thumbnail
		$artist[$i]			= $result['entry']['author'][0]['name']['$t'];					//artist
		$artisturl[$i]		= $result['entry']['author'][0]['yt$userId']['$t'];				//artisturl
	}

	//Assemble a meta array to pass back to confirm.php
	$_SESSION['safetycheck'] = "SAFE";
	$_SESSION['totalvotes'] = $totalvotes;
	for ($i=0; $i<$totalvotes; $i+=1) {

		$_SESSION['ballotData'][$i] = array(
				'vid' 			=> $vid[$i],
				'viewCount' 	=> $viewCount[$i],
				'dislikes' 		=> $dislikes[$i],
				'likes' 		=> $likes[$i],
				'title' 		=> $title[$i],
				'smallthumb' 	=> $smallthumb[$i],
				'bigthumb' 		=> $bigthumb[$i],
				'artist' 		=> $artist[$i],
				'artisturl' 	=> $artisturl[$i]
			);
	}

	header("Location: /confirm");
	exit(0);
?>