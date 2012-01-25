<?php
	$db_host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_database = "rmdb";
	
	$db_link = mysql_connect($db_host, $db_user, $db_password);
	if( !$db_link )
		die( "Failed to connect to database: " . mysql_error() );
		
	mysql_select_db($db_database);
?>