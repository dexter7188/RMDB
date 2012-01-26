<?php
	include_once('include/db_tools.php');
	db_open();

	define( "AUTH_SALT", "0p9o8i7u6y" );
	define( "AUTH_EMAIL_FIELD", "email" );
	define( "AUTH_PASSWORD_FIELD", "password" );
	define( "AUTH_IP_FIELD", "ip_at_login" );
	define( "AUTH_FIELD", "AUTH" );
	
	class Authenticate
	{
		private static $is_user;
		private static $user_id;
		private static $user_alias;
	
		private static function encrypt( $string )
		{
			return sha1( AUTH_SALT . $string . AUTH_SALT );
		}
		
		private static function is_authentic( $email, $password )
		{
			$email = mysql_real_escape_string($email);
			$password = Authenticate::encrypt($password);
			
			$query = "SELECT id FROM users WHERE email='$email' AND password='$password'";
			return db_results_exist( $query );
		}
		
		private static function begin_session( $email )
		{
			$_SESSION[AUTH_FIELD][AUTH_EMAIL_FIELD] = $email;
			$_SESSION[AUTH_FIELD][AUTH_IP_FIELD] = $_SERVER['REMOTE_ADDR'];
		}
		
		private static function is_post_authentic()
		{
			if( isset($_POST[AUTH_EMAIL_FIELD]) && isset($_POST[AUTH_PASSWORD_FIELD]) )
				return Authenticate::is_authentic($_POST[AUTH_EMAIL_FIELD], $_POST[AUTH_PASSWORD_FIELD] );
			return false;
		}
		
		private static function is_session_authentic()
		{
			return isset($_SESSION[AUTH_FIELD]) && $_SESSION[AUTH_FIELD]['ip_at_login'] == $_SERVER['REMOTE_ADDR'];
		}
		
		public static function authenticate_user()
		{
			static $has_been_called = false;
			if( $has_been_called )
				return;
			$has_been_called = true;
			
			session_start();
			$is_post_auth = Authenticate::is_post_authentic();
			$is_session_auth = !$is_post_auth && Authenticate::is_session_authentic();
			
			if( $is_post_auth )
				Authenticate::begin_session( $_POST[AUTH_EMAIL_FIELD] );
			
				
			Authenticate::$is_user = $is_post_auth || $is_session_auth;
			Authenticate::$user_id = "";
			if( Authenticate::$is_user )
			{
				$query = "SELECT id, alias FROM users WHERE email='{$_SESSION[AUTH_FIELD][AUTH_EMAIL_FIELD]}'";
				$result = db_query_row( $query );
				Authenticate::$user_id = $result['id'];
				Authenticate::$user_alias = $result['alias'];
			}
		}
		
		public static function has_login_failed()
		{
			$login_was_attempted = isset($_POST[AUTH_EMAIL_FIELD]) && isset($_POST[AUTH_PASSWORD_FIELD]);
			return !Authenticate::$is_user && $login_was_attempted;
		}
		
		public static function is_user()
		{
			return Authenticate::$is_user;
		}
		
		public static function get_id()
		{
			return Authenticate::$user_id;
		}
		
		public static function get_alias()
		{
			return Authenticate::$user_alias;
		}
		
		public static function kill_session()
		{
			if( !Authenticate::$is_user )
				return;
			session_destroy();
		}
	}
	Authenticate::authenticate_user();
	
?>