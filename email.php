<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/basicschedule.inc.php");
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Allen Halsted <email@email.com>' . "\r\n";
$headers .= 'Reply-To: email@email.com' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();
$subject = 'Box Office Schedule';

$to = isset($_POST['email']) ? $_POST['email'] : 'email@email.com';

$message = BuildEmail();

echo $message;
//mail($to, $subject, $message, $headers);

mysql_close($link);


function BuildEmail()
{
$retval = '<html>'
	. ' <head>'
	. '   <title>Box Office Schedule Reminder</title>'
	. AddStyle()
	. ' </head>'
	. ' 	<body>'
	. ' 	 <br /> <br />'
	.	AddSchedule(-1, 1024) 
	. ' 	 <br /> <br />'
	. ' </body>'
	. ' </html>';
	
	return $retval;
}

function AddStyle()
{
	$retval = '<style>'
			. ' * {	margin: 0;	padding: 0;	font-size: 1em;	text-decoration: none; border: 1px; list-style: none; outline: 1px;}'
			. ' body { background: #fff; font: 13px/20px "Helvetica Neue", Helvetica, Arial, sans-serif; color: #536376; padding-left:10px;}'
			. ' h1 { text-align:left; font-family:Arial; font-size:16px; font-weight:bold; padding-bottom: 5px; }'
			. ' h2 { text-align:left; font-family:Arial; font-size:24px; font-weight:bold; padding-bottom: 5px; color: #600010;}'
			. ' table { border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid; }'
			. ' td { text-align:center; margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;}'
			. ' </style>';
	return $retval; 
}


?>