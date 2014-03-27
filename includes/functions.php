<?
	/* abort
	 * Gracefully quit the script
	 */
	function abort($error) {
		$print = "<html><head><title>Aborted</title></head>";
		$print = $print."<body><h1>Page aborted</h1>";
		$print = $print."<p>Something went wrong when creating this page.<br> The script ".
						"returned the following error:</p>";
		$print = $print."<p style='text-size: 0.8em; font-family: Courier;'>";
		$print = $print.$error;
		$print = $print."</p></body></html>";
		die($print);
	}

	/* hasVoted
	 * Check if you have voted, based on session, cookies, and IP
	 */
	function hasVoted() {
		global $con;

		if (isset($_SESSION['voteCompleted']))
			return true;

		$myip = $_SERVER['REMOTE_ADDR'];
		$sql = "SELECT `ip` FROM `iptable` WHERE `ip` = '$myip'";

		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$sql = $sql." OR `ip` = '".$_SERVER['HTTP_X_FORWARDED_FOR']."'";

		$result = $con->query($sql);

		if (!$result)
			abort("Database error. (Did you break it?)");

		if ($result->num_rows > 0) {
			$_SESSION['voteCompleted'] = 'true';
			return true;
		}
		return false;
	}

	/* logVote
	 * Mark this user's IP as having voted
	 */
	function logVote() {
		global $con;
		$myip = 	$_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO `iptable` (`ip`) VALUES ('".$myip."')";
		$con->query($sql);
	}

	/* validURL
	 *	Checks if a URL is safe for database input
	 *	@param href a url to sanitize
	 */
	function validURL($href) {
		$filter = "/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/";
		return preg_match($filter, $href);
	}

	/* stringDate
	 * converts date into readable string format
	 * @param date a MySQL-style date
	 */
	function stringDate($date) {
		$dt = DateTime::createFromFormat('Y-m-d', $date);
		return $dt->format('F j, Y');
	}


	/* getVideoNames
	 * returns an array of all video titles
	 * in the database
	 */
	function getVideoNames() {
		global $con;

		$sql = "SELECT `name`, `vid` FROM `votes` WHERE `banned` = b'0' AND `tally` > 0 LIMIT 70";
		$result = $con->query($sql);
		$list = array();
		while ($fetcher = $result->fetch_row())
			array_push($list, array(str_replace('"', "'", $fetcher[0]), $fetcher[1]));
		return $list;
	}

?>