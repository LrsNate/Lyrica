<?php
abstract class AppOperator
{
	protected $pdo;
	
	public function __construct()
	{
		$this->pdo = PDO2::connect();
	}
}
?>