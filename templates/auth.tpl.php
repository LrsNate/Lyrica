<section>
<h1>Se connecter</h1>
</section>

<?php if(!empty($_SESSION['exception'])) { ?>
<section>
	<p><?php echo $_SESSION['exception']; ?></p>
</section>
<?php } ?>

<section>
<form action="exec/auth.php" method="post">
<p>
	<label for="name">Nom : </label>
	<input type="text" name="name" id="name" />
</p>

<p>
	<label for="password">Mot de passe : </label>
	<input type="password" name="password" id="password" />
</p>
<p>
	<input type="checkbox" name="remember" id="remember" />
	<label for="remember">Se souvenir de moi</label>
</p>
<p>
	<input type="submit" value="Envoyer" />
</p>
</form>
</section>