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
<h3><a href="edit-character.admin.php">Ajouter un personnage</a></h3>
<table>

<thead>
<tr>
	<th>Nom</th>
	<th>Classement</th>
	<th>Bilan</th>
	<th colspan="3">Actions</th>
</tr>
</thead>

<tbody>
<?php foreach($GLOBALS['characters'] as $c) { /* (2) */ ?>
<tr>
	<td><?php echo $c->name(); ?></td>
	<td><?php echo $c->elo(); ?></td>
	<td><?php echo $c->record(); ?></td>
	<td><a href="list-appearances.admin.php?id=<?php echo $c->id(); ?>">
		Apparitions</a></td>
	<td><a href="edit-character.admin.php?id=<?php echo $c->id(); ?>">
		Modifier</a></td>
	<td><a href="exec/delete-character.php?id=<?php echo $c->id(); ?>">
		Supprimer</a></td>
</tr>
<?php } /* (2) */ ?>
</tbody>

</table>
</section>