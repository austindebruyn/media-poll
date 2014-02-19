<?php
	session_start();
	require_once 'includes/functions.php';

	if (hasVoted()) {
		header("Location: /thanks");
		exit();
	}

	require_once 'includes/header.php'; 
?>

<head>
	<script language="javascript">

	</script>
</head>

<?php include('includes/messages.php'); ?>

<div id="content">
	<div id="description">
	Hey! Welcome to the voting platform. Vote for up to 10 of your favorite videos below, starting with
	a minimum of 5 votes. Just copy-paste a video URL in the box below!.

	</div>

	<form action="vote.php" method="post">
		<?php
			for ($i=0; $i<5; $i+=1) {
				print("<input type='text' ");
				if (isset($_SESSION['text'.($i+1)]))
					print("value='".$_SESSION['text'.($i+1)]."'" );
				print("name='url".($i+1)."'><br>");

			}
		?>

		<input type="submit" value="">
	</form>
</div>

<?php require_once 'includes/footer.php'; ?>