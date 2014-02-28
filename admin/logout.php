<?php
	session_start(); // fetch/re-start current session
	session_regenerate_id(true); // assign a new session id and delete old data
	$_SESSION=array(); // empty session data
	session_write_close(); // superfluous call ;-)
?>