<?php
	if ($_SESSION['auth'] != TRUE) {
		header("Location: /admin/login");
		exit();
	}
?>