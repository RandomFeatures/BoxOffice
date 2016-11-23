
<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/basicschedule.inc.php");

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Allen Halsted <email@email.com>' . "\r\n";
$headers .= 'Reply-To: email@email.com' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();

$subject = 'Box Office Schedule Reminder';
$UserList = array();
$interval = '1';

if (isset($_GET['int'])) {
    $interval = $_GET['int'];
}

//all slots
$sql = 'SELECT  users.`ID` as UserID, `Email`, `FirstName`, `SlotName`, slots.`SlotDate`, slots.`SlotTime` '
        . ' FROM `tblUserSlot_Xref` slotxref'
        . ' LEFT JOIN `tblUsers` users'
        . ' ON users.`ID` = slotxref.`UserID`'
        . ' LEFT JOIN `tblSlots` slots'
        . ' on slots.`ID` = slotxref.`SlotID`'
		. ' WHERE  slots.`SlotDate` = CURDATE() + INTERVAL ' . $interval . ' DAY'
		. ' AND users.`ID` IS NOT NULL'
		. ' AND users.`Reminder` <> 0'
		. ' ORDER BY users.`ID`, slots.`SlotTime`'
        . ' LIMIT 0, 50 ';
		

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) 
{
	if (!in_array($row['UserID'], $UserList))
	{
		array_push($UserList, $row['UserID']);
		
		if($row['SlotTime'] == 'am')
				$tmpTime = '<span style="color:#C423CC">9:45am - 12:30pm</span>';
		if($row['SlotTime'] == 'pm')
				$tmpTime = '<span style="color:#2444E2">12:30pm - 3:15pm</span>';
		if($row['SlotTime'] == 'ln')
				$tmpTime = '<span style="color:#00CC00">10:16am - 12:40pm</span>';		


		$datetime = strtotime($row['SlotDate']);
		$Date = date('\o\n l, F jS, Y', $datetime);

		$to  = $row['Email'];
		// message
		$message = BuildEmail( $row['UserID'], $row['FirstName'], $tmpTime, $Date);

		echo $message;
		mail($to, $subject, $message, $headers);
	}
}

mysql_free_result($result);

//all shows
$sql = 'SELECT users.`ID` as UserID, `Email`, `FirstName`, showslot.`ShowDate`, showslot.`ShowDay`, `LeaveEarly`'
        . ' FROM `tblUserShow_Xref` showxref'
        . ' LEFT JOIN `tblUsers` users'
        . ' ON users.`ID` = showxref.`UserID`'
        . ' LEFT JOIN `tblShowSlots` showslot'
        . ' on showslot.`ID` = showxref.`ShowID`'
		. ' WHERE  showslot.`ShowDate` = CURDATE() + INTERVAL ' . $interval . ' DAY'
		. ' AND users.`ID` IS NOT NULL'
		. ' AND users.`Reminder` <> 0'
		. ' ORDER BY users.`ID`'
        . ' LIMIT 0, 50 ';

$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) 
{
	if (!in_array($row['UserID'], $UserList))
	{
		array_push($UserList, $row['UserID']);
		
		if($row['ShowDay'] == 3)		
		{	
			if($row['LeaveEarly'] == 1)					
				$tmpTime = '<span style="color:#2444E2">6:00pm&nbsp;-&nbsp;Show&nbsp;Start</span>';
			else
				$tmpTime = '<span style="color:#C423CC">6:00pm&nbsp;-&nbsp;Intermission</span>';
		}else
		{
			if($row['LeaveEarly'] == 1)					
				$tmpTime = '<span style="color:#2444E2">6:00pm&nbsp;-&nbsp;Show&nbsp;Start</span>';
			else
				$tmpTime = '<span style="color:#C423CC">6:00pm&nbsp;-&nbsp;Intermission</span>';
		}
		
		$datetime = strtotime($row['ShowDate']);
		$Date = date('\o\n l, F jS, Y', $datetime);

		$to  = $row['Email'];
		
		$message = BuildEmail( $row['UserID'], $row['FirstName'], $tmpTime, $Date);

		echo $message;
		mail($to, $subject, $message, $headers);
	}
}

mysql_free_result($result);
mysql_close($link);


function BuildEmail($UserID, $Name, $Time, $Date)
{
$retval = '<html>'
	. ' <head>'
	. '   <title>Box Office Schedule Reminder</title>'
	. AddStyle()
	. ' </head>'
	. ' 	<body>'
	. ' 	  <p>Hello '.$Name.',</p>'
	. ' 	  <p>This is a reminder that you are scheduled for a '.$Time.' shift in the CRTC Box Office '.$Date.'.</p>'
	. ' 	  <p>Please see the schedule below for other upcoming shifts for which you have volunteered.</p>'
	. ' 	  <p>On show nights your attire needs to be a white shirt paired with either a black skirt or slacks. This is in keeping with the attire of the student ushers.</p>'
	. ' 	  <p>If you have any questions or you are unable to make your shift please contact Allen as soon as possible.</p>'
	. ' 	  <p> Email:  </p>'
	. ' 	  <p>Cell Phone: ###-###-#### </p>'
	. ' 	  <br />'
	. ' 	  <p>Thank you for all you do!</p>'
	. ' 	 <br /> <br />'
	.	AddSchedule($UserID, 1024) 
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

