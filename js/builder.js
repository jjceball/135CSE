/**
 *  ***************************************
 *	CSE134B Web-Client Languages
 *	Quiz Maker Project: The Quizzler
 * 	Authors: Group 15 - PHO DUH NGUYEN
 *	Summer 2013
 *
 *	Assignment 1-4: The Quizzler
 *	Content: builder.js 
 *	
 *  ***************************************
 */

var counter_q = 0;
var counter_aq = 0;
var counter_aq2 = 0;
var qCount = 0; // Total quiz questions
var altColor = 0; // For switching between ascending and descending sorting
var absolutepcounter = 0; // Total quiz points
var ptarray = new Array(); // Array to hold the point
var elearray = new Array(); // Array corresponding with the point that hold question id with points added
var questarray = new Array(); // Array to hold the quiz type
var ansarray = new Array(); // Array corresponding with quiz type that hold all quiz questions
var clickMe = 0;
var ansCount = 0; // Answer count for preview page
var pquestCount = 1; // Question count for preview page
var removedsize = 400;
var answerloop = 150;
var questionsPerPage = 5; // Total number of questions per page in the preview page

// Count for each of the quiz type (multiple choice, fill-in blank, true-false, etc...)
var mcsCount =0;
var mcmCount =0;
var tfCount =0;
var fiCount =0;
var saCount =0;
var seCount =0;

// For timer: hour and minutes
var myhour = 0;
var myminutes = 0;

$(document).ready(function(){

$(function() {
      $( "#dontForget" ).tooltip({ hide: { effect: "blind", delay:5000, duration: 5000 }, show: { effect: "blind", delay:300, duration: 300 }});
    });
	
	
	$("#page1,#page2,#page3,#page4,#page5").sortable({ // Sorting between the right side pages
        connectWith: '.rightscroll',
        dropOnEmpty: true,
        axis: 'y',
        zIndex: 1004,
        cursor: 'move'
    });   
    
    $( "rightscroll" ).sortable({ // Sorting between the element within the pages
        connectWith: "rightscroll",
		axis:'y',
        dropOnEmpty: true
        });

    $( ".rightscroll" ).disableSelection();

  $("#addQList").one("click", function() { // Add option to help user identify what to do upon adding a quiz
    $("#owl").animate({top:"400px"});
    $("#modifyPop").fadeIn(1000);
    $("#dontForget").tooltip("open");

    $("#owl").delay(5000).animate({top:"1000px"}); // Display an owl for morale boost!
    $("#modifyPop").delay(4000).fadeOut();
    jQuery.fn.delay = function(time,func){
        return this.each(function(){
            setTimeout(func,time);
        });
    };

    $('.ui-tooltip').delay(5000, function(){
        $('.ui-tooltip').fadeOut('fast');
        }
    );
   
    $('.ui-tooltip').delay(10000, function(){
        $(".ui-tooltip").remove();
        $("#modifyPop").remove();
        $("#owl").remove();
        }
    );
  });
	
	tabRefresh(); // Refresh the tab to prevent display issue

    $("input#add-tab").click(function() {
        var num_tabs = $("div#tabs >ul >li").size()+1;
        $("div#tabs > ul.tabNav").append( // Adding new tab
            "<li id='mytab-"+ num_tabs +"' class='tabTop ui-state-default ui-corner-top ui-droppable' draggable='true' ><a ondblclick='edit(this)' href='#tabs-" + num_tabs + "' class='section-tabs'>Section " + num_tabs + "</a></li>"
        );
        $("div#tabs").append( // Adding new question inside the tab
                "<div id='tabs-" + num_tabs + "'>" +
                '<ol class="question_list connectedSortable ui-helper-reset">'+
				'</ol>' +
                "</div>"
            );
	
		var sidelistid = 'smytab-' + num_tabs; // Adding tab to the right side as well
		$("div#sidescroll > ul#page1.rightscroll").append("<li class='rightqlist' draggable='true' id=" + sidelistid + ">Section " + num_tabs + "</li>");
		hideMe2('.ListingOption');
        $("div#tabs").tabs("refresh"); // Refresh tab after each question is added to display it immediately
        tabRefresh();
        if (num_tabs == 9) // Max limit for tab
        {
        	$(this).css('display','none');
        }
    }); 
});

