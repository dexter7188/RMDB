<?php
	define( "DB_HOST", "localhost" );
	define( "DB_USER", "root" );
	define( "DB_PASSWORD", "" );
	define( "DB_DATABASE", "rmdb" );
	$db_handle;
	$db_is_open = false;
	
	function db_open()
	{
		global $db_is_open, $db_handle;
		
		if( $db_is_open )
			return;
		
		$db_handle = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if( !$db_handle )
			die( "Failed to connect to database: " . mysql_error() );
			
		mysql_select_db(DB_DATABASE, $db_handle);
		$db_is_open = true;
	}
	
	function db_close()
	{
		global $db_is_open, $db_handle;
		mysql_close( $db_handle );
		$db_is_open = false;
	}
	
	function db_query_row( $query )
	{
		$result = mysql_query( $query );
		if( !$result )
			die( "Invalid query: " . mysql_error() );
			
		return mysql_fetch_assoc( $result );
	}
	
	function db_query_rows( $query )
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
	
	function db_results_exist( $query )
	{
		$result = mysql_query( $query );
		if( !$result )
			die( "Invalid query: " . mysql_error() );
			
		return mysql_num_rows( $result ) > 0;
	}
	
	function db_print( $results )
	{
		print "<pre>";
		if( is_array( $results ) )
			print_r( $results );
		else
			print( $results );
		print "</pre>";
	}
?>