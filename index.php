<?php

	session_start($_COOKIE["SessionID"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/tbs_class_php4.php");

	$tmplatename = "mainpage.tpl.php";
	$tmpl_UserID = 0;
	$tmpl_UserName = '';
	$tmpl_UserEmail = '';
	$tmpl_UserReminder = 'checked';

	$tpl = new clsTinyButStrong ;

	if (isset($_SESSION['UserID']))
	{
		$tmpl_UserID = $_SESSION['UserID'];
		$tmpl_UserName = $_SESSION['UserName'];
		$tmpl_UserReminder = '';
		
		if( $_SESSION['Reminder'] == 1)
		  $tmpl_UserReminder = 'checked';
		
	}

	if (isset($_COOKIE["UserEmail"]))
		$tmpl_UserEmail = $_COOKIE["UserEmail"];

	//Load and display the template
	$tpl->LoadTemplate($_SERVER["DOCUMENT_ROOT"].'/crtc/boxoffice/'.$tmplatename);
	$tpl->Show();

?>
