<?php
	include_once( "include/authenticate.php" );
	Authenticate::kill_session();
	
	$location = $_SERVER['SERVER_NAME'];
	if( isset( $_SERVER['HTTP_REFERER'] ) )
		$location = $_SERVER['HTTP_REFERER'];
		
	header("Location: $location");
?>