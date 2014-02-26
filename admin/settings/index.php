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
	<a href="/admin/">&larr; Back</a>

	<p>Ballot description</p>
	<div id='desc-area'>
		<textarea rows='10' id='desc' name='desc'><?php print $config->rawdescription();?></textarea>
		<div onclick="savedesc()" id='desc-update'>Click here to update</div>
	</div>

	<p>Vote Closure</p>

	<div class="option" id="option">
		<input type="checkbox" id="enable" value="enable" <? if ($config->enabled()) echo 'checked'; ?> >
		Enable voting
	</div>

	<p>More Settings</p>
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

	<p>Security</p>
	<form action="update.php?val=pass" method="post">
		<input type="password" name="pass" value="">&nbsp;&nbsp;
		<button class="button" type="submit">Change admin pass</button>
	</form>

	<br>
	<?php if (hasVoted()) { ?>
	<a href="update.php?val=ip"><button class="button" id="another">Log me out and give me another vote</button></a>
	<? } ?>

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

		$("#enable").change( function() {
				var update = ($('#enable').is(':checked') ? 1 : 0);
				$.post("update.php?val=enable", {val: update});
		});

		$( ".button" ).button();

	</script>
</head>

<?php require_once '../../includes/footer.php'; ?>