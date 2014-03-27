<?php
class PDO2
{
	public static function connect()
	{

		$user    = 'root';
		$pass    = '';
		$host    = 'localhost';
		$db_name = 'lyrica';
		
		$pdo = new PDO('mysql:host='.$host.';dbname='.$db_name, $user, $pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
		$pdo->query('SET NAMES UTF8');
		return $pdo;
	}
}
?>
