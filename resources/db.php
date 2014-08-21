<?php # Database Connect

class Database {
	
	// Credentials
	public static $host = "sql2.freemysqlhosting.net";
	public static $user = "sql250215";
	public static $pass = "eW4!xP7!";
	public static $db = "sql250215";
	public static $con = NULL;
	
	private function __construct(){
	}
	
	public static function connection() {
		if (!self::$con) {
		self::$con = new mysqli(self::$_dbHost, self::$user, self::$pass, self::$db);

		if (self::$con -> connect_error) {
			die('Connect Error: ' . self::$con->connect_error);
			}
		}
		return self::$con;
	}
}
?>