<?php
	include_once("include/db_open.php");
	include_once("include/db_tools.php");
	
	print "<p>Movies:<br>";
	$shows = db_query_array( "SELECT* FROM shows" );
	foreach( $shows as $show )
	{
		print $show["name"]." || ".$show["release_date"]." || ".$show["type"]."<br>";
	}
	print "</p>";
	
	$result = db_query_value( "SELECT COUNT(*) FROM shows" );
	print "Number of Movies: " . $result;
	
	include_once("include/db_close.php");
?>