<?php
	session_start();
	require_once '../../includes/forceadmin.php';
	require_once '../../includes/header.php';
?>

<head>
	<style type="text/css">

		#results {
			width: 800px;
			margin: 0 auto;
			padding: 5px;
			min-height: 400px;
			background-color: #c6dcf4;
			border-radius: 5px;
		}

		#results a {
			text-decoration: none;
			color: black;
		}

		#results a:hover {
			color: red;
		}

		#results .vid {
			width:  790px;
			height: 44px;
			background-color: white;
			border-radius: 5px;
			padding: 3px;
			margin: 2px;

			font-size: 11px;
			transition: height 0.2s;
			overflow: hidden;
		}

		#results .vid:hover {
			height: 80px;
		}

		#results .vid .thumb {
			width: 142px;
			height: 100%;
			display: inline-block;
		}

		#results .vid .thumb img {
			width: 100%;
		}

		#results .vid .text {
			width: 648px;
			height: 80px;
			display: inline-block;
			overflow: hidden;
		}

		#results .vid .text .cdiv {
			position: relative;
			width: 400px;
			height: 40px;
			display: inline-block;
			font-size: 1.4em;
			margin: 3px 3px 0 3px;
			font-family: 'Roboto Condensed', Tahoma;

			text-overflow: ellipsis;
			white-space: nowrap;
			vertical-align: top;
		}

		#results .vid .text .rdiv {
			position: relative;
			width: 236px;
			height: 40px;
			display: inline-block;
			font-size: 1.4em;
			margin: 3px 3px 0 3px;
			font-family: 'Roboto Condensed', Tahoma;
			text-align: right;

			text-overflow: ellipsis;
			white-space: nowrap;
			vertical-align: top;
		}

		#results .vid .text .bot {
			color: #999999;
			position: relative;
			bottom: 2px;
			width: 648px;
			height: 40px;
			margin: 20px 3px 0 3px;
			font-size: 1.0em;
			font-family: 'Roboto Condensed', Tahoma;

			vertical-align: bottom;
		}

		#results .vid .text .bot .opt {
			cursor: pointer;
			color: inherit;
			display: inline-block;
			position: relative;
		}

		#results .vid .text .bot .opt:hover {
			color: red;
		}

		#results .vid .text .bot .opt .popup {
			width: 220px;
			height: 17px;

			background-color: #eee;
			border: 1px #ddd solid;
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;

			font-size: 1.2em;
			text-align: center;
			color: #454545;

			position: absolute;
			top: -21px;
			left: 50%;
			margin-left: -110px;
			padding-bottom: 4px;

			opacity: 0;
			visibility: hidden;
			cursor: auto;

			transition: opacity 0.2s;
			-moz-transition: opacity 0.2s;
			-webkit-transition: opacity 0.2s;
		}

		#results .vid .text .bot .opt:hover .popup {
			visibility: visible;
			opacity: 1;
		}
		#results .vid .text .bot .opt .popup:hover {
			visibility: visible;
			opacity: 1;
		}

	</style>
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
					"''>".$row['name']."</strong></a><br>");
				print("".$row['artist']."</div>");

				print("<div class='rdiv'>");
					print("<strong>#$i</strong><br>");
					print("".$row['tally']." votes<br>");
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