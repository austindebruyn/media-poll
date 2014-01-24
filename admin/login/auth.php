<?php
	session_start();

	$a = $_POST['pass'];

	if ($a === "boob") {
		//You're in!
		$_SESSION['auth'] = TRUE;
		header("Location: /admin/results");
		exit();
	} 

	$_SESSION['pageerror'] = "Wrong password.";
	header("Location: /admin/login");
	exit();
?>