<?php
	session_start();
	include "verify.inc";
	
	$quizname = mysql_real_escape_string($_GET['name']);
	$classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "prof");
	verifyEnroll($username, $classname);
	
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

	$deleteTaken = "DELETE FROM Taken WHERE QuizName='$quizname'";
	$result = mysql_query($deleteTaken);
	
	if(!$result) {
		//print "failed, sorry 2";
		exit(0);
	}	
	
	$deleteScores = "DELETE FROM Scores WHERE QuizName='$quizname'";
	$result = mysql_query($deleteScores);
	
	if(!$result) {
		//print "failed, sorry 3";
		exit(0);
	}
	
	$deleteRegrade = "DELETE FROM Regrade WHERE QuizName='$quizname'";
	$result = mysql_query($deleteRegrade);
	
	if(!$result) {
		//print "failed, sorry 4";
		exit(0);
	}
	
	$deleteQuiz = "DELETE FROM Quiz WHERE QuizName='$quizname'";
	$result = mysql_query($deleteQuiz);
	
	if(!$result) {
		//print "failed, sorry 5";
		exit(0);
	}
	
	$filename = clean($classname).clean($quizname);
	unlink( "../quizs/$filename.json" );


	header('Location: http://s3.level3.pint.com/portal.php');
?>