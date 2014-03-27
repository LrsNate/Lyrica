<?php 
require 'lib/init.php';
Page::is_admin();

$go = new GamesOperator();

try
{
	$game = $go->fetch_single($_GET['id']);
	$is_new = false;
}
catch(Exception $e)
{
	$is_new = true;
}

Page::parse('edit-game.admin.tpl.php');

$_SESSION['exception'] = null;
?>