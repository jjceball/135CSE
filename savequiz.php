<?php

	session_start();
	include 'verify.inc';
	
    $classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "prof");
	verifyEnroll($username, $classname);
	
    $classname2 = mysql_real_escape_string($_SESSION['class']);

	$json = $_POST['json'];
	
	$quizname = json_decode($json, true);
	$quizname = $quizname['Quiz'][0]['quizName'];
	
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
	
	$classid = "SELECT cID FROM Classes WHERE classname='$classname2'";
	$result = mysql_query($classid);
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$classid = $row['cID'];
	
	$updatePub = "INSERT INTO Quiz VALUES ($classid, '$quizname', 0, 0, 0 )";
	$result = mysql_query($updatePub);
	
	if(!$result) {
		print "$classid, $quizname";
		exit(0);
	}
	
    $classname = clean($classname);
    $quizname = clean($quizname); 
    
    $filename = $classname.$quizname;
    $file = fopen("../quizs/$filename.json",'w+');
    fwrite($file, $json);
    fclose($file);
?>