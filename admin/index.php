<?php
	session_start();
	require_once '../includes/functions.php';
	require_once '../includes/forceadmin.php';
	require_once '../includes/config.php';
	require_once '../includes/header.php'; 
?>

<head>
	<style type='text/css'>
		#logged-out {
			display: none;
		}
	</style>
</head>

<?php include('../includes/messages.php'); ?>

<div id="content">
	<div id="logged-in">
		<h1>Administration</h1>

		<a href="results">View Results</a><br>
		<a href="settings">Settings</a><br>
		<a href="banned">Banned Videos</a><br>
		<a id="logout" href="logout">Logout</a><br>

	</div>
	<div id="logged-out">
		<h1>Logged out</h1>
		You have deauthorized your admin.<br>
		Return to <a href="/">the main page</a>.
	</div>
</div>

<head>
	<script type='text/javascript'>

 	$('#logout').click(function(e) { 
		$.post("logout.php", {val: 4});
 		$('#logged-in').fadeOut(400, function() {
 			$('#logged-out').fadeIn(400);
 		});
		return false;
 	});

	$( ".pageerror" ).fadeOut(2000);

	</script>
</head>

<?php require_once '../includes/footer.php'; ?>