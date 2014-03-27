<?php
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_admin();

$uo = new UsersOperator();
$uo->sign_off();

header('Location: ../index.php');
?>