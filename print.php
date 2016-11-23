<?php
	session_start($_COOKIE["SessionID"]);
	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/basicschedule.inc.php");

	if (isset($_SESSION['UserID']))
	{
		$UserID = $_SESSION['UserID'];
	    $UserName = $_SESSION['UserName'];
	}else 
	{
		$UserID = 0;
		$UserName = '';
	}
	echo '<html><head><title>Box Office Schedule</title><meta http-equiv="Content-type" content="text/html;charset=ISO-8859-1"><link href="css/basic.css" rel="stylesheet"></head><body>';
	echo AddSchedule($UserID, '100%');
	/*
	echo '<h2>Box Office Schedule</h2>';
	for($iLoop=1;$iLoop<3;$iLoop++)
	{
		$SlotWeek = $iLoop;
		$sql = 'SELECT slotxref.`ID`, slots.`SlotDay`, slots.`SlotTime`, slots.`SlotName`, users.`ID` as UserID, users.`FirstName`, users.`LastName`'
		    . ' FROM `tblUserSlot_Xref` slotxref'
		    . ' RIGHT JOIN `tblUsers` users'
		    . ' ON users.`ID` = slotxref.`UserID`'
		    . ' RIGHT JOIN `tblSlots` slots'
		    . ' on slots.`ID` = slotxref.`SlotID`'
		    . ' WHERE slots.`SlotWeek` = '.$SlotWeek
		  	. ' ORDER BY slots.`SlotName`'
		    . ' LIMIT 0, 50 ;';
		$result = mysql_query($sql);

		if($SlotWeek == 1)
			$tmpWeek ='<table width="100%" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Monday, Sept 30th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Tuesday, Oct 1st</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Wednesday, Oct 2nd</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Oct 3rd</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Oct 4th</td>'
					.'</tr>';
		else
			$tmpWeek ='<table width="100%" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Monday, Oct 7th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Tuesday, Oct 8th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Wednesday, Oct 9th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Oct 10th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Oct 11th</td>'
					.'</tr>';

		$rowA = '<tr class="am">';
		$rowB = '<tr class="am">';
		$rowC = '<tr class="pm">';
		$rowD = '<tr class="pm">';
		$tmpDay = '';


		while ($row = mysql_fetch_array($result)) 
		{
			$tmpDay = '<td>';
			if(!is_null($row['UserID']))
			{			
				$tmpID = $row['UserID'];
				$tmpName = $row['FirstName'].' '.substr($row['LastName'],0,1).'.';
				if($row['SlotTime'] == 'am')
					$tmpTime = '9:30am - 12:30pm';
				else
					$tmpTime = '12:30pm - 3:30pm';

				if($tmpID == $UserID)
				{
					$tmpDay = $tmpDay.'<span style="color:#2444E2">'.$tmpName.'<br />'.$tmpTime.'</span>';
				}else
				{
					$tmpDay = $tmpDay.$tmpName.'<br />'.$tmpTime;
				}
			}else
			{
				$tmpDay = $tmpDay.'Volunteer Needed.';
			}

			$tmpDay = $tmpDay.'</td>';
			switch(substr($row['SlotName'],-1))
			{
				case 'a':
					$rowA = $rowA.$tmpDay;
					break;
				case 'b':
					$rowB = $rowB.$tmpDay;
					break;
				case 'c':
					$rowC = $rowC.$tmpDay;
					break;
				case 'd':
					$rowD = $rowD.$tmpDay;
					break;
			}

		}

		$rowA = $rowA.'</tr>';
		$rowB = $rowB.'</tr>';
		$rowC = $rowC.'</tr>';
		$rowD = $rowD.'</tr>';


		$tmpWeek = $tmpWeek.$rowA.$rowB.$rowC.$rowD.'</table>';

		
		echo '<h1>Week '.$SlotWeek.'</h1>';
		echo $tmpWeek.'<br />';
		mysql_free_result($result);
	}


	$sql = 'SELECT showxref.`ID`, showxref.`LeaveEarly`, slots.`ShowDay`, slots.`SlotName`, users.`ID` as UserID, users.`FirstName`, users.`LastName`'
		    . ' FROM `tblUserShow_Xref` showxref'
		    . ' RIGHT JOIN `tblUsers` users'
		    . ' ON users.`ID` = showxref.`UserID`'
		    . ' RIGHT JOIN `tblShowSlots` slots'
		    . ' on slots.`ID` = showxref.`ShowID`'
		  	. ' ORDER BY slots.`SlotName`'
		    . ' LIMIT 0, 50;';

		$result = mysql_query($sql);

		$tmpWeek ='<table width="100%" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Oct 10th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Oct 11th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Saturday, Oct 12th</td>'
					.'</tr>';

		$rowA = '<tr>';
		$rowB = '<tr>';
		$rowC = '<tr>';
		$rowD = '<tr>';
		$rowE = '<tr>';
		$tmpDay = '';

		while ($row = mysql_fetch_array($result)) 
		{
				$tmpDay = '<td>';
				if(!is_null($row['UserID']))
				{			
					$tmpID = $row['UserID'];
					$tmpName = $row['FirstName'].'&nbsp;'.substr($row['LastName'],0,1).'.&nbsp;';
					if($row['ShowDay'] == 3)
					{
						if($row['LeaveEarly'] == 1)					
							$tmpTime = '2:00pm&nbsp;-&nbsp;Show&nbsp;Start';
						else
							$tmpTime = '2:00pm&nbsp;-&nbsp;Intermission';
					}
					else
					{
						if($row['LeaveEarly'] == 1)					
							$tmpTime = '6:00pm&nbsp;-&nbsp;Show&nbsp;Start';
						else
							$tmpTime = '6:00pm&nbsp;-&nbsp;Intermission';
					}

					if($tmpID == $UserID)
					{
						$tmpDay = $tmpDay.'<span style="color:#2444E2">'.$tmpName.'&nbsp;'.$tmpTime.'</span>';
					}else
					{
						$tmpDay = $tmpDay.$tmpName.'&nbsp;'.$tmpTime;
					}
				}else
				{
						$tmpDay = $tmpDay.'Volunteer Needed.';
				}

				$tmpDay = $tmpDay.'</td>';
				switch(substr($row['SlotName'],-1))
				{
					case 'a':
						$rowA = $rowA.$tmpDay;
						break;
					case 'b':
						$rowB = $rowB.$tmpDay;
						break;
					case 'c':
						$rowC = $rowC.$tmpDay;
						break;
					case 'd':
						$rowD = $rowD.$tmpDay;
						break;
					case 'e':
						$rowE = $rowE.$tmpDay;
						break;
				}

		}

	$rowA = $rowA.'</tr>';
	$rowB = $rowB.'</tr>';
	$rowC = $rowC.'</tr>';
	$rowD = $rowD.'</tr>';
	$rowE = $rowE.'</tr>';


	$tmpWeek = $tmpWeek.$rowA.$rowB.$rowC.$rowD.'</table>';
	echo '<h1>Show Nights</h1>';
	echo $tmpWeek;
	echo '<p>On Show Nights: Attire needs to be a white shirt paired with either a black skirt or slacks. This is in keeping with the attire of the student ushers.</p>';
	*/
	echo '</body></html>';
	//mysql_free_result($result);

	mysql_close($link);

?>
