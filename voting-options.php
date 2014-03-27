<?php 
require 'lib/init.php';

$go = new GamesOperator();

$games = $go->fetch_all();

Page::parse('voting-options.tpl.php');
$_SESSION['messages'] = null;
?>