function tabRefresh() // Refresh display the current number of question in each tab
{
	$( "div#tabs>ul.tabNav" ).sortable(); // For sorting the tabs
	$( "div#tabs>ul.tabNav" ).disableSelection();
	$( ".question_list" ).sortable( // For sorting the questions within the tabs
	{ handle: '.question'
	}
	).disableSelection();
	var $tabs = $( "#tabs" ).tabs();
	var $tab_items = $( "ul:first li", $tabs ).droppable({ // Make user able to drop question to another tab
	  accept: ".connectedSortable li.questionItem",
	  hoverClass: "ui-state-hover",
	  tolerance: "pointer",
	  drop: function( event, ui ) {
		var $item = $( this );
		var $list = $( $item.find( "a" ).attr( "href" ) )
		  .find( ".connectedSortable" );
 
		ui.draggable.hide( "slow", function() { // Switch to the new tab where the question is added
		  $tabs.tabs( "option", "active", $tab_items.index( $item ) );
		  $( this ).appendTo( $list ).show( "slow" );
		  $( this ).css({'height' : 'auto', 'width' : 'auto'});
		});
	  }
	});
}

function displayResult(hours, minutes) // Display the timer if input is entered correctly, otherwise throw an error
{
	myhour = hours;
	myminutes = minutes;
	var correctness = 0;
	if (/^\d+$/.test(myhour) && /^\d+$/.test(myminutes)) // Check if input is integer
	{
		if (parseInt(myhour) > -1 && parseInt(myhour) < 25 && parseInt(myminutes) > 0 && parseInt(myminutes) < 61)
		{
			var time_total = "Quiz Time: " + myhour + ":" + myminutes + " hour(s)";
			var total = "SUCCESS! the quiz is set to " + myhour + ":" + myminutes + " hour(s) long";
			alert(total); // Alert the user of his/her input, then write the input on the webpage
			document.getElementById('time_here').innerHTML = time_total;
		}
		else
		{
			var total = "FAILURE! please insert the correct time";
			alert(total);
		}
	}
	else
	{
		var total = "FAILURE! please insert the correct time";
		alert(total);
	}
}

function addPts(mypts, uniqueid) // Add points for the quiz
{
	var points = mypts;
	if (/^\d+$/.test(points)) // Check if input is integer
	{
		var parsedpoints = parseInt(points);
		var totalpoint = 0;
		if (elearray.length == 0)
		{
			elearray.push(uniqueid);
			ptarray.push(parsedpoints);
			totalpoint += parsedpoints;
		}
		else
		{
			for (var i = 0; i < elearray.length; i++)
			{
				if (elearray[i] == uniqueid) // If change existing point of question, replace old point with that point
				{
					ptarray[i] = parsedpoints;
					break;
				}
				else if (i == elearray.length - 1) // If add point to question without points, add point element to array
				{
					elearray.push(uniqueid);
					ptarray.push(parsedpoints);
					break;
				}
			}
			for (var j = 0; j < ptarray.length; j++) // Loop through the point array to get total points
			{
				totalpoint += ptarray[j];
			}
		}
		absolutepcounter = totalpoint;
		document.getElementById('point_here').innerHTML = absolutepcounter;
	}
	else
	{
		var total = "FAILURE! please insert the correct point value";
		alert(total);
	}
}

function addToList(listClass, mc) // Add question to a list
{
	var ansListName = document.getElementById(listClass).children[0].children[0].name;
	if (mc == "singleans"){
	$("#"+listClass).append('<li draggable="true"><input type="radio" name="'+ansListName+'" class="check"> <input class="mca" onfocus="editAnswer(this)" type="text" size= "50" value="Add your answer here..."> <img class="icon-sort" src="img/drag_icon.png"> <img class="icon-delete" onclick="closeMe(this.parentNode)" src="img/delete.png" alt="delete"></li>');
	} else if (mc == "multians") {
	$("#"+listClass).append('<li draggable="true"><input type="checkbox" name="'+ansListName+'" class="check"> <input class="mca" onfocus="editAnswer(this)" type="text" size= "50" value="Add your answer here..."> <img class="icon-sort" src="img/drag_icon.png"> <img class="icon-delete" onclick="closeMe(this.parentNode)" src="img/delete.png" alt="delete"></li>');
	} else {
	$("#"+listClass).append('<li draggable="true">Possible answer: <input class="mca" onfocus="editAnswer(this)" type="text" size= "16"><img class="icon-sort" src="img/drag_icon.png"> <img class="icon-delete" onclick="closeMe(this.parentNode)" src="img/delete.png" alt="delete"></li>'); }
}


