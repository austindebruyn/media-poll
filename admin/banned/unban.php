<?php
	session_start();
	require_once '../../includes/connect.php';
	require_once '../../includes/config.php';
	require_once '../../includes/functions.php';
	require_once '../../includes/forceadmin.php';

	$vid = $_GET['vid'];
	
	$sql = "UPDATE `votes` SET `banned`=b'0' WHERE `vid` = '$vid'";
	$result = $con->query($sql);

	if (!$result)
		$_SESSION['pageerror'] = "Database error.";
	 
	header("Location: /admin/banned");
	exit();
