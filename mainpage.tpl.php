<!DOCTYPE html>
<html>
<head>
<title>Box Office Schedule</title>
<meta http-equiv="Content-type" content="text/html;charset=ISO-8859-1">

<link href="css/style.css" rel="stylesheet">
<link href="css/tables.css" rel="stylesheet">
<link href="css/leanmodal.css" rel="stylesheet">
<script type="text/javascript" src="script/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="script/pace.min.js"></script>
<script type="text/javascript" src="script/jquery.leanModal.min.js"></script>
<script type="text/javascript" src="script/menu_jquery.js"></script>
<script type="text/javascript" src="script/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="script/jquery.printPage.js"></script>
<script type="text/javascript" src="script/displayfunctions.js"></script>
<script type="text/javascript" src="script/jquery.slidePanel.min.js"></script>

<script type="text/javascript">
	var UserID = [var.tmpl_UserID;htmlconv=no;noerr];
	var UserName = '[var.tmpl_UserName;htmlconv=no;noerr]';
	var ShowingLogin = false;
	var LoginDone = false;
    $(function() {
    	$('#showLogin_id').leanModal({ top : 200, closeButton: ".modal_close" });
		$('#showHelp_id').leanModal({ top : 200, closeButton: ".modal_close" });
		$('#showFAQ_id').leanModal({ top : 200, closeButton: ".modal_close" });
		$('#showPhone_id').leanModal({ top : 200, closeButton: ".modal_close" });
		$('#showReminder_id').leanModal({ top : 200, closeButton: ".modal_close" });

		$('#faqscrollbox').slimScroll({ height: '300px', wheelStep: 1, railVisible: true, alwaysVisible: true });
		$('#helpscrollbox').slimScroll({ height: '300px', wheelStep: 1, railVisible: true, alwaysVisible: true });
		
		ShowingLogin = true;	

		$("#btnPrint").printPage({
		  url: "print.php",
		  attr: "href",
		  message:"Your schedule is being printed"
		});
        
		$('#pass').keydown(function (e){
			if(e.keyCode == 13){
				$('#btnlogin').click();
			}
		})
		
		if($(window).width() < 1250)
		{
			$('#navbar').addClass( "hideMe" );
			$('#menuTrigger').removeClass( "hideMe" );
			$('#content').removeClass( "leftMargin" );

			$('#navbar').slidePanel({
				triggerName: '#menuTrigger',
				position: 'fixed',
				triggerTopPos: '60px',
				panelTopPos: '0px',
				panelOpacity:  1, 
				speed: 'fast', 
				ajax: false
			});
		}

	});
	
	
	function open_Login_popup() {
		if(!LoginDone)
		{
			LoginDone = true;
			if(UserID == 0)
				$('#showLogin_id').click();
			else
			{
				loadWeek(1);
				loadWeek(2);
				loadShowNight();
			}
		}
	}
	
	

</script>

