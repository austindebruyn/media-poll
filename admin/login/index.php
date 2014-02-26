<?php
	session_start();
	require_once '../../includes/header.php'; 
?>

<head>
	<script type='text/javascript'>
	$(function() {
		$( ".button" ).button();
		$( ".pageerror" ).fadeOut(2000);
	});
	</script>
</head>

<?php include('../../includes/messages.php'); ?>

<div id="content">
	<h1>Admin Login</h1>
	<form action="auth.php" method="post">
		You need to be an administrator of this site to continue.<br>
		<input type="password" name="pass">&nbsp;&nbsp;
		<button class="button" type="submit">Authenticate</button>
	</form>
</div>

<?php require_once '../../includes/footer.php'; ?>