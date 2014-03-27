<?php
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_admin();

$co = new CharactersOperator();

$co->delete($_GET['id']);
$_SESSION['message'] = "Personnage supprimé avec succès !";
header('list-characters.admin.php');
?>