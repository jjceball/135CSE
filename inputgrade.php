<?php

	session_start();
	
	include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
    $classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "grad");
	verifyEnroll($username, $classname);
	
	
    	$quizname = mysql_real_escape_string($_POST['quizname']);
    	$username = mysql_real_escape_string($_POST['stud']);
    	
    	function clean($string) {
			$string = str_replace(" ", "", $string); // Replaces all spaces.
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
			return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
		}
		
	foreach ($_POST as $key => $value) {
		$totscore[] = $value;
	}
		
	//get scores
	for($i = 0; $i < count($totscore) - 2; ++$i) {
		$score += $totscore[$i];
	}
		
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$cID = "SELECT cID FROM Classes WHERE classname='$classname'";
	$result = mysql_query($cID);
	if(!$result) {
		print "failed, sorry 3";
		exit(0);
	}
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$cID = $row['cID'];
	
	$pID = "SELECT pID FROM People WHERE username='$username'";
	$result = mysql_query($pID);
	if(!$result) {
		print "failed, sorry 4";
		exit(0);
	}
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$pID = $row['pID'];
	
	$insertTaken = "INSERT INTO Scores (pID, cID, QuizName, Score) VALUES ($pID, $cID, '$quizname', $score)";
	$result = mysql_query($insertTaken);
	if(!$result) {
		print "failed, sorry 4";
		exit(0);
	}
    
   	header("Location: http://s3.level3.pint.com/gradelist.php?quizname=$quizname");


?>