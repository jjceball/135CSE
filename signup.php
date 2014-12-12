<?php
	session_start();
	session_unset();
	session_regenerate_id();
	
	//If the call for the script is to log them in, DO IT! 
	$username = mysql_real_escape_string($_POST['username']);
	$password1 = mysql_real_escape_string($_POST['password']);
	$password2 = mysql_real_escape_string($_POST['password2']);
	$email = mysql_real_escape_string($_POST['email']);
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$type = mysql_real_escape_string($_POST['acctype']);


	include('passhash.inc');

	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	//query
	$userQuery = "SELECT username FROM People WHERE username ='$username'";
	$result = mysql_query($userQuery);
	if( !$result ) {
		print "Uh Oh, Query failed";
		exit(0);
	}
	
	//fetch result
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	//if there is a result then username exists
	if($row) {
		//username is registered!
		header('Location: http://s3.level3.pint.com/usernametaken.html');
		exit(0);
	}

	//start querying for a new user
	//create new password hash to insert
	//print "$password1, $password2";
	if( $password1 != $password2 ) {
		print "password doesn't match";
		exit(0);
	}
	
	$hashedPass = create_hash($password1);
	$insertNewUser = "INSERT INTO People (NameF, NameL, Position, password, username)
						VALUES('$firstname', '$lastname', '$type', '$hashedPass', '$username')";
	$result = mysql_query($insertNewUser);
	
	
	//set sesssion variables
	if( $type == "stud" ) {
		$query = "SELECT pID FROM People WHERE username='$username'";
		$result = mysql_query($query);
		if( !$result ) {
			print "Uh Oh, Query failed";
			exit(0);
		}
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$pID = $row['pID'];
		
		$query = "INSERT INTO Enrollment (cID, pID) VALUES (16,$pID)";
		$result = mysql_query($query);
		if( !$result ) {
			print "Uh Oh, Query failed";
			exit(0);
		}
		
	}
	
	
	$_SESSION['userid'] = $username;
	$_SESSION['pos'] = $type;
	header('Location: http://s3.level3.pint.com/portal.php');
?>