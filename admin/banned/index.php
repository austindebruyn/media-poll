<?php
	session_start();
	require_once '../../includes/header.php'; 
?>

<head>
	<script type='text/javascript'>
	$(function() {
		$( ".button" ).button();
		$( ".pageerror" ).delay(1500).fadeOut(2000);

		var availableTags = [
			//"ActionScript",
			//"AppleScript",
			<?php
				$list = getVideoNames();
				$i = 0;
				foreach ($list as $t) {
					print '"'.$t[0].'"';
					if (!(++$i === count($list)))
						print ', ';
				}
			?>
		];

		$( ".autocomplete" ).autocomplete({
			source: availableTags
		});
	});
	</script>
	<style type='text/css'>
		.thumb {
			width: 110px;
			margin: 2px;
		}
	</style>
</head>

<?php include('../../includes/messages.php'); ?>

<div id="content">
	<a href="/admin/">&larr; Back</a>
	<h1>Ban a Video</h1>
	<form action="banvideo.php" method="post">
		You can ban a video by URL or name here.<br>
		<input class='autocomplete' type="text" name="video">&nbsp;&nbsp;
		<button class="button" type="submit">Ban this video</button>
	</form>
	<br><br>
	<h1>Banned Videos</h1>
	<?php
		$sql = "SELECT * FROM `votes` WHERE `banned` = b'1'";
		$result = $con->query($sql);
		for ($i=0; $i<$result->num_rows; $i+=1) {
			$fetcher = $result->fetch_assoc();;
			print("<a href='unban.php?vid=".$fetcher['vid']."''>");
			print("<img class='thumb' ");
			print(" src='".$fetcher['smallthumb']."'");
			print("/></a>");
		}
	?>
</div>

<?php require_once '../../includes/footer.php'; ?>