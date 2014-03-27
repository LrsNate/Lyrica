<?php 
if($GLOBALS['is_new'])
{
	$id = '';
	$n_val = '';
	$i_val = '';
}
else
{
	$id = '<input type="hidden" name="id" value="'.$GLOBALS['character']->id().'"';
	$n_val = 'value="'.$GLOBALS['character']->name().'"';
	$i_val = 'value="'.$GLOBALS['character']->image().'"';
}
?>
<?php if(!empty($_SESSION['exception'])) { ?>
<section>
	<p><?php echo $_SESSION['exception']; ?></p>
</section>
<?php } ?>

<section>
<form method="post" action="exec/save-character.admin.php">
<?php echo $id; ?>
<p>
	<label for="name">Nom : </label>
	<input type="text" name="name" id="name" <?php echo $n_val; ?> />
</p>

<p>
	<label for="image">Adresse de l'image : </label>
	<input type="text" name="image" id="image" <?php echo $i_val; ?> />
</p>

<?php if(!$GLOBALS['is_new']) { ?>
<input type="hidden" name="veteran" value="<?php echo $GLOBALS['character']->veteran(); ?>" />
<input type="hidden" name="elo" value="<?php echo $GLOBALS['character']->elo(); ?>" />
<input type="hidden" name="wins" value="<?php echo $GLOBALS['character']->wins(); ?>" />
<input type="hidden" name="draws" value="<?php echo $GLOBALS['character']->draws(); ?>" />
<input type="hidden" name="losses" value="<?php echo $GLOBALS['character']->losses(); ?>" />
<?php } ?>

<p>
	<input type="submit" value="Valider" />
</p>
</form>
</section>