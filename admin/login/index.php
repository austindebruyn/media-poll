<?php
	session_start();
	require_once '../../includes/header.php'; 
?>

<head>

</head>

<?php include('../../includes/messages.php'); ?>

<div id="content">
	<form action="auth.php" method="post">
		You need to be an administrator of this site to continue.<br>
		<input type="password" name="pass">
		<br>
		<input type="submit" value="Authorize">
	</form>
</div>

<?php require_once '../../includes/footer.php'; ?>