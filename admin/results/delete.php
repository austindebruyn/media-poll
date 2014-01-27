<?php
	session_start();
	require_once '../../includes/connect.php';
	require_once '../../includes/forceadmin.php';

	$v = $_GET['vid'];

	$sql = "DELETE FROM `votes` WHERE `vid`='$v'";

	$result = $con->query($sql);

	if (!$result)
		$_SESSION['pageerror'] = "Something went wrong when I tried to delete that.";

	header("Location: /admin/results");
?>