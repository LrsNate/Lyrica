<?php
define('IS_EXEC', true);
require '../lib/init.php';
Page::is_posting();

$mo = new MatchesOperator();

if($_POST['draw'] == 'true')
{
	$draw = 1;
}
else
{
	$draw = 0;
}

$mo->match($_POST['w_id'], $_POST['l_id'], $draw);

header('Location: ../vote.php');
?>