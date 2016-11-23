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
	$SlotWeek = intval($_POST['week']);
	$TempTime = $_POST['time'];
		
	if($TempTime == 'am')
		$SlotTime = "'am'";
	if($TempTime == 'pm')
		$SlotTime = "'pm'";
	if($TempTime == 'ln')
		$SlotTime = "'ln'";

	//get the free slots
	$sql = 'SELECT slots.`ID`'
			. ' FROM `tblUserSlot_Xref` slotxref'
			. ' RIGHT JOIN `tblUsers` users'
			. ' ON users.`ID` = slotxref.`UserID`'
			. ' RIGHT JOIN `tblSlots` slots'
			. ' on slots.`ID` = slotxref.`SlotID`'
			. ' WHERE slots.`SlotDay` = '.$SlotDay
			. ' AND slots.`SlotWeek` = '.$SlotWeek
			. ' AND slots.`SlotTime` = '.$SlotTime
			. ' AND slotxref.`ID` is null'
			. ' LIMIT 0, 50 ;';

	$result = mysql_query($sql);
	
	if(mysql_num_rows($result) > 0)
	{
		//just grab the first row
		$row = mysql_fetch_array($result);
		$SlotID = $row['ID'];
		mysql_free_result($result);
		
		$sql = "INSERT INTO `tblUserSlot_Xref` (`ID`, `UserID`, `SlotID`, `AssignDate`) VALUES (NULL, $UserID, $SlotID, NOW());";
		mysql_query($sql);
		echo '{"error":false}';
	}
	else
	{
	echo '{"error":true}';
	}
	mysql_close($link);

?> 

