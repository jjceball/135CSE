<?php
	session_start();
	include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
    $class = mysql_real_escape_string($_GET['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "prof");
	verifyEnroll($username, $class);
	
	function clean($string) {
		$string = str_replace(" ", "", $string); // Replaces all spaces.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    
    
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
		print "failed, sorry 1";
		exit(0);
	}
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if(!$row) {
		print "error";
		exit(0);
	}
	$cID = $row['cID'];

	$deleteEnroll = "DELETE FROM Enrollment WHERE cID=$cID";
	$result = mysql_query($deleteEnroll);
	
	if(!$result) {
		print "failed, sorry 2";
		exit(0);
	}
	
	$deleteScores = "DELETE FROM Scores WHERE cID=$cID";
	$result = mysql_query($deleteScores);
	
	if(!$result) {
		print "failed, sorry 3";
		exit(0);
	}
	
	$deleteQuiz = "DELETE FROM Quiz WHERE cID=$cID";
	$result = mysql_query($deleteQuiz);
	
	if(!$result) {
		print "failed, sorry 4";
		exit(0);
	}
	
	$deleteRegrade = "DELETE FROM Regrade WHERE cID=$cID";
	$result = mysql_query($deleteRegrade);
	
	if(!$result) {
		print "failed, sorry 5";
		exit(0);
	}
	
	$deleteTaken = "DELETE FROM Taken WHERE cID=$cID";
	$result = mysql_query($deleteTaken);
	
	if(!$result) {
		print "failed, sorry 6";
		exit(0);
	}
	
	$deleteClass = "DELETE FROM Classes WHERE cID=$cID";
	$result = mysql_query($deleteClass);
	
	if(!$result) {
		print "failed, sorry 7";
		exit(0);
	}
	

	$_SESSION['class'] = "";

	header('Location: http://s3.level3.pint.com/portal.php');
?>