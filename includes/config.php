<?
	require_once 'connect.php';

	class Config {
		private $fetcher = array();

		function __construct () {
			global $con;
			$result = $con->query("SELECT * FROM `config` WHERE `chk` = 1");

			if (!$result)
				abort("Config table not found.");
			if ($result->num_rows != 1)
				abort("Duplicate config table found.");

			$this->fetcher = $result->fetch_assoc();
		}

		function rawdescription() 	{return $this->fetcher['description'];}
		function description() 		{return nl2br($this->fetcher['description']);}
		function minVotes() 		{return $this->fetcher['minVotes']; }
		function maxVotes() 		{return $this->fetcher['maxVotes']; }
		function forceMin() 		{return $this->fetcher['forceMin']; }
		function password() 		{return $this->fetcher['password']; }
	}

	$config = new Config();
?>