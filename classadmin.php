<?php
	session_start();
    include 'verify.inc';
	
	$quizname = mysql_real_escape_string($_GET['quiz']);
    $class = mysql_real_escape_string($_GET['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "prof");
	verifyEnroll($username, $class);


	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'> 
	<title>Class Manager</title>
	<!-- CSS files -->
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" >
	<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-modal.css">
	<link rel="stylesheet" href="css/portals.css" />	
	<link rel="stylesheet" href="shadowbox-3.0.3/shadowbox.css"/>	
	
	<script src="bootstrap/js/bootstrap-modal.js"></script>
	<script src="bootstrap/js/bootstrap-modalmanager.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>
<body>

	<!-- Navigation bar on the top -->
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">     
          <a class="brand" href="homepage.php" tabindex=3><img src="img/logo1.png"></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
				<a href="logout.php" class="navbar-link">&nbsp;Log Out</a>
            </p>
          </div> <!--/.nav-collapse -->
        </div>
      </div>
    </div>
<h1>Class Manager</h1>
<br>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Sidebar content-->
<?php
	  print "<h3>$class</h3>";
?>
	<form action="adduser.php" method="GET">
		Username:<input type='text' name='username'>
		<input type='hidden' name='class' value='<?php print $class; ?>'>
		<input type='submit' value='Add User'>
	</form>
	<br>
    </div>
    <div class="span9">
      <!--Body content-->

        <h3>Students</h3>
<?php
		$classid = "SELECT NameF, NameL, pID FROM  (SELECT * FROM Enrollment WHERE cID IN (SELECT cID FROM Classes WHERE classname='$class')) b NATURAL JOIN (SELECT * FROM People WHERE Position='stud') c";
		$result = mysql_query($classid);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$namef = $row['NameF'];
			$namel = $row['NameL'];
			$pid = $row['pID'];
echo <<< STUDDIV
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn" href="">$namef $namel</a>
                <a class="btn" href="removeuser.php?pid=$pid" title="Delete"><i class="icon-trash"></i></a>
            </div>
        </div>
STUDDIV;
		}
?>
        <h3>Graders</h3>
<?php
		$classid = "SELECT NameF, NameL, pID FROM  (SELECT * FROM Enrollment WHERE cID IN (SELECT cID FROM Classes WHERE classname='$class')) b NATURAL JOIN (SELECT * FROM People WHERE Position='grad') c";
		$result = mysql_query($classid);
		if(!$result) {
			print "failed, sorry";
			exit(0);
		}
	
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$namef = $row['NameF'];
			$namel = $row['NameL'];
			$pid = $row['pID'];
echo <<< GRADDIV
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn" href="">$namef $namel</a>
                <a class="btn" href="removeuser.php?pid=$pid" title="Delete"><i class="icon-trash"></i></a>
            </div>
        </div>
GRADDIV;
		}
?>
    </div>
  </div>
</div>
</body>