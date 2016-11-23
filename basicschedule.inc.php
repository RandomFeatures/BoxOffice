<?php

function AddSchedule($UserID, $TableWidth)
{
	
	$retval = '<h2>Box Office Schedule</h2>';
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
		  	. ' ORDER BY slots.`ID`'
		    . ' LIMIT 0, 50 ;';
		$result = mysql_query($sql);

		if($SlotWeek == 1)
			$tmpWeek ='<table width="'.$TableWidth.'" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Monday, Jan 12th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Tuesday, Jan 13th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Wednesday, Jan 14th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Jan 15th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Jan 16th</td>'
					.'</tr>';
		else
			$tmpWeek ='<table width="'.$TableWidth.'" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Monday, Jan 19th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Tuesday, Jan 20th</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Wednesday, Jan 21st</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Jan 22nd</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Jan 23rd</td>'
					.'</tr>';

		$rowA = '<tr class="am">';
		$rowB = '<tr class="am">';
		$rowBC = '<tr class="ln">';
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
				if($row['SlotTime'] == 'pm')
					$tmpTime = '12:30pm - 3:30pm';
				if($row['SlotTime'] == 'ln')
					$tmpTime = '10:16pm - 12:41pm';

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
				case 'e':
					$rowBC = $rowBC.$tmpDay;
					break;
			}

		}

		$rowA = $rowA.'</tr>';
		$rowB = $rowB.'</tr>';
		$rowBC = $rowBC.'</tr>';
		$rowC = $rowC.'</tr>';
		$rowD = $rowD.'</tr>';


		$tmpWeek = $tmpWeek.$rowA.$rowB.$rowBC.$rowC.$rowD.'</table>';

		
		$retval .= '<h1>Week '.$SlotWeek.'</h1>';
		$retval .=  $tmpWeek.'<br />';
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

		$tmpWeek ='<table width="'.$TableWidth.'" border=1 cellspacing="2">'
					.'<tr>'
					.'	<td style="font-size:14px;font-weight:bold;">Thursday, Jan 22nd</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Friday, Jan 23rd</td>'
					.'	<td style="font-size:14px;font-weight:bold;">Saturday, Jan 24th</td>'
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
							$tmpTime = '6:00pm&nbsp;-&nbsp;Show&nbsp;Start';
						else
							$tmpTime = '6:00pm&nbsp;-&nbsp;Intermission';
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
	$retval .= '<h1>Show Nights</h1>';
	$retval .= $tmpWeek;
	$retval .= '<p>On Show Nights: Attire needs to be a white shirt paired with either a black skirt or slacks. This is in keeping with the attire of the student ushers.</p>';
	
	mysql_free_result($result);
	
	return $retval;
}


?>
