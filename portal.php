<?php
	session_start();
	
	include 'verify.inc';
	
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, $pos);

	//connect to database
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','userDB');
	$dbc = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die('Could not connect to MySQL: '.mysql_error());
	@mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());
	
	$pos = $_SESSION['pos'];
	$username = $_SESSION['userid'];
	$class = $_SESSION['class'];
	if($_POST['class']) {
		$_SESSION['class'] = $_POST['class'];
		$class = $_SESSION['class'];
	}
	
	
	function clean($string) {
		$string = str_replace(" ", "", $string); // Replaces all spaces.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<?php
		if($pos == 'prof') {
			print "<title>Professor Homepage</title>";
		}
		else if($pos == 'grad') {
			print "<title>Grader Homepage</title>";
		}
		else if($pos == 'stud') {
			print "<title>Student Homepage</title>";
		}
	?>
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
				<a href="logout.php" class="navbar-link">&nbsp;Log Out</a>
            </p>
          </div> <!--/.nav-collapse -->
        </div>
      </div>
    </div>

<?php
	if($pos == 'prof') {
		print "<h1>Welcome Professor!</h1>";
	}
	else if($pos == 'grad') {
		print "<h1>Welcome Grader!</h1>";
	}
	else if($pos == 'stud') {
		print "<h1>Welcome Student!</h1>";
	}
?>
<br>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Sidebar content-->
      <h3>My Classes</h3>
      <?php
      		$classQuery = "SELECT classname FROM (SELECT pID FROM People WHERE username='$username') a NATURAL LEFT JOIN Enrollment
      																										NATURAL LEFT JOIN Classes";
	  		$result = mysql_query($classQuery);
	
	  		//fetch result
	  		if(!$result) {
		  		print "Query failed";
		  		exit(0);
		  	}
		  	
		  	while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  		$classname = $row['classname'];
			  	if($pos == 'prof') {
echo <<< PROFCLASS
	  			<form action="portal.php" method="POST">
	  				<input type="hidden" name="class" value="$classname" />
			  		<div class="btn-toolbar">
			  			<div class="btn-group">
			  				<a class="btn" href="#" onclick="this.parentNode.parentNode.parentNode.submit()">$classname</a>
			  				<a class="btn" href="classadmin.php?class=$classname" title="Manage Class"><i class="icon-user"></i></a>
			  				<a class="btn" href="deleteclass.php?class=$classname" title="Delete"><i class="icon-trash"></i></a>
			  			</div>
			  		</div>
			  	</form>
PROFCLASS;
				}
				else if($pos == 'grad') {
echo <<< GRADCLASS
	  			<form action="portal.php" method="POST">
	  				<input type="hidden" name="class" value="$classname" />
			  		<div class="btn-toolbar">
			  			<div class="btn-group">
			  				<a class="btn" href="#" onclick="this.parentNode.parentNode.parentNode.submit()">$classname</a>
			  				<a class="btn" href="drop.php?class=$classname" title="Drop"><i class="icon-trash"></i></a>
			  			</div>
			  		</div>
			  	</form>
GRADCLASS;
				}
				else if($pos == 'stud') {
echo <<< STUDCLASS
	  			<form action="portal.php" method="POST">
	  				<input type="hidden" name="class" value="$classname" />
			  		<div class="btn-toolbar">
			  			<div class="btn-group">
			  				<a class="btn" href="#" onclick="this.parentNode.parentNode.parentNode.submit()">$classname</a>
			  				<a class="btn" href="drop.php?class=$classname" title="Drop"><i class="icon-trash"></i></a>
			  			</div>
			  		</div>
			  	</form>
STUDCLASS;
				}
		  	}
		  	
		  	if( $pos == 'prof' ) {
echo <<< ADDCLASS
				<form action="addclass.php" method="GET">
			  		Class Name:<input type='text' name='classname'>
			  		<input type='submit' value='Add Class'>
			  	</form>
ADDCLASS;
		  	}
		  	
    ?>
    </div>
    <div class="span9">
      <!--Body content-->
      <?php
      		if(!$class) {
	      		print "<h3>Please Select a class on the Left</h3>";
      		}
      		else {
      			if($pos == 'prof') {
	      			$quizQuery = "SELECT QuizName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN Quiz WHERE published=1";
		  			$result = mysql_query($quizQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
echo <<< ADDQUIZ
		  			<div class="btn-toolbar">
		  				<div class="btn-group">
		  					<a class="btn" href="builder.html" title="Add Quiz">Add Quiz</a>
		  				</div>
		  			</div>
ADDQUIZ;
		  			print "<h3>Published Quizzes</h3>";
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
echo <<< PROFPUB
		  				<div class="btn-toolbar">
		  					<div class="btn-group">
		  						<a class="btn" href="#">$quizname</a>
		  						<a class="btn" href="#" title="Edit"><i class="icon-pencil"></i></a>
		  						<a class="btn" href="deletequiz.php?name=$quizname" title="Delete"><i class="icon-trash"></i></a>
		  						<a class="btn" href="#" title="View Statistics"><i class="icon-file"></i></a>
		  					</div>
		  				</div>
PROFPUB;
					}
					
					print "<h3>Unpublished Quizzes</h3>";
					
					$quizQuery = "SELECT QuizName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN Quiz WHERE published=0";
		  			$result = mysql_query($quizQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
echo <<< PROFUNPUB
	  					<div class="btn-toolbar">
	  						<div class="btn-group">
	  							<a class="btn" href="#">$quizname</a>
	  							<a class="btn" href="#" title="Edit"><i class="icon-pencil"></i></a>
		  						<a class="btn" href="deletequiz.php?name=$quizname" title="Delete"><i class="icon-trash"></i></a>
	  							<a class="btn" href="publish.php?quiz=$quizname" title="Publish"><i class="icon-ok"></i></a>
	  						</div>
	  					</div>
PROFUNPUB;
		  			}
		  		}
		  		else if($pos == 'grad') {
	      			$quizQuery = "SELECT QuizName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN Quiz WHERE graded=1";
		  			$result = mysql_query($quizQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
					print "<h3>Quizzes</h3>";
					
					$quizQuery = "SELECT QuizName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN
																							Quiz WHERE published=1 AND graded=0";
		  			$result = mysql_query($quizQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
echo <<< GRADUNFIN
	  					<div class="btn-toolbar">
	  						<div class="btn-group">
	  							<a class="btn" href="#">$quizname</a>
	  							<a class="btn" href="gradelist.php?quizname=$quizname" title="Grade"><i class="icon-pencil"></i></a>
	  						</div>
	  					</div>
GRADUNFIN;
		  			}
		  			
					print "<h3>Regrade Requests</h3>";
					
					$quizQuery = "SELECT NameF, NameL, QuizName, regradeName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN Regrade NATURAL LEFT JOIN People";
		  			$result = mysql_query($quizQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
		  				$name= $row['NameF']." ".$row['NameL'];
		  				$regradefile = $row['regradeName'];
echo <<< GRADREGRAD
	  					<div class="btn-toolbar">
	  						<div class="btn-group">
	  							<a class="btn" href="#">$quizname</a>
	  							<a class="btn" href="#">Student: $name</a>
	  							<a class="btn" href="#" title="Regrade"><i class="icon-edit"></i></a>
	  						</div>
	  					</div>
GRADREGRAD;
		  			}
			  	}
			  	else if($pos == 'stud') {
			  				  	
	      			$actQuery = "SELECT QuizName FROM (SELECT cID FROM Classes WHERE classname='$class') a NATURAL LEFT JOIN Quiz WHERE published=1 AND QuizName NOT IN (SELECT QuizName FROM Taken NATURAL LEFT JOIN People WHERE username='$username')";
		  			$result = mysql_query($actQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
		  			print "<h3>Active Quizzes</h3>";
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
		  				$cleanquiz = clean($row['QuizName']);

echo <<< STUDNOTFIN
	  					<div class="btn-toolbar">
	  						<div class="btn-group">
	  							<a class="btn" href="#">$quizname</a>
	  							<a class="btn" href="taker.php?quizname=$cleanquiz" title="Take Quiz"><i class="icon-play"></i></a>
	  						</div>
	  					</div>
STUDNOTFIN;
					}
					
					print "<h3>Finished Quizzes</h3>";
					
	      			$takenQuery = "SELECT QuizName FROM Taken NATURAL LEFT JOIN People WHERE username='$username' AND cID IN (SELECT cID FROM Classes WHERE classname='$class')";
		  			$result = mysql_query($takenQuery);
	
		  			//fetch result
		  			if(!$result) {
		  				print "Query failed";
		  				exit(0);
		  			}
		  			
		  			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		  				$quizname = $row['QuizName'];
echo <<< STUDTAKEN
	  					<div class="btn-toolbar">
	  						<div class="btn-group">
	  							<a class="btn" href="#">$quizname</a>
	  							<a class="btn" href="#" title="View Report"><i class="icon-file"></i></a>
	  							<a class="btn" href="#" title="Request Regrade"><i class="icon-comment"></i></a>
	  						</div>
	  					</div>
STUDTAKEN;
		  			}
				}
		  	}
	  ?>
    </div>
  </div>
</div>


</body>