function save(elm, input) // Save edited value
 {
  var parentmain = elm.parentNode.id;
  var parentside = document.getElementById("s" + parentmain);
  var message = input.value.replace(/<([^>]*)>/g, "&lt;$1&gt;"); // set content to edited value
  elm.innerHTML = message;
  elm.value = message;
  if (parentside != null)
	parentside.textContent = message; 
 }
 
function edit(elm) // Allow modifying existing value with new value
 {
  // check to see if we are already editing
  if (elm.firstChild.tagName && elm.firstChild.tagName.toUpperCase() == "INPUT")
    return;
 
  var input = document.createElement("input"); // create edit field
  input.type = "text";
  input.value = elm.innerHTML;
  var oldValue = elm.innerHTML;
  input.size = 40;
 
  var editstyles = elm.className.match(/inedit-(\w+)/); // apply special editing style
  if (editstyles)
   input.className = RegExp.$1;
   
  elm.innerHTML = '';   // convert content to editable 
  elm.appendChild(input);
 
  if (input.selectionStart) // position cursor and focus
    input.selectionStart = input.selectionEnd = 0;
  else
  {
     var range = input.createTextRange();
     range.move("character", 0);
     range.select();
  }
  input.value = '';
  input.focus();
 
  input.onblur = function(){ // set save trigger callback
      this.onblur = function(){};
	  if(input.value == '')
		  input.value = oldValue;
	  save(elm, input);
	  };
  input.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
	  this.onblur();
	  if(input.value == '')
		  input.value = oldValue;
	  save(elm, input);
    }
	});
}

function editAnswer(input) // Call for specifically editing answers to question
{	 	 
	  var oldValue2 = input.value;
	  input.value = '';
	 
	  input.onblur = function(){
		  if(input.value == '')
			  input.value = oldValue2;
		  };
}

function minimizeMe(q) // Allow the ability to minimize each question
{
	$("#"+q).slideToggle();
}

function allowDrop(ev) // Allow to drag and drop question to a field to add them
{
	ev.preventDefault();
}

function drag(ev) // When dragging question, save it's id
{
	ev.dataTransfer.setData("Text",ev.target.id);
}

function drop(ev) // When question is dropped, add the question to the tab
{
	ev.preventDefault();
	var isLink = ev.dataTransfer.getData("Text");
	if (isLink == "qtype1")
		addQuestion("plus1");
	else if (isLink == "qtype2")
		addQuestion("plus2");
	else if (isLink == "qtype3")
		addQuestion("plus3");
	else if (isLink == "qtype4")
		addQuestion("plus4");
	else if (isLink == "qtype5")
		addQuestion("plus5");
	else if (isLink == "qtype6")
		addQuestion("plus6");
}

function hovericon(hov) // When mouse is hovering on editable texts
{
	hov.style.color="#FF9900";
}

function normalimg(hov) // When mouse is not hovering on editable texts
{
	hov.style.color="#009966";
}

