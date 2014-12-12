<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'> 
	<title>Quiz</title>
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
      <h3>Good Luck on the Quiz!</h3>
    </div>
    <div class="span9">
      <!--Body content-->
		<form action="finishquiz.php" method="GET">
    <?php
        	include 'verify.inc';
	
    $classname = mysql_real_escape_string($_SESSION['class']);
	$username = mysql_real_escape_string($_SESSION['userid']);
	$pos = mysql_real_escape_string($_SESSION['pos']);
	
	verifyPos($username, $pos, "stud");
	verifyEnroll($username, $classname);
    
    
    	$quizname = mysql_real_escape_string($_GET['quizname']);
    	
    	function clean($string) {
			$string = str_replace(" ", "", $string); // Replaces all spaces.
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
			return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
		}
		$classname = clean($classname);
		
		$filename = $classname.$quizname;
		
    	$fp = file_get_contents("../quizs/$filename.json");
    	
    	$quizContent = json_decode("$fp",true);
          			$quizName = stripString($quizContent["Quiz"][0]["quizName"]);
          			$quizQuestions = $quizContent["Quiz"][1]["questions"];
          			print("<h3>$quizName</h3>");
          			print("<ul style = \"list-style-type:none;\">");
          			for ($i = 0; $i < count($quizQuestions); $i++)
          			{
          				$curQuestion = $quizQuestions[$i];
          				$curType = $curQuestion["questionType"];
          				$curContent = stripString($curQuestion["questionText"][0]["edit"]);
          				$curAnswers = $curQuestion["answers"];
          				$points = stripString($curQuestion["points"]);

          				print("<li class=\"quistionItem\">");
          				switch ($curType) {
          					case 'multChoiceSingle':
          						print("
          							<div class=\"question multChoiceSingle\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">
          						");

          						for ($j=0; $j < count($curAnswers); $j++) { 
          							$answer = stripString($curAnswers[$j]["answer"]);
          							print("<input type=\"radio\" name = \"question$i\" value = \"$answer\">$answer<br/>");
          						}
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					case 'multChoiceMult':
          						print("
          							<div class=\"question multChoiceMult\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">
          						");

          						for ($j=0; $j < count($curAnswers); $j++) { 
          							$answer = stripString($curAnswers[$j]["answer"]);
          							print("<input type=\"checkbox\" name = \"question$i sub$j\" value = \"$answer\">$answer<br/>");
          						}
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					case 'trueFalse':
          						print("
          							<div class=\"question trueFalse\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">		
          						");

          						for ($j=0; $j < count($curAnswers); $j++) { 
          							$answer = stripString($curAnswers[$j]["answer"]);
          							print("<input type=\"radio\" name = \"question$i\" value = \"$answer\">$answer<br/>");
          						}
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					case 'fillIn':
          						print("
          							<div class=\"question fillIn\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">
          						");
          						
          						$answer = stripString($curAnswers[0]["answer"]);
          						$answer = $answer."________________".stripString($curAnswers[1]["answer"]);
          						print("<p>$answer</p>");	
          						print("<input name=\"question$i\" type=\"text\" value = \"\"/>");
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					case 'shortAnswer':
          						print("
          							<div class=\"question multChoiceSingle\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">
          						");

          						
          						$answer = stripString($curAnswers[0]["answer"]);
          						print("<p>$answer.\"_______________________\".</p>");	
          						print("<input name=\"question$i\" type=\"text\" value = \"\"/>");
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					case 'shortEssay':
          						print("
          							<div class=\"question multChoiceSingle\" style=\"display: block;\">
          								<h4 style=\"color:rgb(0,153,102);\">$curContent</h4>
          								<div class=\"widget-content\" style=\"display: block;\">
          						");

          						print("<input name=\"question$i\" cols=\"50\" rows=\"25\" type=\"text\" value = \"\"/>");
          						print("
          								</div>
          							</div>
          							<br/><br/>
          						");
          						break;

          					default:
          						echo "Unknown question type";
          						break;
          				}
          				
          			}
          			print("</ul>");
    ?>
    	<br>
			<input type="hidden" name="quizname" value="<?php print $quizName; ?>">
			<input type="submit">
		</form>
       <hr>



      <br>
      <hr>
    </div>
  </div>
</div>


</body>