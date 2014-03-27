<?php
require 'lib/init.php';

$ao = new AppearancesOperator();
$co = new CharactersOperator();
$go = new GamesOperator();
$ro = new RolesOperator();

try
{
	$app = $ao->fetch_complete($_GET['id']);
	$is_new = false;
}
catch(Exception $e)
{
	$character = $co->fetch_single($_GET['cid']);
	$is_new = true;
	$_SESSION['exception'] = $e->getMessage().$e->getLine();
}
$games = $go->fetch_all();
$roles = $ro->fetch_all();

Page::parse('edit-appearance.admin.tpl.php');

$_SESSION['exception'] = null;
?>