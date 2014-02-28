<?php
	session_start();
	require_once '../includes/connect.php';
	require_once '../includes/config.php';
	require_once '../includes/forceopen.php';

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
	<script type='text/javascript'>
		$(function() {


			$( ".button" ).button();
	});
	</script>
</head>

<?php include('../includes/messages.php'); ?>

<div id="content">
	<h1>Confirm your ballot</h1>

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

	<div id="confirm-ballot">
	<?php
		for ($i=0; $i<$totalvotes; $i+=1) {
			print("<div class='item'>".$_SESSION['ballotData'][$i]['title']);
			print(" - ".$_SESSION['ballotData'][$i]['artist']."</div>");
		}
	?>
	</div>

	<a href="/finalvote.php"><button class="button" type="button">YES these are correct</button></a><br>
	<a href="/"><button class="button" type="button">GO BACK and edit my ballot</button></a><br>
</div>

<?php require_once '../includes/footer.php'; ?>