<?php

	function db_query_array( $query )
	{
		$result = mysql_query( $query );
		if( !$result )
			die( "Invalid query: " . mysql_error() );
		
		$filled_array = array();
		$i = 0;
		
		while( $row = mysql_fetch_assoc($result) )
			$filled_array[$i++] = $row;
		
		return  $filled_array;
	}
	
	function db_query_value( $query )
	{
		$result = mysql_query( $query );
		if( !$result )
			die( "Invalid query: " . mysql_error() );
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	
	function db_print_results( $results )
	{
		print "<pre>";
		if( is_array( $results ) )
			print_r( $results );
		else
			print( $results );
		print "</pre>";
	}
?>