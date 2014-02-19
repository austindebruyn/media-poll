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

		if (isset($_SESSION['voteCompleted']))
			return true;

		$myip = 	$_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $myipf = 	$_SERVER['HTTP_X_FORWARDED_FOR'];
		$sql = "SELECT `ip` FROM `IPtable` WHERE `ip` = $myip";

		return false;
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

?>