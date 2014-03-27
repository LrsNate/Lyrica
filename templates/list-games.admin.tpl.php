<?php if(!empty($_SESSION['exception'])) { /* (1) */ ?>
<section>
	<p class="exception"><?php echo $_SESSION['exception']; ?></p>
</section>
<?php } elseif(!empty($_SESSION['message'])) { /* (1) */ ?>
<section>
	<p class="exception"><?php echo $_SESSION['message']; ?></p>
</section>
<?php } /* (1) */ ?>

<section>
<h3><a href="edit-game.admin.php">Ajouter un jeu</a></h3>
<table>
<thead>
<tr>
	<td>ID</td>
	<td>Titre</td>
	<td colspan="2">Actions</td>
</tr>
</thead>

<tbody>
<?php foreach($GLOBALS['games'] as $g) { /* (2) */ ?>
<tr>
	<td><?php echo $g->id(); ?></td>
	<td><?php echo $g->name(); ?></td>
	<td><a href="edit-game.admin.php?id=<?php echo $g->id(); ?>">
		Modifier</a></td>
	<td><a href="exec/delete-game.php?id=<?php echo $g->id(); ?>">
		Supprimer</a></td>	
</tr>
<?php } /* (2) */ ?>
</tbody>
</table>
</section>