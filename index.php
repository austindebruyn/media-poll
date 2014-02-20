<?php
	session_start();
	require_once 'includes/functions.php';
	require_once 'includes/config.php';

	if (hasVoted()) {
		header("Location: /thanks");
		exit();
	}

	require_once 'includes/header.php'; 
?>

<head>
	<script type='text/javascript'>
		$(function() {
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
</head>

<?php include('includes/messages.php'); ?>

<div id="content">
	<div id="description">
		<?php print $config->description(); ?>

	</div>

	<form action="vote.php" method="post">
		<?php
			for ($i=0; $i<5; $i+=1) {
				print("<input class='autocomplete' title='type &quot;a&quot;'");
				if (isset($_SESSION['text'.($i+1)]))
					print("value='".$_SESSION['text'.($i+1)]."'" );
				print("name='url".($i+1)."'><br>");

			}
		?>
		<input type="submit" value="">

	</form>
</div>

<?php require_once 'includes/footer.php'; ?>