</head>
<body onload="open_Login_popup();">
	<div id="container">
		<a href="#" id="menuTrigger" class="trigger left hideMe">Menu</a>
		<div id="navbar">
			<div id='cssmenu'>
			<ul>
			   <li><span>Schedule Menu</span></li>
			   <li class='has-sub'><a href='#'><span id="mainmenu" >Menu</span></a>
				  <ul>
					 <li><a id="btnPrint" href='#'><span>Print Schedule</span></a></li>
					 <li><a id="showReminder_id" href='#reminder'><span>Reminder Email</span></a></li>
					 <li class='last'><a href='logout.php'><span>Log Out</span></a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Help</span></a>
				  <ul>
					 <li><a id="showHelp_id" href='#generalhelp'><span>General Help</span></a></li>
					 <li class='last'><a  id="showFAQ_id" href='#faq'><span>FAQ</span></a></li>
				  </ul>
			   </li>
			   <li class='has-sub last'><a href='#'><span>Contact Allen</span></a>
				  <ul>
					 <li><a href='mailto:email@email.com?Subject=Box%20Office'><span>Email</span></a></li>
					 <li class='last'><a id="showPhone_id" href='#phone'><span>Phone</span></a></li>
				  </ul>
			   </li>
			</ul>
			</div>
			<a id="showMenu" href='#'></a>
		</div>
		<div id="content" class="leftMargin">
			<br />
				<h1 class="logo">Box Office Schedule</h1>
			<br /><br />
			<h3>Week 1</h3>

			<div id="week1" class="CSSTableGenerator" style="width: 1048px; height: 250px;">
			</div>

			<br />
			<h3>Week 2</h3>
			<div id="week2" class="CSSTableGenerator" style="width: 1048px; height: 250px;">
			</div>

			<br />
			<h3>Show Nights</h3>
			<div id="shownight" class="CSSTableGenerator" style="width: 1048px; height: 225px;">
			</div>
			<p>On Show Nights: Attire needs to be a white shirt paired with either a black skirt or slacks. This is in keeping with the attire of the student ushers.</p>
			<br /><br />
		</div>
	</div>	

	
	<a id="showLogin_id" name="signup" href="#signup" ></a>

	<div id="signup">
		<div id="signup-ct">
			<div id="signup-header">
				<h2>CRTC Box Office Signup</h2>
				<p>Please login.</p>
				<a id="closelogin" class="modal_close" href="#"></a>
			</div>
				<div class="txt-fld">
					<label for="">Email Address</label> <input id="email" name="email" type="text" value="[var.tmpl_UserEmail;htmlconv=no;noerr]"/>
				</div>
				<div class="txt-fld">
					<label for="">Password</label> <input id="pass" name="pass" type="password" />
				</div>
				<div class="btn-fld">
					<button id="btnlogin" name="btnlogin" onClick="login_OnClick()" type="">Login &raquo;</button>
				</div>
				<div class="loginemail">
					If you have any problems or questions please contact Allen at <a href="mailto:email@email.com?Subject=Box%20Office%20Sign%20up" target="_top">email@email.com</a>
				</div>
		</div>
	</div>
	
	<div id="generalhelp">
		<div id="generalhelp-ct">
			<div id="generalhelp-header">
				<h2>General Help</h2>
				<a id="closehelp" class="modal_close" href="#"></a>
			</div>
			<div id="helpscrollbox">
				<p>
				The box office is open to the public from 10am until 3pm for two weeks leading up to the show. We run two shifts each day during that time. The first shift is from 9:45am until 12:30pm and the second shift is from 12:30pm until 3:15pm. We would like for two people to work each shift, giving us a total of four volunteers needed each day. 
				<br /><br />
				This program will allow you to volunteer for one slot on each shift. Once you are logged in all you need to do is click one of the red buttons indicating the day and shift you would like to volunteer for, and the system will record your request into that slot. 
				<br /><br />
				On show night the box office opens an hour and a half before the show starts. We need four people in the box office on each night. At least two people will need to stay in the box office until intermission and the rest may leave when the show starts. 
				<br /><br />
				Again, you will click one of the red buttons indicating which night(s) you wish to volunteer for. The main difference on show nights is that you must choose if you want to leave when the show starts, or you can stay through intermission. 
				<br /><br />
				Once you have chosen to volunteer for a shift you can cancel at anytime up until 24 hours before your shift. After that you can still cancel but you will have to email or call Allen as the system will not let you.  Please contact me so that we can make sure that shift is covered.
				</p>
			</div>
			<div class="btn-fld">
				<button onClick="close_OnClick('closehelp')">Close</button>
			</div>
		</div>
	</div>

	<div id="faq">
		<div id="faq-ct">
			<div id="faq-header">
				<h2>Frequently Asked Questions</h2>
				<a id="closefaq" class="modal_close" href="#"></a>
			</div>
			<div id="faqscrollbox">
			<p>
			<b>Something came up and I need to cancel my shift for tomorrow, but it won't let me.</b> <br />
			Once you have chosen to volunteer for a shift you can cancel at anytime up until 24 hours before your shift. After that you can still cancel but you will have to email or call Allen as the system will not let you.  Please contact me so that we can make sure that shift is covered.
			<br /><br />
			<b>When I click a button to volunteer for a shift, two buttons will often vanish.</b> <br />
			The system is simply preventing you from accidentally volunteering for the shame shift twice. The button is gone on your screen, but it is still available for other people.
			<br /><br />
			<b>I am having problems or I found a bug.</b> <br />
			The system is still very new and may not work correctly on every system. Please feel free to call or email Allen with any problem you find.
			<br /><br />
			<b>The system does not work on my phone or tablet.</b> <br />
			Developing websites that work well on all mobile devices as well as Mac and PC is a difficult and time consuming process. In the future I do plan to fully support any web enabled device you may have, but right now I am only promising that it will work on your Mac or PC.
			<br /><br />
			<b>What should I wear if I volunteer on Show Nights?.</b> <br />
			Attire needs to be a white shirt paired with either a black skirt or slacks. This is in keeping with the attire of the student ushers.
			</p>
			</div>
			<div class="btn-fld">
				<button onClick="close_OnClick('closefaq')">Close</button>
			</div>
		</div>
	</div>
	
	<div id="phone">
		<div id="phone-ct">
			<div id="phone-header">
				<h2>Call Allen</h2>
				<p>Please feel free to call me at anytime.</p>
				<a id="closephone" class="modal_close" href="#"></a>
			</div>
				<h3>Cell Phone: ###-###-####</h3>
				<h3>Home Phone: ###-###-####</h3>
				<div class="btn-fld">
					<button onClick="close_OnClick('closephone')">Close</button>
				</div>
		</div>
	</div>
	
	<div id="reminder">
		<div id="reminder-ct">
			<div id="reminder-header">
				<h2>Email Reminders</h2>
				<a id="closereminder" class="modal_close" href="#"></a>
			</div>
				<p>The day before your scheduled shift the system will email you a reminder.</p>
				<p>You May opt out of the reminder by unchecking the box below.</p>
				<h3><input onClick="reminder_OnClick()" type="checkbox" value="None" id="remindercheck" name="remindercheck" [var.tmpl_UserReminder;htmlconv=no;noerr] /> Send me email reminders</h3>
				<div class="btn-fld">
					<button onClick="close_OnClick('closereminder')">Close</button>
				</div>
		</div>
	</div>
	
</body>
</html>
