<?php
	session_start();
	include 'verify.inc';
	
    $class = mysql_real_escape_string($_GET['class']);
	$user = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($user, $pos, "prof");
	verifyEnroll($user, $class);
	
	$username = mysql_real_escape_string( $_GET['username'] );
	
	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$userQuery = "SELECT * FROM People WHERE username='$username'";
	$result = mysql_query($userQuery);
	if(!$result) {
		print "failed, sorry";
		exit(0);
	}	
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	// if now user exists then alert the user
	if(!$row) {
		print "No User by that name";
		exit(0);
	}
	else {
		$cID = "SELECT cID FROM Classes WHERE classname='$class'";
		$result = mysql_query($cID);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		$pid = $row['pID'];
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		if(!$row) {
			print "no class by that name, $class";
			exit(0);
		}
		$cid = $row['cID'];
				
		$addUser = "INSERT INTO Enrollment VALUES ($pid, $cid)";
		$result = mysql_query($addUser);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	}
	
	header("Location: http://s3.level3.pint.com/classadmin.php?class=$class");

?>