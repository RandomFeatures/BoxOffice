<?php
	session_start($_COOKIE["SessionID"]);
	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
	
	if (isset($_SESSION['UserID']))
	{
		$UserID = $_SESSION['UserID'];
	    $UserName = $_SESSION['UserName'];
	}else 
	{
		$UserID = 0;
		$UserName = '';
	}
	
	


	$sql = 'SELECT showxref.`ID`, showxref.`LeaveEarly`, slots.`ShowDate`, slots.`ShowDay`, slots.`SlotName`, users.`ID` as UserID, users.`FirstName`, users.`LastName`'
        . ' FROM `tblUserShow_Xref` showxref'
        . ' RIGHT JOIN `tblUsers` users'
        . ' ON users.`ID` = showxref.`UserID`'
        . ' RIGHT JOIN `tblShowSlots` slots'
        . ' on slots.`ID` = showxref.`ShowID`'
	  	. ' ORDER BY slots.`SlotName`'
        . ' LIMIT 0, 50;';

	$result = mysql_query($sql);

	$tmpWeek ='<table border=1 cellspacing="0">'
				.'<tr>'
				.'	<td>Thursday, Jan 22nd</td>'
				.'	<td>Friday, Jan 23rd</td>'
				.'	<td>Saturday, Jan 24th</td>'
				.'</tr>';

	$rowA = '<tr>';
	$rowB = '<tr>';
	$rowC = '<tr>';
	$rowD = '<tr>';
	$rowE = '<tr>';
	$tmpDay = '';
	$Day1 = false;
	$Day2 = false;
	$Day3 = false;
	$ShowButton = true;

	$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

	while ($row = mysql_fetch_array($result)) 
	{
			$tmpDay = '<td width="349" height="42"><div id=\''.$row['SlotName'].'\'>';
			if(!is_null($row['UserID']))
			{			
				$tmpID = $row['UserID'];
				$tmpName = $row['FirstName'].'&nbsp;'.substr($row['LastName'],0,1).'.&nbsp;';
				if($row['ShowDay'] == 3)
				{
					if($row['LeaveEarly'] == 1)					
						$tmpTime = '<span style="color:#2444E2">6:00pm&nbsp;-&nbsp;Show&nbsp;Start</span>';
					else
						$tmpTime = '<span style="color:#C423CC">6:00pm&nbsp;-&nbsp;Intermission</span>';
				}
				else
				{
					if($row['LeaveEarly'] == 1)					
						$tmpTime = '<span style="color:#2444E2">6:00pm&nbsp;-&nbsp;Show&nbsp;Start</span>';
					else
						$tmpTime = '<span style="color:#C423CC">6:00pm&nbsp;-&nbsp;Intermission</span>';
				}

				if($tmpID == $UserID)
				{
					$tmpDay = $tmpDay.'<b>'.$tmpName.'&nbsp;'.$tmpTime.'</b>';
					
					if(strtotime($row['ShowDate']) > strtotime(date("Y/m/d", $tomorrow)))
						$tmpDay .= '<br /><a href="#" onClick="cancelshow_OnClick('.$row['ID'].')"><span class="cancel">cancel</span></a>';

					switch($row['ShowDay'])
					{
						case 1:
							$Day1 = true;
							break;
						case 2:
							$Day2 = true;
							break;
						case 3:
							$Day3 = true;
							break;
					}
				}else
				{
					$tmpDay = $tmpDay.$tmpName.'&nbsp;'.$tmpTime;
				}
			}else
			{
				if($Day1 &&  $row['ShowDay'] == 1)
					$ShowButton = false;
				if($Day2 &&  $row['ShowDay'] == 2)
					$ShowButton = false;
				if($Day3 &&  $row['ShowDay'] == 3)
					$ShowButton = false;
				
				if($ShowButton)
				{			
					if($row['ShowDay'] == 3)
						$tmpDay = $tmpDay.'<a href="#" onClick="shownight_onClick('.$row['ShowDay'].',0)" class="blueButton">6:00pm <span class="time">- Intermission</span> shift</a> or <a href="#" onClick="shownight_onClick('.$row['ShowDay'].',1)" class="blueButton">6:00pm -<span class="showstart"> Show Start</span> shift</a>';
					else
						$tmpDay = $tmpDay.'<a href="#" onClick="shownight_onClick('.$row['ShowDay'].',0)" class="blueButton">6:00pm <span class="time">- Intermission</span> shift</a> or  <a href="#" onClick="shownight_onClick('.$row['ShowDay'].',1)" class="blueButton">6:00pm -<span class="showstart"> Show Start</span> shift</a>';
				}else
					$tmpDay = $tmpDay.'Reserved for another volunteer.';
				$ShowButton = true;
			}

			$tmpDay = $tmpDay.'</div></td>';
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

echo $tmpWeek;

mysql_free_result($result);
mysql_close($link);

?>
