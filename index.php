<?php
	session_start();
	require_once 'includes/header.php'; 
?>

<head>
	<script language="javascript">

	</script>
</head>

<?php include('includes/messages.php'); ?>

<div id="content">
	<form action="vote.php" method="post">
		<?php
			for ($i=0; $i<5; $i+=1) {
				print("<input type='text' ");
				if (isset($_SESSION['text'.($i+1)]))
					print("value='".$_SESSION['text'.($i+1)]."'" );
				print("name='url".($i+1)."'><br>");

			}
		?>

		<input type="submit" value="Submit Vote">
	</form>
</div>

<?php require_once 'includes/footer.php'; ?>