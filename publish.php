<?php
	session_start();
	include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
	$classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "prof");
	verifyEnroll($username, $classname);
	
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$updatePub = "UPDATE Quiz SET published=1 WHERE QuizName='$quizname'";
	$result = mysql_query($updatePub);
	
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}
	
	header('Location: http://s3.level3.pint.com/portal.php');
?>