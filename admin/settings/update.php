<?php
	require_once '../../includes/connect.php';

	switch ($_GET['val']) {
		case 'desc':
			$d = $_POST['desc'];
			$sql = "UPDATE `config` SET `description`='$d' WHERE `chk`=1";
			$con->query($sql);
			break;
		case 'forcemin':
			$d = $_POST['val'];
			$sql = "UPDATE `config` SET `forceMin`=$d WHERE `chk`=1";
			$con->query($sql);
			break;
		case 'enable':
			$d = $_POST['val'];
			$sql = "UPDATE `config` SET `enabled`=$d WHERE `chk`=1";
			$con->query($sql);
			break;
		case 'minvotes':
			$d = $_POST['val'];
			$sql = "UPDATE `config` SET `minVotes`=$d WHERE `chk`=1";
			$con->query($sql);
			break;
		case 'maxvotes':
			$d = $_POST['val'];
			$sql = "UPDATE `config` SET `maxVotes`=$d WHERE `chk`=1";
			$con->query($sql);
			break;
		case 'pass':
			$d = $_POST['pass'];
			if ($d == '')
				header("Location: /admin/settings");
			$hashpass = md5($d);
			$sql = "UPDATE `config` SET `password`='$hashpass' WHERE `chk`=1";
			$con->query($sql);
			header("Location: /admin/settings");
			break;
		case 'ip':
			session_start(); // fetch/re-start current session
			session_regenerate_id(true); // assign a new session id and delete old data
			$_SESSION=array(); // empty session data
			session_write_close(); // superfluous call ;-)
			$_SESSION['auth'] = TRUE;
			$myip = $_SERVER['REMOTE_ADDR'];
			$sql = "DELETE FROM `iptable` WHERE `ip` = '$myip'";
			$con->query($sql);
			header("Location: /");
			break;
	}
?>