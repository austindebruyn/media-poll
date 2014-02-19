<?php
	require_once '../../includes/connect.php';

	$d = $_POST['desc'];
	$sql = "UPDATE `config` SET `description`='$d' WHERE `chk`=1";
	$con->query($sql);
?>