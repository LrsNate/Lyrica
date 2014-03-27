<section>
<h2><?php echo $GLOBALS['character']->name(); ?></h2>
</section>


<?php if(!empty($_SESSION['message'])) { /* (1) */ ?>
<section>
	<p><?php echo $_SESSION['message']; ?></p>
</section>
<?php } elseif(!empty($_SESSION['exception'])) { /* (1) */ ?>
<section>
	<p class="exception"><?php echo $_SESSION['exception']; ?></p>
</section>
<?php } /* (1) */ ?>


<section>
<h3><a href="edit-appearance.admin.php?cid=<?php echo $GLOBALS['character']->id(); ?>">
	Ajouter une apparition</a></h3>
<table>

<thead>
<tr>
	<th colspan="2">Jeu</th>
	<th rowspan="2">Rôle</th>
	<th rowspan="2">Score</th>
	<th rowspan="2">Bilan</th>
	<th colspan="2" rowspan="2">Actions</th>
</tr>
<tr>
	<th>ID</th>
	<th>Titre</th>
</tr>
</thead>

<tbody>
<?php foreach($GLOBALS['character']->appearances() as $a) { /* (2) */ ?>
<tr>
	<td><?php echo $a->game_id(); ?></td>
	<td><?php echo $a->game_name(); ?></td>
	<td><?php echo $a->role_name(); ?></td>
	<td><?php echo $a->elo(); ?></td>
	<td><?php echo $a->record(); ?></td>
	<td><a href="edit-appearance.admin.php?id=<?php echo $a->id(); ?>">
		Modifier</a></td>
	<td><a href="exec/delete-appearance.admin.php?id=<?php echo $a->id(); ?>&cid=<?php echo $a->character_id(); ?>">
		Supprimer</a></td>
</tr>
<?php } /* (2) */ ?>
</tbody>

</table>
</section>