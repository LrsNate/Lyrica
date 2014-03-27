<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="templates/design/default.css" />
  <title>Touhou PRS</title>
</head>

<body>
<div id="all">

<header>
<?php if(LOGGED) {  ?>
  <p>Connecté : <?php echo $GLOBALS['user']->name(); ?> - <a href="exec/sign-off.admin.php">Se déconnecter</a></p>
<?php } else { ?>
  <p><a href="auth.php">Se connecter</a></p>
<?php } ?>
</header>

<nav>
<ul id="menu">
  <li><a href="index.php">Index</a></li>
  <li><a href="voting-options.php">Paramètres de vote</a></li>
  <li><a href="vote.php">Voter !</a></li>
<?php if(LOGGED) { ?>
  <li><a href="list-characters.admin.php">Gérer les personnages</a></li>
  <li><a href="list-games.admin.php">Gérer les jeux</a></li>
<?php } ?>
</ul>
</nav>