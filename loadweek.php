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
	
	$SlotWeek = intval($_POST['week']);


	$sql = 'SELECT slotxref.`ID`, slots.`SlotDay`, slots.`SlotTime`, slots.`SlotDate`, slots.`SlotName`, users.`ID` as UserID, users.`FirstName`, users.`LastName`'
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
		$tmpWeek ='<table border=1 cellspacing="0">'
				.'<tr>'
				.'	<td>Monday, Jan 12th</td>'
				.'	<td>Tuesday, Jan 13th</td>'
				.'	<td>Wednesday, Jan 14th</td>'
				.'	<td>Thursday, Jan 15th</td>'
				.'	<td>Friday, Jan 16th</td>'
				.'</tr>';
	else
		$tmpWeek ='<table border=1 cellspacing="0">'
				.'<tr>'
				.'	<td>Monday, Jan 19th</td>'
				.'	<td>Tuesday, Jan 20th</td>'
				.'	<td>Wednesday, Jan 21st</td>'
				.'	<td>Thursday, Jan 22nd</td>'
				.'	<td>Friday, Jan 23rd</td>'
				.'</tr>';

	$rowA = '<tr class="am">';
	$rowB = '<tr class="am">';
	$rowBC = '<tr class="ln">';
	$rowC = '<tr class="pm">';
	$rowD = '<tr class="pm">';
	$tmpDay = '';
	$ShowButton = true;
	$Day1am = false;
	$Day1pm = false;
	$Day2am = false;
	$Day2pm = false;
	$Day3am = false;
	$Day3pm = false;
	$Day4am = false;
	$Day4pm = false;
	$Day5am = false;
	$Day5pm = false;
	
	$Day1ln = false;
	$Day2ln = false;
	$Day3ln = false;
	$Day4ln = false;
	$Day5ln = false;


	$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

	while ($row = mysql_fetch_array($result)) 
	{
		if($row['UserID'] == $UserID)
		{
			//clear secondary slots to prevent me from doing more
			if($row['SlotDay'] == 1 && $row['SlotTime'] == 'am')
				$Day1am = true;
			if($row['SlotDay'] == 1 && $row['SlotTime'] == 'pm')
				$Day1pm = true;
			if($row['SlotDay'] == 2 && $row['SlotTime'] == 'am')
				$Day2am = true;
			if($row['SlotDay'] == 2 && $row['SlotTime'] == 'pm')
				$Day2pm = true;
			if($row['SlotDay'] == 3 && $row['SlotTime'] == 'am')
				$Day3am = true;
			if($row['SlotDay'] == 3 && $row['SlotTime'] == 'pm')
				$Day3pm = true;
			if($row['SlotDay'] == 4 && $row['SlotTime'] == 'am')
				$Day4am = true;
			if($row['SlotDay'] == 4 && $row['SlotTime'] == 'pm')
				$Day4pm = true;
			if($row['SlotDay'] == 5 && $row['SlotTime'] == 'am')
				$Day5am = true;
			if($row['SlotDay'] == 5 && $row['SlotTime'] == 'pm')
				$Day5pm = true;

			if($row['SlotDay'] == 1 && $row['SlotTime'] == 'ln')
				$Day1ln = true;
			if($row['SlotDay'] == 2 && $row['SlotTime'] == 'ln')
				$Day2ln = true;
			if($row['SlotDay'] == 3 && $row['SlotTime'] == 'ln')
				$Day3ln = true;
			if($row['SlotDay'] == 4 && $row['SlotTime'] == 'ln')
				$Day4ln = true;
			if($row['SlotDay'] == 5 && $row['SlotTime'] == 'ln')
				$Day5ln = true;
		}
	}

	mysql_data_seek($result, 0);
	while ($row = mysql_fetch_array($result)) 
	{
			$tmpDay = '<td><div id=\''.$row['SlotName'].'\'>';
			if(!is_null($row['UserID']))
			{ //User Assigned to this one			
				$tmpID = $row['UserID'];
				$tmpName = $row['FirstName'].' '.substr($row['LastName'],0,1).'.';
				
				if($row['SlotTime'] == 'am')
					$tmpTime = '<span style="color:#C423CC">9:45am - 12:30pm</span>';
				if($row['SlotTime'] == 'pm')
					$tmpTime = '<span style="color:#2444E2">12:30pm - 3:15pm</span>';
				if($row['SlotTime'] == 'ln')
					$tmpTime = '<span style="color:#00CC00">10:16am - 12:40pm</span>';

				if($tmpID == $UserID)
				{
					//I am assigned to this one

					$tmpDay = $tmpDay.'<b>'.$tmpName.' '.$tmpTime.'</b>';
					
					if(strtotime($row['SlotDate']) > strtotime(date("Y/m/d", $tomorrow)))
						$tmpDay .= '<a href="#" onClick="cancel_OnClick('.$row['ID'].','.$SlotWeek.')"><span class="cancel">cancel</span></a>';
					
				}else
				{
					$tmpDay = $tmpDay.$tmpName.' '.$tmpTime;
				}
			}else
			{
				
				if(($Day1am || $Day1ln) && $row['SlotDay'] == 1 && $row['SlotTime'] == 'am')
					$ShowButton = false;
				if(($Day1pm || $Day1ln) && $row['SlotDay'] == 1 && $row['SlotTime'] == 'pm')
					$ShowButton = false;
				if(($Day1pm || $Day1am) && $row['SlotDay'] == 1 && $row['SlotTime'] == 'ln')
					$ShowButton = false;

				if(($Day2am || $Day2ln) && $row['SlotDay'] == 2 && $row['SlotTime'] == 'am')
					$ShowButton = false;
				if(($Day2pm || $Day2ln) && $row['SlotDay'] == 2 && $row['SlotTime'] == 'pm')
					$ShowButton = false;
				if(($Day2pm || $Day2am) && $row['SlotDay'] == 2 && $row['SlotTime'] == 'ln')
					$ShowButton = false;


				if(($Day3am  || $Day3ln) && $row['SlotDay'] == 3 && $row['SlotTime'] == 'am')
					$ShowButton = false;
				if(($Day3pm || $Day3ln) && $row['SlotDay'] == 3 && $row['SlotTime'] == 'pm')
					$ShowButton = false;
				if(($Day3pm || $Day3am) && $row['SlotDay'] == 3 && $row['SlotTime'] == 'ln')
					$ShowButton = false;

				if(($Day4am || $Day4ln) && $row['SlotDay'] == 4 && $row['SlotTime'] == 'am')
					$ShowButton = false;
				if(($Day4pm || $Day4ln) && $row['SlotDay'] == 4 && $row['SlotTime'] == 'pm')
					$ShowButton = false;
				if(($Day4pm || $Day4am) && $row['SlotDay'] == 4 && $row['SlotTime'] == 'ln')
					$ShowButton = false;

				if(($Day5am || $Day5ln) && $row['SlotDay'] == 5 && $row['SlotTime'] == 'am')
					$ShowButton = false;
				if(($Day5pm || $Day5ln) && $row['SlotDay'] == 5 && $row['SlotTime'] == 'pm')
					$ShowButton = false;
				if(($Day5pm || $Day5am) && $row['SlotDay'] == 5 && $row['SlotTime'] == 'ln')
					$ShowButton = false;

				
				if($ShowButton)
				{				
					if($row['SlotTime'] == 'am')
						$tmpDay = $tmpDay.'<a href="#" onClick="signup_onClick('.$row['SlotDay'].','.$SlotWeek.',\'am\')" class="blueButton"><span class="time">9:45am - 12:30pm</span> shift</a>';
					if($row['SlotTime'] == 'pm')
						$tmpDay = $tmpDay.'<a href="#" onClick="signup_onClick('.$row['SlotDay'].','.$SlotWeek.',\'pm\')" class="blueButton"><span class="time">12:30pm - 3:15pm</span> shift</a>';
					if($row['SlotTime'] == 'ln')
						$tmpDay = $tmpDay.'<a href="#" onClick="signup_onClick('.$row['SlotDay'].','.$SlotWeek.',\'ln\')" class="blueButton"><span class="lunch">10:16am - 12:40pm</span> shift</a>';
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
					$rowBC = $rowBC.$tmpDay;
					break;
			}

	}

$rowA = $rowA.'</tr>';
$rowB = $rowB.'</tr>';
$rowC = $rowC.'</tr>';
$rowD = $rowD.'</tr>';
$rowBC = $rowBC.'</tr>';


$tmpWeek = $tmpWeek.$rowA.$rowB.$rowBC.$rowC.$rowD.'</table>';

echo $tmpWeek;
mysql_free_result($result);
mysql_close($link);
?>
