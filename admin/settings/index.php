<?php
	session_start();
	require_once '../../includes/forceadmin.php';
	require_once '../../includes/config.php';
	require_once '../../includes/header.php';
?>

<head>
	<link href="settings.css" rel='stylesheet' type="text/css">
</head>

<?php include('../../includes/messages.php'); ?>

<div id="content">
	<p>Main ballot description</p>
	<div id='desc-area'>
		<textarea rows='10' id='desc' name='desc'><?php print $config->rawdescription();?></textarea>
		<div onclick="savedesc()" id='desc-update'>Click here to update</div>
	</div>

	More Settings

	<div class="option" id="minvotes">
		<select id="select-minvotes">
	  		<?php
	  			for ($i=1; $i<10; $i += 1)
	  				if ($config->minVotes() == $i)
	  					print('<option value="'.$i.'" selected="selected">'.$i."</option>");
	  				else
	  					print('<option value="'.$i.'">'.$i."</option>");
	  		?>
		</select>
		Select minimum number of votes
	</div>

	<div class="option" id="maxvotes">
		<select id="select-maxvotes">
	  		<?php
	  			for ($i=$config->minVotes(); $i<15; $i += 1)
	  				if ($config->maxVotes() == $i)
	  					print('<option value="'.$i.'" selected="selected">'.$i."</option>");
	  				else
	  					print('<option value="'.$i.'">'.$i."</option>");
	  		?>
		</select>
		Select maximum number of votes
	</div>

	<div class="option" id="option">
		<input type="checkbox" id="forcemin" value="forcemin" <? if ($config->forceMin()) echo 'checked'; ?> >
		Force minimum vote
	</div>
</div>

<head>
	<script type='text/javascript'>
		$('#desc').bind('keydown', function(event, ui) {
	        $("#desc-update").css('opacity', 1).css('cursor', 'pointer');
		});

		function savedesc() {
			if ($("#desc-update").css('opacity') == 1) {
				
				$("#desc-update").css('opacity', 0).css('cursor', 'default');
				var update = $('textarea#desc').val();
				$.post("update.php?val=desc", {desc: update});
		}}

		$(document).keydown(function(event) {
		    if ($("#desc").is(":focus")) {
		    	if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) return true;
		    	savedesc();
		    	event.preventDefault();
		    	return false;
		}});

		$("#forcemin").change( function() {
				var update = ($('#forcemin').is(':checked') ? 1 : 0);
				$.post("update.php?val=forcemin", {val: update});
		});

		$("#select-minvotes").change( function() {
				var update = $("#select-minvotes").val();
				$.post("update.php?val=minvotes", {val: update});
				location.reload();
		});

		$("#select-maxvotes").change( function() {
				var update = $("#select-maxvotes").val();
				$.post("update.php?val=maxvotes", {val: update});
				location.reload();
		});

	</script>
</head>

<?php require_once '../../includes/footer.php'; ?>