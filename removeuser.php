<?php
	session_start();
    include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
    $class = mysql_real_escape_string($_SESSION['class']);
	$user = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($user, $pos, "prof");
	verifyEnroll($user, $class);
	
	
	
	
	$pID = mysql_real_escape_string($_GET['pid']);
	
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$cID = "SELECT cID FROM Classes WHERE classname='$class'";
	$result = mysql_query($cID);
	
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}
		
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if(!$row) {
		print "no class by that name, $class";
		exit(0);
	}
	$cID = $row['cID'];

	
	$userQuery = "DELETE FROM Enrollment WHERE pID='$pID' AND cID='$cID'";
	$result = mysql_query($userQuery);
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}
	
	header("Location: http://s3.level3.pint.com/classadmin.php?class=$class");

?>