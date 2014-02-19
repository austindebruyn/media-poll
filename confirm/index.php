<?php
	session_start();

	if ($_SESSION['safetycheck'] !== "SAFE")
		die("<h1>eror</h1>");

	$_SESSION['confirmcheck'] = 'CONFIRMED';

	require_once '../includes/header.php'; 
?>

<head>
	<style type="text/css">
		.thumb {
			width: 110px;
			margin: 2px;
		}
	</style>

</head>

<?php include('../includes/messages.php'); ?>

<div id="content">
	<p>Confirm your ballot</p>

	<?php
		$totalvotes = $_SESSION['totalvotes'];
		for ($i=0; $i<$totalvotes; $i+=1) {
			print("<img class='thumb' ");
			print(" src='".$_SESSION['ballotData'][$i]['smallthumb']."'");
			print("/>");
		}
	?>


	<p>
	<strong>YOUR BALLOT</strong> contains <?php echo $totalvotes; ?> videos<br>
	</p>

	<p style="text-decoration: italic;">
	<?php
		for ($i=0; $i<$totalvotes; $i+=1) {
			print($_SESSION['ballotData'][$i]['title']." by ".$_SESSION['ballotData'][$i]['artist']."<br>");
		}
	?>
	</p>

	<a href='/finalvote.php'>YES this ballot is correct</a><br>
	<a href="/">GO BACK and edit my ballot</a>
</div>

<?php require_once '../includes/footer.php'; ?>