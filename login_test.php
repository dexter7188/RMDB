<?php
	include_once("include/authenticate.php");
	
	print "<h3>A valid email/password: sxenog@gmail.com/test.</h3>";
	if( Authenticate::has_login_failed() )
		print "Email and/or Password were not valid.";
		
	if( !Authenticate::is_user() )
	{
		print
			'<form method="post" action="login_test.php">'.
			'	Email: <input type="text" name="email">'.
			'	Password: <input type="password" name="password">'.
			'	<input type="submit" value="submit">'.
			'</form>';
	}
	else
	{
		printf( "Logged in as: %s ", Authenticate::get_alias() );
		print ' | <a href="logout.php">Logout</a>';
	}
?>