function closeMe(toClose) // Remove quiz question and/or answer
{
	if(toClose.children[0].tagName == 'DIV') // If statement for removing questions
	{
		qCount--;
		var uniqueid = toClose.children[0].id;
		for (var i = 0; i < elearray.length; i++) // Loop through point counter array
		{
			if (elearray[i] == uniqueid) // Check if the child id match with the point counter id
			{
				absolutepcounter -= ptarray[i]; // If match, remove the corresponding number of points
				elearray.splice(i, 1);
				ptarray.splice(i, 1);
				break;
			}
		}
		for (var j = 0; j < ansarray.length; j++) // Loop through quiz question array
		{
			if (ansarray[j].id == uniqueid) // Check if the child id match the question id
			{
				var removeside = document.getElementById("s" + uniqueid);
				var parentside = removeside.parentNode;
				if(parentside.id == "page1" || parentside.id == "page2" || parentside.id == "page3"
					|| parentside.id == "page4" || parentside.id == "page5")
					parentside.removeChild(removeside);
				ansarray.splice(j, 1);
				// If match, subtract the corresponding question type counter
				if (questarray[j] == 'plus1')
				{
					document.getElementById('mcs_badge_here').innerHTML = --mcsCount;
					if (mcsCount == 0)
						document.getElementById('mcs_badge_here').style.display = 'none';
				}
				if (questarray[j] == 'plus2')
				{
					document.getElementById('mcm_badge_here').innerHTML = --mcmCount;
					if (mcmCount == 0)
						document.getElementById('mcm_badge_here').style.display = 'none';
				}
				if (questarray[j] == 'plus3')
				{
					document.getElementById('tf_badge_here').innerHTML = --tfCount;
					if (tfCount == 0)
						document.getElementById('tf_badge_here').style.display = 'none';
				}
				if (questarray[j] == 'plus4')
				{
					document.getElementById('fi_badge_here').innerHTML = --fiCount;
					if (fiCount == 0)
						document.getElementById('fi_badge_here').style.display = 'none';
				}
				if (questarray[j] == 'plus5')
				{
					document.getElementById('sa_badge_here').innerHTML = --saCount;
					if (saCount == 0)
						document.getElementById('sa_badge_here').style.display = 'none';
				}
				if (questarray[j] == 'plus6')
				{
					document.getElementById('se_badge_here').innerHTML = --seCount;
					if (seCount == 0)
						document.getElementById('se_badge_here').style.display = 'none';
				}
				questarray.splice(j, 1); // Remove the element from the array afterward
				break;
			}
		}
		document.getElementById('point_here').innerHTML = absolutepcounter;
		document.getElementById('num_quest_here').innerHTML = qCount; // Update subtracted point counter
	}
	// If not a question, but an answer, just directly remove the child
	toClose.parentNode.removeChild(toClose);
}

function addQuestion(question) // Adding new question to the quiz
{
	window.qCount++;
	if(question == "plus1") // Add multiple choice (single answer)
	{
		var newQ = document.getElementById('mc1').cloneNode(true);
		newQ.getElementsByClassName('ui-sortable')[0].id = 'sortC'+counter_q;
		var list, index;
		answerlist = newQ.getElementsByClassName("check");
		for (indexAL = 0; indexAL < answerlist.length; ++indexAL) {
		    answerlist[indexAL].setAttribute('name', 'answerList'+counter_q);
		}
		questarray.push('plus1');
		document.getElementById('mcs_badge_here').innerHTML = ++mcsCount;
		document.getElementById('mcs_badge_here').style.display = 'block';
	}
	else if(question == "plus2") // Adding multiple choice (mutliple answers)
	{
		var newQ = document.getElementById('mc2').cloneNode(true);
		newQ.getElementsByClassName('ui-sortable')[0].id = 'sortC'+counter_q;
		var list, index;
		answerlist = newQ.getElementsByClassName("check");
		for (indexAL = 0; indexAL < answerlist.length; ++indexAL) {
		    answerlist[indexAL].setAttribute('name', 'answerList'+counter_q);
		}
		questarray.push('plus2');
		document.getElementById('mcm_badge_here').innerHTML = ++mcmCount;
		document.getElementById('mcm_badge_here').style.display = 'block';
	}
	else if(question == "plus3") // Adding true and false
	{
		var newQ = document.getElementById('tf').cloneNode(true);
		newQ.getElementsByClassName('ui-sortable')[0].id = 'sortC'+counter_q;
		var list, index;
		answerlist = newQ.getElementsByClassName("check");
		for (indexAL = 0; indexAL < answerlist.length; ++indexAL) {
		    answerlist[indexAL].setAttribute('name', 'answerList'+counter_q);
		}
		questarray.push('plus3');
		document.getElementById('tf_badge_here').innerHTML = ++tfCount;
		document.getElementById('tf_badge_here').style.display = 'block';
	}
	else if(question == "plus4") // Adding fill-in blank
	{
		var newQ = document.getElementById('fi').cloneNode(true);
		newQ.getElementsByClassName('ui-sortable')[0].id = 'sortC'+counter_q;
		questarray.push('plus4');
		document.getElementById('fi_badge_here').innerHTML = ++fiCount;
		document.getElementById('fi_badge_here').style.display = 'block';
	}
	else if(question == "plus5") // Adding short answer
	{
		var newQ = document.getElementById('sa').cloneNode(true);
		newQ.getElementsByClassName('ui-sortable')[0].id = 'sortC'+counter_q;
		questarray.push('plus5');
		document.getElementById('sa_badge_here').innerHTML = ++saCount;
		document.getElementById('sa_badge_here').style.display = 'block';
	}
	else if(question == "plus6") // Adding short essay
	{
		var newQ = document.getElementById('se').cloneNode(true);
		questarray.push('plus6');
		document.getElementById('se_badge_here').innerHTML = ++seCount;
		document.getElementById('se_badge_here').style.display = 'block';
	}
	newQ.style.display="block"
	// Create new id values for added question
	newQ.id = "q" + counter_q;
	newQ.children[4].id = "content"+counter_q;
	newQ.querySelector('.pointsp').children[0].id = "points"+counter_q;
	var newli = document.createElement("li");
	newli.className = "questionItem";
	var focusedTab = $('*[aria-expanded="true"]')[0]
	var container = focusedTab.children[0];
	container.appendChild(newli);
	newli.appendChild(newQ);
	ansarray.push(newQ);
	
	tabRefresh();
    $( "#sortC"+counter_q ).sortable({ handle: '.icon-sort' }).disableSelection();
    $('#q'+counter_q+' >  div.widget-content > p.pointsp > input[class = "pValue"]').change(function(){
    	addPts(this.value, newQ.id);
	});
	document.getElementById('num_quest_here').innerHTML = qCount;
	var sidelistid = "s" + newQ.id; // Save the id of question to display on the right hand side
	$("div#sidescroll > ul#page1.rightscroll").append("<li class='rightslist' id='" + sidelistid + "' style='color:white; display:none;'>click to insert question here...</li>");
	hideMe2('.ListingOption');
	counter_q++;
}

