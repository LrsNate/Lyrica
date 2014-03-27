<?php
define('IS_EXEC', true);
require_once '../lib/init.php';
Page::is_admin();

$co = new CharactersOperator();

try
{
	$co->save(new Character($_POST));
	if(isset($_POST['id']))
	{
		$_SESSION['message'] = "Personnage modifié avec succès !";
	}
	else
	{
		$_SESSION['message'] = "Personnage ajouté avec succès !";
	}
	header('Location: ../list-characters.admin.php');
}
catch(Exception $e)
{
	$_SESSION['exception'] = $e->getMessage();
	header('Location: ../edit-character.admin.php?id='.$_POST['id']);
}
?>