<?php
require 'lib/init.php';

$co = new CharactersOperator();
global $character;
global $is_new;
try
{
	$character = $co->fetch_single($_GET['id']);
	$is_new = false;
}
catch(Exception $e)
{
	$is_new = true;
}

Page::parse('edit-character.admin.tpl.php');

$_SESSION['exception'] = null;
?>