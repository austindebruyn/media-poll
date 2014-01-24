<?php
	if ($_SESSION['auth'] != TRUE) {
		header("Location: login.php");
		exit();
	}
?>