<?php
	session_start();
	require_once 'connect.php';

	$url = array("", "", "", "", "");

	for ($i=1; $i<=5; $i+=1)
		$_SESSION['text'.$i] = $_POST['url'.$i];


	$i = 0;

	if (isset($_POST['url1']) && strlen($_POST['url1']) > 0) {$url[$i] = $_POST['url1']; $i += 1;}
	if (isset($_POST['url2']) && strlen($_POST['url2']) > 0) {$url[$i] = $_POST['url2']; $i += 1;}
	if (isset($_POST['url3']) && strlen($_POST['url3']) > 0) {$url[$i] = $_POST['url3']; $i += 1;}
	if (isset($_POST['url4']) && strlen($_POST['url4']) > 0) {$url[$i] = $_POST['url4']; $i += 1;}
	if (isset($_POST['url5']) && strlen($_POST['url5']) > 0) {$url[$i] = $_POST['url5']; $i += 1;}

	$totalvotes = $i;

	//Force 5-vote rule
	/*
	if ($totalvotes < 5) {
		$_SESSION['pageerror'] = "You need to vote for 5 videos.";
		header("Location: /");
		exit();
	}
	*/

	if ($totalvotes < 1) {
		$_SESSION['pageerror'] = "You have to at least vote for something.";
		header("Location: /");
		exit();
	}

	//Determine if any of the YouTube links are valid
	for ($i=0; $i<$totalvotes; $i+=1) {
		$vid[$i] = "";

		//Strip from url format 1: http://youtube.com/watch?v=xxx
		if (preg_match("/^(?:http:\/\/)?(?:www\.)?youtube.com\/watch\?(?=.*v=[a-zA-Z0-9_-]{11})(?:\S+)?$/",
							$url[$i], $matches))
			$vid[$i] = substr($url[$i], strpos($url[$i], "v=")+2, 11);

		//Strip from url format 1: http://youtube.com/watch?v=xxx
		else if (preg_match("/^(?:http:\/\/)?(?:www\.)?youtu.be\/([a-zA-Z0-9_-]{11})(?:\S+)?$/",
							$url[$i], $matches))
			$vid[$i] = substr($url[$i], strpos($url[$i], ".be")+4, 11);
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

	header("Location: confirm.php");
	exit(0);
?>