<?php

	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/session.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
	
	
	if (isset($_SESSION['UserID']))
		$UserID = $_SESSION['UserID'];
	else
	{
		echo '{"error":true}';		
		die();
	}
	
	$Reminder = intval($_POST['reminder']);

	$sql = 'UPDATE `tblUsers` SET `Reminder` = '.$Reminder .' WHERE `ID` = '.$UserID.' LIMIT 1;';

	mysql_query($sql);
	
	mysql_close($link);
	
?>