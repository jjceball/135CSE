<?php
	session_start();
	include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
    $class = mysql_real_escape_string($_GET['classname']);
	$user = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($user, $pos, "prof");
		
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$userQuery = "SELECT * FROM Classes WHERE classname='$class'";
	$result = mysql_query($userQuery);
	if(!$result) {
		print "failed, sorry 1";
		exit(0);
	}
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if($row) {
		Print "Class name taken";
		exit(0);
	}
	
	$insertQuery = "INSERT INTO Classes (classname) VALUES ('$class')";
	$result = mysql_query($insertQuery);
	if(!$result) {
		print "failed, sorry 2";
		exit(0);
	}
	
	$cID = "SELECT cID FROM Classes WHERE classname='$class'";
	$result = mysql_query($cID);
	if(!$result) {
		print "failed, sorry 3";
		exit(0);
	}
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$cID = $row['cID'];
	
	$pID = "SELECT pID FROM People WHERE username='$user'";
	$result = mysql_query($pID);
	if(!$result) {
		print "failed, sorry 4";
		exit(0);
	}
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$pID = $row['pID'];
	
	$enrollQuery = "INSERT INTO Enrollment (pID, cID) VALUES ($pID, $cID)";
	$result = mysql_query($enrollQuery);
	if(!$result) {
		print "failed, sorry 5 $pID, $cID";
		exit(0);
	}
		
	header("Location: http://s3.level3.pint.com/classadmin.php?class=$class");

?>