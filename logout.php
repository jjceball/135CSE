<?php
	session_start();
	
	session_destroy();
	
	header('Location: http://s3.level3.pint.com/homepage.php');
?>