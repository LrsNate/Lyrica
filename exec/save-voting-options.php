<?php
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_posting();

$mo = new MatchesOperator();

$mo->save_voting_options();
$_SESSION['message'] = "Paramètres sauvegardés !";

header('Location: ../voting-options.php')
?>