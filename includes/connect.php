<?php
	require_once 'functions.php';

	//Connect to the database
	//$host = "alllevelsatoncecom.domaincommysql.com";
	//$user = "austin";
	//$pass = "j8!cm3)_A";

	$host = "localhost";
	$user = 'root';
	$pass = '';

	$con = new mysqli($host, $user, $pass, 'media-poll');
	if (mysqli_connect_errno())
		abort("MySQL Error: " . mysqli_connect_error());

?>