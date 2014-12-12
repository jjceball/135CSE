<?php


	function verifyPos($userid, $pos, $realpos) {
		if($pos != $realpos) {
			print "sorry you are not authorized to do this";
			exit(0);
		}
		
		//connect to database
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		define('DB_NAME','userDB');
		$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
		@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
		$verify = "SELECT * FROM People WHERE username='$userid' AND Position='$pos'";
		$result = mysql_query($verify);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if(!$row) {
			print "sorry you do not have permission to do this";
			exit(0);
		}
	}
	
	function verifyEnroll($userid, $class) {
		//connect to database
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		define('DB_NAME','userDB');
		$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
		@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
		$verify = "SELECT pID FROM People WHERE username='$userid'";
		$result = mysql_query($verify);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$pID = $row['pID'];
		
		
		
		$verify = "SELECT cID FROM Classes WHERE classname='$class'";
		$result = mysql_query($verify);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$cID = $row['cID'];
		
		
		
		$verify = "SELECT * FROM Enrollment WHERE pID=$pID AND cID=$cID";
		$result = mysql_query($verify);
	
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		if(!$row) {
			print "you are not enrolled in the class you are trying to change";
			exit(0);
		}
	}
	
	function stripString($string) {
		mysql_real_escape_string($string);
		htmlentities($string);
		htmlspecialchars($string);
		strip_tags($string);
		addslashes($string);
		return $string;
	}

?>