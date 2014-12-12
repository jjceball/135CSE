<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="CSE134 quiz builder website by Group 15 Summer 2013" />
		<title>The Quizzler</title>
		<link rel="stylesheet" media="all" href="css/main.css" type="text/css"/>
		<!--script src="js/modernizr.custom.37797.js"></script--> 
		<!-- Grab Google CDN's jQuery. fall back to local if necessary --> 
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
		<script>!window.jQuery && document.write('<script src="/js/jquery-1.6.1.min.js"><\/script>')</script>
		<script src="js/parallax.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<header id="branding">	
				<h1><img src= "img/logo2.png" alt="logo for the quizzler" ></h1>
			</header>		
			<nav id="primary">
				<ul>
					<li>
						<h1>Welcome to the Quizzler</h1>
						<a class="manned-flight" href="#manned-flight">View</a>
					</li>
					<li>
						<h1>How to make a Quiz</h1>
						<a class="frameless-parachute" href="#frameless-parachute">View</a>
					</li>
					<li>
						<h1>How to Preview a Quiz</h1>
						<a class="english-channel" href="#english-channel">View</a>
					</li>
					<li>
						<h1>About Us</h1>
						<a class="about" href="#about">View</a>
					</li>
				</ul>
			</nav>
			<div id="content">
				<article id="manned-flight">
					<header>
						<h1>Welcome to the Quizzler!</h1>
					</header>
					<p>Hello all, my name is Quizzy. For those of you who does not know how to use the amazing quizzler, please scroll to see our tutorial that we've made. If you have made a quiz before please click the following icon to go to the Quizzer Builder! Please try it out now!</p>
					<br>
					<a href="Signup.html"><h2>Sign Up!</h2></a>
					<br>
                    <a href="login.html"><h2>Log In!</h2></a>
					<nav class="next-prev">
						<hr />
						<a class="next frameless-parachute" href="#frameless-parachute">Next</a>
					</nav>
				</article>			
				<article id="frameless-parachute">
					<header>
						<h1>Making a Quiz</h1>
					</header>
					<p>To Make a Quiz you must first start at our quiz builder. Write in your preferred quiz name and then add which ever types of questions you want. We have 6 types of questions for you to fill out : multiple-choice(	single answer), multiple-choice(multiple answer), true/false, fill-in, simple answer, and short essay. As you add your question by just clicking the icons, the question format should have added and displayed dynamically on the quiz view side of the builder page. As you fill in the question content, we allow you to select your prefered correct answer or leave it at default for certain question formatts. The user may also drag the questions up and down the list to reorganize their questions. Once the user is satisfied, they will then be able to save their quiz and administer it to their students accordingly. Have fun!
					Questions for you  </p>
					<nav class="next-prev">
						<a class="prev manned-flight" href="#manned-flight">Prev</a>
						<hr />
						<a class="next english-channel" href="#english-channel">Next</a>
					</nav>
				</article>			
				<article id="english-channel">
					<header>
						<h1>Quiz Features</h1>
					</header>
					<p>The Quizzler has many features for you to play with in our toolbox located on the right hand side of the screen including adding a timer, current point counter, question randomizer, save, preview, restart options, and a paging option for our professors. The timer, if selected, will allow the user to add a limited time to their test and select the permitted time to have the quiz administered. The Quizzler will even make your life easier with a handy point counter that will have a default point count of 1 but is able to be adjusted once you edit your individual questions. The question randomizer will ensure that each test given will randomize the order in which the user has created the quiz to discourage uncalled for behaviors in the class room. The save button will allow the user to save, the preview will allow the user to preview what they have so far, and the restart will clear what the user has on their test already just in case the user wishes to work off from a clean slate. Finally, the paging option will allow the user to select how many questions each user will see each page of their test. These features were design specifically for user ease and efficiency, so please, have fun and get started today! </p>
					<nav class="next-prev">
						<a class="prev frameless-parachute" href="#frameless-parachute">Prev</a>
						<hr />
						<a class="next about" href="#about">Next</a>
					</nav>
				</article>			
				<article id="about">
					<header>
						<h1>About</h1>
					</header>
					<p>This is CSE134B Client-Web Programming Project brought to you by <a href="PHODUHNGUYEN.html">@PHO DUH NGUYEN </a> Check us out! We hope to finish what we can and hope to deliver one of the "sexiest" sites from the class. WHOOT WHOOT. FTW! >:D</p>
					<nav class="next-prev">
						<a class="prev english-channel" href="#english-channel">Prev</a>
						<hr />
					</nav>
				</article>
			</div>			
			<!-- Parallax foreground -->
			<div id="parallax-bg3">
				<img id="bg3-1" src="img/quizzy.png" width="650" height="657" alt="Quizzler Guide Quizzy"/>
				<img id="bg3-2" src="img/tutorial1.png" width="600" height="1900" alt="Features of the Quizzler"/>
				<img id="bg3-4" src="img/ground.png" width="1104" height="684" alt="Landscape with some trees"/>
			</div>			
			<!-- Parallax  midground clouds -->
			<div id="parallax-bg2">
				<img id="bg2-1" src="img/cloud-lg1.png" alt="cloud"/>
				<img id="bg2-2" src="img/cloud-lg1.png" alt="cloud"/>
				<img id="bg2-3" src="img/cloud-lg1.png" alt="cloud"/>
				<img id="bg2-4" src="img/cloud-lg1.png" alt="cloud"/>
				<img id="bg2-5" src="img/cloud-lg1.png" alt="cloud"/>
			</div>		
			<!-- Parallax  background clouds -->
			<div id="parallax-bg1">
				<img id="bg1-1" src="img/cloud-lg2.png" alt="cloud"/>
				<img id="bg1-2" src="img/cloud-lg2.png" alt="cloud"/>
				<img id="bg1-3" src="img/cloud-lg2.png" alt="cloud"/>
				<img id="bg1-4" src="img/cloud-lg2.png" alt="cloud"/>
			</div>		
		</div>	
	</body>  
</html>