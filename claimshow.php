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
	
	$SlotDay = intval($_POST['day']);
	$LeaveEarly = intval($_POST['early']);
		

	//get the free slots
	$sql = 'SELECT showslots.`ID`'
			. ' FROM `tblUserShow_Xref` showxref'
			. ' RIGHT JOIN `tblUsers` users'
			. ' ON users.`ID` = showxref.`UserID`'
			. ' RIGHT JOIN `tblShowSlots` showslots'
			. ' on showslots.`ID` = showxref.`ShowID`'
			. ' WHERE showslots.`ShowDay` = '.$SlotDay
			. ' AND showxref.`ID` is null'
			. ' LIMIT 0, 50 ;';

	$result = mysql_query($sql);
	
	if(mysql_num_rows($result) > 0)
	{
		//just grab the first row
		$row = mysql_fetch_array($result);
		$SlotID = $row['ID'];
		mysql_free_result($result);
		

		$sql = "INSERT INTO `tblUserShow_Xref` (`ID`, `UserID`, `ShowID`, `LeaveEarly`) VALUES (NULL, $UserID, $SlotID, $LeaveEarly);";
		mysql_query($sql);
		echo '{"error":false}';
	}
	else
	{
	echo '{"error":true}';
	}
	mysql_close($link);

?> 

