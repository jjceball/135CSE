<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'> 
	<title>Grading</title>
	<!-- CSS files -->
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/bootstrap.css" >
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-modal.css">
	<link rel="stylesheet" href="css/portals.css" />	
	<link rel="stylesheet" href="shadowbox-3.0.3/shadowbox.css"/>	


</head>
<body>


	<!-- Navigation bar on the top -->
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">     
          <a class="brand" href="homepage.php" tabindex=3><img src="img/logo1.png" alt="sdf"></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
            </p>
          </div> <!--/.nav-collapse -->
        </div>
      </div>
    </div>
<br>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Sidebar content-->
      <h3>Grading is tough, Take a break anytime!</h3>
    </div>
    <div class="span9">
      <!--Body content-->
    <?php
    	include 'verify.inc';
	
    $classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "grad");
	verifyEnroll($username, $classname);
    
    
    	$quizname = mysql_real_escape_string($_GET['quizname']);
    	
    	//connect to database
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		define('DB_NAME','userDB');
		$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
		@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
		
		$classid = "SELECT cID FROM Classes WHERE classname='$classname'";
		$result = mysql_query($classid);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$classid = $row['cID'];
		
		$pid = "SELECT pID FROM People WHERE username='$username'";
		$result = mysql_query($pid);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$pid = $row['pID'];		

		$query = "SELECT username, NameF, NameL FROM People p NATURAL JOIN Taken WHERE QuizName='$quizname' AND cID=$classid AND NOT EXISTS (SELECT * FROM Scores WHERE pID=p.pID AND cID=$classid AND QuizName='$quizname')";
		$result = mysql_query($query);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
		
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$studname = $row['NameF']." ".$row['NameL'];
			$user = $row['username'];
echo <<< STUDQUIZ
	  <div class="btn-toolbar">
		  <div class="btn-group">
			  <a class="btn" >Student: $studname</a>
			  <a class="btn" href="grade.php?quizname=$quizname&stud=$user" title="Grade"><i class="icon-file"></i></a>
		  </div>
	  </div>
STUDQUIZ;
		}
	?>
    </div>
  </div>
</div>


</body>