function sortByColor() // Sort by color, group the color together in ascending or descending order
{
	if (altColor == 0)
	{
		$("div#tabs>div>ol>li").tsort({order:"asc"});
		altColor = 1;
	}
	else
	{
		$("div#tabs>div>ol>li").tsort({order:"dsc"});
		altColor = 0;
	}
}

function shuffle(items) // Shuffle the current list
{
    var cached = items.slice(0), temp, i = cached.length, rand;
    while(--i)
    {
        rand = Math.floor(i * Math.random());
        temp = cached[rand];
        cached[rand] = cached[i];
        cached[i] = temp;
    }
    return cached;
}

function randomizeMe(ans) // Randomize the list of answers
{
	var list = ans;
    var nodes = list.children, i = 0;
    nodes = Array.prototype.slice.call(nodes);
    nodes = shuffle(nodes);
    while(i < nodes.length)
    {
        list.appendChild(nodes[i]);
        ++i;
    }
}

function randomAns() // Loop through all answers in each question (to be randomized later)
{
	for (var i = 0; i < questarray.length; i++)
	{
		var questindex = questarray[i];
		if (questindex == 'plus1')
		{
			var idtag = ansarray[i].children[4].children[1];
			randomizeMe(idtag);
		}
		else if (questindex == 'plus2')
		{
			var idtag = ansarray[i].children[4].children[1];
			randomizeMe(idtag);
		}
		else if (questindex == 'plus4')
		{
			var idtag = ansarray[i].children[4].children[1].children[0];
			randomizeMe(idtag);
		}
		else if (questindex == 'plus5')
		{
			var idtag = ansarray[i].children[4].children[1].children[0];
			randomizeMe(idtag);
		}
	}
}
	$(function() {
		$( document ).tooltip();
	});
	
	function hideMe(className, obj) { // Hide a section if box is checked
		var $input = $(obj);
		if ($input.prop('checked'))
			$(className).hide();
		else
			$(className).show();
    }
	
	function hideMe2(obj) { // Switch between question and tab on right hand side
		var $input = $(obj);
		var tabid;
		var questid;
		if ($input.prop('checked')) // If box is check, hide tab and display question on right hand side
		{
			for (var i = 0; i < 10; i++)
			{	
				tabid = document.getElementById("smytab-" + i);
				if (tabid != null)
					tabid.style.display = 'none';
			}
			for (var j = 0; j < ansarray.length; j++)
			{
				questid = document.getElementById("s" + ansarray[j].id);
				if (questid != null)
					questid.style.display = 'block';
			}
		}
		else // Otherwise, hide question and display tab (current display)
		{
			for (var i = 0; i < 10; i++)
			{	
				tabid = document.getElementById("smytab-" + i);
				if (tabid != null)
					tabid.style.display = 'block';
			}
			for (var j = 0; j < ansarray.length; j++)
			{
				questid = document.getElementById("s" + ansarray[j].id);
				if (questid != null)
					questid.style.display = 'none';
			}
		}
    }
	
	function hideMe3() { // Toggle the display of the sidescroll box on the right hand side
		// Everything is set to hidden at first
		if (clickMe == 1)
		{
			document.getElementById("sidescroll").style.display = "none";
			clickMe = 0;
		}
		else
		{
			document.getElementById("sidescroll").style.display = "block";
			clickMe = 1;
		}
    }
    

	
	
	
		function createString()
	{
		var listIndex = 0; var questionIndex = 0;
		txt = '{"Quiz" : [' +
		'{"quizName" : "'+document.getElementById("quiz_name").textContent + '"}' +
		', {"questions" : [ ' ;

		var questionListArray = document.getElementsByClassName("question_list");
		for(var i = 0; i < qCount; i++)
		{
			while( !questionListArray[listIndex].children[questionIndex] )
			{
				listIndex++;
				questionIndex=0;
			}

			var questionbox = questionListArray[listIndex].children[questionIndex].children[0];

			var questiontype = $(questionbox).attr('class').split(' ')[1];
			//alert(questiontype);
			txt = txt.concat('{"questionType" : ' + '"' + questiontype + '"' +
			', "questionText" : [{ ' )
			var editArray = questionbox.getElementsByClassName("editable");
			for(var edit_c = 0; edit_c < editArray.length; edit_c++)
			{
				txt = txt.concat('"edit" : "' + editArray[edit_c].textContent + '",'  );
			}
			txt = txt.substring(0, txt.length-1);
			txt = txt.concat('}]'); //end of edits
			txt = txt.concat(', "answers" : [ '); 
			var mcaArray = questionbox.getElementsByClassName("mca"); //alert(mcaArray.length);
			var checkArray = questionbox.getElementsByClassName("check"); //alert(mcaArray.length);
			for(var j = 0; j < mcaArray.length; j++)
			{
				if(checkArray.length > 0)
					txt = txt.concat('{"answer":"' + mcaArray[j].value + '","checked":"' +  checkArray[j].checked + '"},');
				else
					txt = txt.concat('{"answer":"' + mcaArray[j].value + '"},');
			}
			txt = txt.substring(0, txt.length-1);
			txt = txt.concat(']'); //end of answers
			if (questionbox.getElementsByClassName("manualGrade").length > 0) {
				if( questionbox.getElementsByClassName("manualGrade")[0].checked == false )
					txt = txt.concat(', "manualGrade" : "false"')
				else
					txt = txt.concat(', {"manualGrade" : "' + questionbox.getElementsByClassName("manualGrade")[0].checked + '"}')
			}
			else
				txt = txt.concat(', "manualGrade" : "false"')
			txt = txt.concat(', "points" : ' + questionbox.getElementsByClassName("pValue")[0].value + ''); 
			txt = txt.concat('},'); //end of questionbox
			questionIndex++;
		}
		txt = txt.substring(0, txt.length-1);
		txt = txt.concat(']'); //end of questions in quiz
		txt = txt.concat('}');
		txt = txt.concat(']'); //end of questions in quiz
		txt = txt.concat('}'); //end of string

		alert(txt);
		//var obj = eval ('(' + txt + ')');

		$.ajax({
			type: "POST",
			url: "savequiz.php",
			data: {json: txt},
			success: function(json) {
						alert("Quiz saved!");
					 }
		});
	}
	
	
	
	
	function previewPage() // Quiz preview feature
	{
		var quizname = document.getElementById("quiz_name"); // Quiz name
		var previewname = document.getElementById("pquizname");
		if (quizname != null)
			previewname.innerHTML = "Quiz: " + quizname.textContent;
		var quizpts = document.getElementById("pquizpoints"); // Quiz point
		if (quizpts != null)
			quizpts.innerHTML = "Total Points: ____/" + absolutepcounter;
		var geteditnow = document.getElementById("pquiztimelimit"); // Quiz timer
		if (geteditnow != null)
			geteditnow.innerHTML = "You have " + myhour + ":" + myminutes + " hour(s) to finish this quiz";
		for (var i = 0; i < ansarray.length; i++)
		{
			var tempquestholder = ansarray[i].id;
			var secholder = tempquestholder.substring(0);
			var thirdholder = document.getElementById(secholder); // Question name
			$("#pquestionlist").append('<li id= "x' + secholder + '"> Question ' + pquestCount + ': ' + thirdholder.children[3].textContent + '<ul id ="panswerlist' + ansCount + '" style="list-style:none;">');
			
			if (thirdholder.className.substring(9) == "multChoiceSingle") // Multiple choice single answer question preview
			{
				var fourthholder = thirdholder.children[4].children[1];
				for (var j = 0; j < answerloop; j++)
				{	
					var anschildren = fourthholder.children[j];
					if (anschildren!= null)
						$("#panswerlist" + ansCount).append('<li><input type="radio" name="question1" class="checkradio">' + anschildren.children[1].value + '</li>');
					else
						break;
				}
			}
			else if (thirdholder.className.substring(9) == "multChoiceMult") // Multiple choice multiple answer question preview
			{
				var fourthholder = thirdholder.children[4].children[1];
				for (var j = 0; j < answerloop; j++)
				{	
					var anschildren = fourthholder.children[j];
					if (anschildren!= null)
						$("#panswerlist" + ansCount).append('<li><input type="checkbox" name="question1" class="checkradio">' + anschildren.children[1].value + '</li>');
					else
						break;
				}
			}
			else if (thirdholder.className.substring(9) == "trueFalse") // True and false question preview
			{
				$("#panswerlist" + ansCount).append('<li><input class="checktruefalse" type="radio" value="True">True</li>');
				$("#panswerlist" + ansCount).append('<li><input class="checktruefalse" type="radio" value="True">False</li>');
			}
			else if (thirdholder.className.substring(9) == "fillIn") // Fill in the blank question preview
			{
				var fillinquest = thirdholder.children[4].children[0];
				$("#panswerlist" + ansCount).append('<p>' + fillinquest.children[0].value +' <input class = "inputpq1" onfocus="editAnswer(this)" type="text" size= "16"> ' + fillinquest.children[1].value + '</p>');
				var fourthholder = thirdholder.children[4].children[2];
			}
			else if (thirdholder.className.substring(9) == "shortAnswer") // Short answer question preview
			{
				var fillinquest = thirdholder.children[4].children[0];
				$("#panswerlist" + ansCount).append('<p>' + fillinquest.children[0].value +' <input class = "inputpq2" onfocus="editAnswer(this)" type="text" size= "16"></p>');
				var fourthholder = thirdholder.children[4].children[2];
			}
			else // Short essay question preview
			{
				$("#panswerlist" + ansCount).append('<p style="margin: 0 0 2px 2px;">Insert answer in text box below:</p>' +
					'<textarea class = "mca" rows="14" cols="35"></textarea>');
			}
			pquestCount++;
			ansCount++;
			$("#pquestionlist").append('</ul></li>');
		}
		$("#qPerPage").change(function(){ // Determine how many questions go on each page
			questionsPerPage = parseInt(this[this.selectedIndex].textContent, 10);
			$('#quizpreview').pajinate({
			items_per_page : questionsPerPage,
			item_container_id : '.pquestionclass',
			nav_panel_id : '.alt_page_navigation'
			});
		});
		$('#quizpreview').pajinate({ // Paging option (default is 5 questions per page)
			items_per_page : questionsPerPage,
			item_container_id : '.pquestionclass',
			nav_panel_id : '.alt_page_navigation'
		});
	}
	
	function deleteAllQuestions() // After closing the preview page, all questions are deleted
	{
		for (var i = 0; i < removedsize; i++)
		{
			var toberemove = document.getElementById("xq" + i);
			if (toberemove)
			{
				toberemove.remove();
				pquestCount = 1;
			}
		}
		$('#quizpreview').pajinate({ // Paging option (default is 5 questions per page)
			items_per_page : questionsPerPage,
			item_container_id : '.pquestionclass',
			nav_panel_id : '.alt_page_navigation'
		});
	}
