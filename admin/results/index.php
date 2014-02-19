<?php
	session_start();
	require_once '../../includes/forceadmin.php';
	require_once '../../includes/header.php';
?>

<head>
	<link href="results.css" rel='stylesheet' type="text/css">
</head>

<?php include('../../includes/messages.php'); ?>

<div id="results">
<?php
	$sql = "SELECT * FROM votes ORDER BY tally DESC";
	$result = $con->query($sql);

	$i = 1;
	while($row = $result->fetch_assoc()) {

		print("<div class='vid'>");
			print("<div class='thumb'><img src='".$row['bigthumb']."' /></div>");
			print("<div class='text'>");
				print("<div class='cdiv'><strong><a class='title' vid='".$row['vid']."' href='http://youtube.com/watch?v=".$row['vid'].
					"''>");
				print($row['name']."</strong></a><br>");
				print("".$row['artist']."</div>");

				print("<div class='rdiv'>");
					print("<strong>#$i</strong><br>");
					print("".$row['tally']." votes<br>");
				if ($row['tainted'])
					print("<img title='This tally was edited by hand.' src='/img/fugue/skull.png'/>");
				print("</div>");

				print("<div class='bot'>");
					print(number_format($row['views'])." views &#183; ");
					print("Added to database on ".stringDate($row['dAdded'])." &#183; ");
					print("Last voted for on ".stringDate($row['dLastvoted'])." &#183; ");
					//print("<a href='/admin/edit/?vid=".$row['vid']."'>Options for this video</a>");
					print("<div class='opt'>Options for this video");
					print("<div class='popup'> <a href='delete.php?vid=".$row['vid']."' class='delete'>Delete</a> ");
					print("&#183 <a tally=\"".$row['tally']."\" vid='".$row['vid']."' href='edittally.php' class='edittally'>Edit Tally</a> ");
					print("&#183 <a vidname=\"".htmlspecialchars(stripslashes($row['name']))."\" vid='".$row['vid']."' href='rename.php' class='rename'>Rename</a> </div></div>");
				print("</div>");
			print("</div>");
		print("</div>");

		$i += 1;

	}
?>
</div>

<head>
	<script type="text/javascript">
	    $('.delete').on('click', function () {
	        return confirm('Are you sure? Dont mess it all up...');
	    });

	    $('.rename').on('click', function () {

	    	var ret, def, vid;
	    	def = $(this).attr('vidname'); //default
	    	vid = $(this).attr('vid'); //vid
	    	ret = prompt("Choose a new name for this video:", def);

	    	if (ret == null || ret == def)
	    		return false;

	    	var result, self;
	    	self = this;
	    	result = $.ajax({
	    		type: 		"POST",
	    		url: 		'rename.php',
	    		data:   	"newname="+ret+"&vid="+vid,
	    		success: 	function(r) {
	    			switch(r) {
	    				case -2: alert("Name must be at least 3 characters long."); break;
	    				case -1: alert("Database error."); break;
	    				default:
	    					$("a[class='title'][vid='"+vid+"']").html(ret);
	    					$(self).attr('vidname', ret);
	    					break;
	    		}}
	    	});

	        return false;
	    });

	    $('.edittally').on('click', function () {

	    	var ret, def, vid;
	    	def = $(this).attr('tally'); //default
	    	vid = $(this).attr('vid'); //vid
	    	ret = prompt("Set tally count at:", def);

	    	ret = parseInt(ret);

	    	if (isNaN(ret) || ret == null || ret == def) {
	    		alert("That's not a valid number.");
	    		return false;
	    	}

	    	if (ret < 0) {
	    		alert("Negative tally votes doesn't make sense.");
	    		return false;
	    	}

	    	var result, self;
	    	self = this;
	    	result = $.ajax({
	    		type: 		"POST",
	    		url: 		'edittally.php',
	    		data:   	"new="+ret+"&vid="+vid,
	    		success: 	function(r) {
	    			switch(r) {
	    				case -1: alert("Database error."); break;
	    				default:
	    					location.reload();
	    					break;
	    		}}
	    	});

	        return false;
	    });

	    
	</script>
</head>

<?php require_once '../../includes/footer.php'; ?>