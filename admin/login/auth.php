<?php
	require_once '../../includes/connect.php';
	require_once '../../includes/config.php';
	session_start();


	$a = $_POST['pass'];

	if (password_verify($a, $config->password())) {
		//You're in!
		$_SESSION['auth'] = TRUE;
		header("Location: /admin/");
		exit();
	} 

	$_SESSION['pageerror'] = "Wrong password.";
	header("Location: /admin/login");
	exit();
?>