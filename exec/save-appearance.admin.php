<?php 
define('IS_EXEC', true);
require_once '../lib/init.php';
Page::is_admin();

$ao = new AppearancesOperator();
$app = new Appearance($_POST);
$ao->save($app);

if(isset($_POST['id']))
{
	$_SESSION['message'] = "Apparition modifiée avec succès !";
}
else
{
	$_SESSION['message'] = "Apparition ajoutée avec succès !";
}

header('Location: ../list-appearances.admin.php?id='.$_POST['character_id']);
?>