<?php
	session_start();
	require_once 'header.php'; 
?>

<head>
	<script language="javascript">

	</script>
</head>

<?php include('messages.php'); ?>

<div id="content">
	<form action="vote.php" method="post">
		<input type="text" value=<?php echo "'".$_SESSION['text1']."'"; ?> name="url1">
		<br>
		<input type="text" value=<?php echo "'".$_SESSION['text2']."'"; ?> name="url2">
		<br>
		<input type="text" value=<?php echo "'".$_SESSION['text3']."'"; ?> name="url3">
		<br>
		<input type="text" value=<?php echo "'".$_SESSION['text4']."'"; ?> name="url4">
		<br>
		<input type="text" value=<?php echo "'".$_SESSION['text5']."'"; ?> name="url5">
		<br>
		<input type="submit" value="Submit Vote">
	</form>
</div>

<?php require_once 'footer.php'; ?>