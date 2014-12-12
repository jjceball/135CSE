<?php
	session_start();
	session_unset();
	session_regenerate_id();
	//testing comment
	// includes
	include('passhash.inc');

	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());

	//username and password sent from form
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	
	$userQuery = "SELECT username, password, Position FROM People WHERE username='$username'";
	$result = mysql_query($userQuery);
	if(!$result) {
		//print "Uh oh, query failed";
		exit(0);
	}
	
	//fetch result
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	// if now user exists then alert the user
	if(!$row) {
		print "No User by that name";
		exit(0);
	}
	
	//there is a user now check password
	if(validate_password($password, $row['password'])) {
		//password matches redirect to portal
		$_SESSION['userid'] = $username;
		$_SESSION['pos'] = $row['Position'];
		header('Location: http://s3.level3.pint.com/portal.php');
	}
	else {
		//password fails
		print "password Doesn't match!";
		exit(0);
	}
?>
