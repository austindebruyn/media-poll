<?php
	session_start();
	require_once '../../includes/connect.php';
	require_once '../../includes/forceadmin.php';

	$v = $_POST['vid'];
	$new = $_POST['new'];

	$sql = "UPDATE `votes` SET `tally`=$new, `tainted`=TRUE WHERE `vid`='$v'";

	$result = $con->query($sql);

	if (!$result)
		$_SESSION['pageerror'] = "Something went wrong when I tried to update that.";

	if (!$result) {
		echo -1;
		exit();
	}

	echo 1;
?>