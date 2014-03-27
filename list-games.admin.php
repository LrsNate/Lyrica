<?php
require 'lib/init.php';
Page::is_admin();

$go = new GamesOperator();
$games = $go->fetch_all();

Page::parse('list-games.admin.tpl.php');

$_SESSION['message'] = null;
$_SESSION['exception'] = null;
?>