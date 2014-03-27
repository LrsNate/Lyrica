<?php
if($GLOBALS['is_new'])
{
	$n_val = '';
}
else
{
	$n_val = ' value="'.$GLOBALS['game']->name().'"';
}
?>
<?php if(!empty($_SESSION['exception'])) { ?>
<section>
	<p><?php echo $_SESSION['exception']; ?></p>
</section>
<?php } ?>

<section>
<form method="post" action="exec/save-game.admin.php">
<input type="hidden" name="is_new" value="<?php echo $GLOBALS['is_new']; ?>" />
<p>
	<label for="id">ID du jeu : </label>
	<?php if($GLOBALS['is_new']) { ?>
		<input type="text" name="id" id="id" />
	<?php } else { ?>
		<strong><?php echo $GLOBALS['game']->id(); ?></strong>
	<?php } ?>
</p>

<p>
	<label for="name">Nom du jeu : </label>
	<input type="text" name="name" id="name"<?php echo $n_val; ?> />
</p>

<p>
	<input type="submit" value="Envoyer" />
</p>
</form>
</section>