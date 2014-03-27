<?php 
require_once('lib/init.php');
Page::is_admin();

$co = new CharactersOperator();

$characters = $co->fetch_all(true);

Page::parse('list-characters.admin.tpl.php');

$_SESSION['message'] = null;
$_SESSION['exception'] = null;
?>