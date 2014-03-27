<?php
require 'lib/init.php';

$mo = new MatchesOperator();

$characters = $mo->generate_opponents();

$c1 = $characters[0];
$c2 = $characters[1];

Page::parse('vote.tpl.php');
?>