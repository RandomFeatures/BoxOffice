<?php
	
   $link = mysql_connect('mysql.com', 'boxuser', '12345'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_error()); 
	} 
	mysql_select_db('boxoffice'); 

?>
