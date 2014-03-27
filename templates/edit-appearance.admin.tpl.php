<section>
<?php if(isset($_SESSION['exception'])) { echo $_SESSION['exception']; } ?>
<form action="exec/save-appearance.admin.php" method="post">
<?php if(!$GLOBALS['is_new']) { /* (1) */ ?>
	<input type="hidden" name="id" value="<?php echo $GLOBALS['app']->id(); ?>" />
<?php } /* (1) */ ?>
<p>
	<label for="character_id">Personnage : </label>
	<?php if(!$GLOBALS['is_new']) { /* (2) */ ?>
		<input type="hidden" name="character_id" value="<?php echo $GLOBALS['app']->character_id(); ?>" />
		<strong><?php echo $GLOBALS['app']->character_name(); ?></strong>
	<?php } else { /* (2) */ ?>
		<input type="hidden" name="character_id" value="<?php echo $GLOBALS['character']->id(); ?>" />
		<strong><?php echo $GLOBALS['character']->name(); ?></strong>
	<?php } /* (2) */ ?>
</p>

<p>
	<label for="game_id">Jeu : </label>
	<select name="game_id" id="game_id">
		<?php foreach($GLOBALS['games'] as $g) { /* (4) */
			if(!$GLOBALS['is_new']) { /* (5) */ 
				$s = ($g->id() == $GLOBALS['app']->game_id() ? ' selected' : ''); 
			} else { /* (5) */
				$s = ''; 
			} /* (5) */ ?>
			<option value=<?php echo '"'.$g->id().'"'.$s; ?>><?php echo $g->name(); ?></option>
		<?php } /* (4) */ ?>
	</select>
</p>

<p>
	<label for="role_id">Rôle : </label>
	<select name="role_id" id="role_id">
		<?php foreach($GLOBALS['roles'] as $r) { /* (6) */
			if(!$GLOBALS['is_new']) { /* (7) */ 
				$s = ($r->id() == $GLOBALS['app']->role_id() ? ' selected' : ''); 
			} else { /* (7) */
				$s = ''; 
			} /* (7) */ ?>
			<option value=<?php echo '"'.$r->id().'"'.$s; ?>><?php echo $r->name(); ?></option>
		<?php } /* (6) */ ?>
	</select>
</p>

<?php if(!$GLOBALS['is_new']) { ?>
<input type="hidden" name="wins" value="<?php echo $GLOBALS['app']->wins(); ?>" />
<?php } ?>

<p>
	<input type="submit" value="Envoyer" />
</p>
</form>
</section>