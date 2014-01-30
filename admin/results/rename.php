<?php
	session_start();
	require_once '../../includes/connect.php';
	require_once '../../includes/forceadmin.php';

	$newname = $_POST['newname'];
	$newname = $con->escape_string($newname);

	if (strlen($newname) < 3) {
		echo -2;
		exit();
	}

	$v = $_POST['vid'];
	$sql = "UPDATE `votes` SET `name`='$newname' WHERE `vid`='$v'";
	$result = $con->query($sql);

	if (!$result) {
		echo -1;
		exit();
	}

	echo $newname;
?>