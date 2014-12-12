<?php
	session_start();
    include 'verify.inc';
	
    $class = mysql_real_escape_string($_GET['class']);
	$user = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	if($pos == 'prof') {
		print "you are not authorized to do this";
		exit(0);
	}
	
	verifyPos($user, $pos, $pos);
	verifyEnroll($user, $class);
	
	
	
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	if($_SESSION['pos'] = 'stud') {
		$drop = "DELETE FROM Scores WHERE cID IN (SELECT cID FROM Classes WHERE classname='$class') AND pID IN (SELECT pID FROM People WHERE username='$user')";
		$result = mysql_query($drop);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	}
	
	$drop = "DELETE FROM Enrollment WHERE cID IN (SELECT cID FROM Classes WHERE classname='$class') AND pID IN (SELECT pID FROM People WHERE username='$user')";
	$result = mysql_query($drop);
	
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}	
	
	
	$_SESSION['class'] = '';
	header('Location: http://s3.level3.pint.com/portal.php');

?>