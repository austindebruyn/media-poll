<?php
	require_once 'connect.php';
	require_once 'config.php';

	if ($config->enabled() != TRUE) {
		header("Location: /closed");
		exit();
	}
?>