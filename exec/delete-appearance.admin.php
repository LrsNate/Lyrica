<?php 
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_admin();

$ao = new AppearancesOperator();
$ao->delete($_GET['id']);
$_SESSION['message'] = "Apparition supprimée avec succès !";

header('../list-characters.php?id='.$_GET['cid']);
?>