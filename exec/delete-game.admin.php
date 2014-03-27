<?php 
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_admin();

$go = new GamesOperator();

$go->delete($_GET['id']);

$_SESSION['message'] = "Jeu supprimé avec succès !";
header('../list-games.admin.php');
?>