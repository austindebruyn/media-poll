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

		// Hover states on the static widgets
		$( "#dialog-link, li.ui-state-default" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);

		var minVotes, maxVotes;
		minVotes = <?php echo $config->minVotes() ?>;
		maxVotes = <?php echo $config->maxVotes() ?>;

		$( "#more" ).click( function() {
			$("button.hidden").first().fadeIn(200).removeClass("hidden");
			$(".hidden").first().fadeIn(200).removeClass("hidden");

			if ($("#ballot .slot").not(".hidden").length >= maxVotes )
				$("#more").fadeOut(200).addClass("hidden");
		});

		$( "#less" ).click( function() {
			$("button.hidden").first().fadeIn(200).removeClass("hidden");
			if ($("#ballot .slot").not(".hidden").length > minVotes )
			$("#ballot .slot").not(".hidden").last().fadeOut(200).addClass("hidden");

			if ($("#ballot .slot").not(".hidden").length <= minVotes )
				$("#less").fadeOut(200).addClass("hidden");
		});

		$( ".button" ).button();

		$( ".hidden" ).css("display", "none");

		$( ".pageerror" ).fadeOut(2000);

	});

	function preload(arrayOfImages) {
	    $(arrayOfImages).each(function() {
	        (new Image()).src = this;
    })};

	preload(['/img/submit_h.png']);

	</script>
</head>

<?php include('includes/messages.php'); ?>

<div id="content">
	<div id="description">
		<?php print $config->description(); ?>

	</div>

	<form action="vote.php" method="post" id="ballot">
		<?php
			for ($i=0; $i<$config->maxVotes(); $i+=1) { ?>
				<div 	class=<?php echo '"slot ';
									if ($i >= $config->minVotes())
										echo 'hidden';
									echo '"';
								?> >
				<input class='autocomplete' title='Paste a YouTube URL or video name.' 
				<? if (isset($_SESSION['text'.($i+1)]))
					print("value='".$_SESSION['text'.($i+1)]."'" );
				print("name='url".($i+1)."'></div>");
			}
		?>
	</form>

	<br>
	<div class="slot submits">
		<button class="button hidden" type="button" id="less">-</button>
		<button class="button" type="button" id="more">+</button>
		<button class="button" type="submit" form="ballot">Confirm Ballot</button>
	</div>

</div>

<?php require_once 'includes/footer.php'; ?>