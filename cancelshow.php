 <?php 
	session_start($_COOKIE["SessionID"]);
	include_once($_SERVER["DOCUMENT_ROOT"]."/crtc/boxoffice/lib/dbinit.php");
	
	
	if (isset($_SESSION['UserID']))
		$UserID = $_SESSION['UserID'];
	else
	{
		echo '{"error":true}';		
		die();
	}
	
	$SlotID = intval($_POST['slot']);

	$sql = "DELETE FROM `tblUserShow_Xref` WHERE `ID` = $SlotID AND `UserID` = $UserID LIMIT 1;";

	mysql_query($sql);
	
	echo '{"error":false}';
	mysql_close($link);

?> 
