<?php
if (isset($_SESSION['pageerror'])) {
	print("<div class='pageerror'>".$_SESSION['pageerror']."</div>"); 
	unset($_SESSION['pageerror']);
}
?>