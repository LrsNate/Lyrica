<?php
require "lib/init.php";
Page::is_admin();


$co = new CharactersOperator();

try
{
	$GLOBALS['character'] = $co->fetch_complete($_GET['id']);
}
catch(Exception $e)
{
	$_SESSION['exception'] = $e->getMessage();
	header('Location: list-characters.admin.php');
}

Page::parse('list-appearances.admin.tpl.php');

$_SESSION['message'] = null;
$_SESSION['exception'] = null;
?>