<?php
if (isset($_SESSION['pageerror'])) {
	print("<div class='pageerror'>".$_SESSION['pageerror']."</div>"); 
	unset($_SESSION['pageerror']);
}
if (isset($_SESSION['pagemessage'])) {
	print("<div class='pagemessage'>".$_SESSION['pagemessage']."</div>"); 
	unset($_SESSION['pagemessage']);
}
?>