<?php
	
   $link = mysql_connect('random-f.startlogicmysql.com', 'boxuser', 'kewl104k'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_error()); 
	} 
	mysql_select_db('boxoffice'); 

?>
