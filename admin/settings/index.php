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
				$.post("updatedesc.php", {desc: update});
		}}

		$(document).keydown(function(event) {
		    if ($("#desc").is(":focus")) {
		    	if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) return true;
		    	savedesc();
		    	event.preventDefault();
		    	return false;
		}});

	</script>
</head>

<?php require_once '../../includes/footer.php'; ?>