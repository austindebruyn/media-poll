<?php
	require_once 'functions.php';

	//Connect to the database


$host = "localhost";
$user = "root";
$pass = "";

	$con = new mysqli($host, $user, $pass, 'mediapoll');
	if (mysqli_connect_errno())
		abort("MySQL Error: " . mysqli_connect_error());

?>