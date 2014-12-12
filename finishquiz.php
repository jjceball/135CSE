<?php

	session_start();
		include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quizname']);
    $classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "stud");
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
	
	$insertTaken = "INSERT INTO Taken (pID, cID, QuizName) VALUES ($pID, $cID, '$quizname')";
	$result = mysql_query($insertTaken);
	if(!$result) {
		print "failed, sorry 4";
		exit(0);
	}
	
	
	//loop through the answers saving them to an array
	foreach ($_GET as $key => $value) {
		$ans[] = $value;
	}
	
	$jstring = json_encode($ans);
	
	$username = clean($username);
	$classname = clean($classname);
	$quizname = clean($quizname);
	
    $filename = "u$username"."c$classname"."q$quizname";
    $file = fopen("../quizs/$filename.ans",'w+');
    fwrite($file, $jstring);
    fclose($file);
    
   	header("Location: http://s3.level3.pint.com/portal.php");


?>