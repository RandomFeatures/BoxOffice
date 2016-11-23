<?php
	

	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");

	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$found = false;
	$sql = "SELECT `ID`, `FirstName`, `LastName`,`Reminder` FROM `tblUsers`"
		    . " WHERE `Email` = '$user'"
		    . " AND `Password` = '$pass' LIMIT 0, 50";

	$result = mysql_query($sql);
	if (!$result) {
		echo '{"error":true}';
	}

	while ($row = mysql_fetch_array($result)) {
		
		$UserID = $row['ID'];
		$UserName = $row['FirstName'].' '.substr($row['LastName'],0,1).'.';
		$UserReminder = $row['Reminder'];
	
		
		session_start($UserID);

		$_SESSION['UserID'] = $UserID; 
		$_SESSION['UserName'] = $UserName;
		$_SESSION['Reminder'] = $UserReminder;

		setcookie("UserEmail", $user, time()+60*60*24*30);
		setcookie("SessionID", $UserID);
		setcookie("Reminder", $UserReminder);
		echo '{"error":false,"UserID":'.$UserID.', "UserName":"'.$UserName.'","Reminder":'.$UserReminder.'}';

		$found = true;
		break;

	} 

	if (!$found){
		echo '{"error":true}';
	}

	mysql_free_result($result);

	$sql = 'UPDATE `tblUsers` SET `LastLogin` = NOW() WHERE `ID` = '.$UserID.' LIMIT 1;';
	mysql_query($sql);
	 
	mysql_close($link);

?>
