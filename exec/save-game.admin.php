<?php
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_admin();

$go = new GamesOperator();

try
{
	$go->save(new Game($_POST));
	$_SESSION['message'] = "Jeu ajouté avec succès !";
	header('Location: ../list-games.admin.php');
}
catch(Exception $e)
{
	$_SESSION['exception'] = $e->getMessage();
	header('Location: ../edit-game.admin.php?id='.$_POST['id']);
}
?>