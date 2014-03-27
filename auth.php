<?php
require_once 'lib/init.php';

Page::parse('auth.tpl.php');
$_SESSION['exception'] = null;
?>