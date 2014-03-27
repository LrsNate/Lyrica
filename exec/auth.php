<?php
define('IS_EXEC', true);
require_once '../lib/init.php';
Page::is_posting();

$uo = new UsersOperator();
try
{
	$uo->sign_in();
	header('Location: ../index.php');
}
catch(Exception $e)
{
	$_SESSION['exception'] = $e->getMessage();
	header('Location: ../auth.php');
}
?>