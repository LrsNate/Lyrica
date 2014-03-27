<section>
<h1>Options de vote</h1>

<p>Sélectionnez ici les jeux desquels seront tirés au sort les personnages : en excluant les Touhou que vous ne connaissez pas, vous
évitez ainsi de tomber sur des personnages dont vous n'avez jamais entendu parler. Et du coup non seulement pour vous c'est plus 
amusant de voter pour des filles que vous reconnaissez et vous pouvez donc laisser votre âme de <em>touhoufag</em> s'exprimer en toute liberté, 
mais pour le site ça permet aussi de rendre le classement plus réaliste en limitant la proportion de gens qui votent au hasard. 
Alors faites bien attention à vos réglages :3</p>
</section>

<?php if (!empty($_SESSION['message'])) { ?>
<section>
	<p><?php echo $_SESSION['message']; ?></p>
</section>
<?php } ?>

<section>
<table>
<form action="exec/save-voting-options.php" method="post">
<?php foreach($GLOBALS['games'] as $g) { ?>
<?php
if(in_array($g->id(), $_SESSION['excluded_games'])) 
{
	$val ="true";
	$image = "templates/images/options/SwitchOFF.png";
	$alt = "switch : OFF";
}
else 
{
	$val = "false";
	$image = "templates/images/options/SwitchON.png";
	$alt = "switch : ON";
}
?>
<tr>
	<input type="hidden" id="<?php echo 'h'.$g->id(); ?>" name="<?php echo $g->id(); ?>" value="<?php echo $val; ?>" />
	<td><?php echo $g->name().' ('.$g->id().')'; ?></td>
	<td><img class="switch" id="<?php echo 'i'.$g->id(); ?>" alt="<?php echo $alt; ?>" src="<?php echo $image; ?>" onclick="switch_game(<?php echo $g->id(); ?>)" /></td>
</tr>
<?php } ?>
<tr>
	<td colspan="2">
		<input type="checkbox" name="remember" id="remember" />
		<label for="remember">Se souvenir de mes paramètres</label>
	</td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Sauvegarder" /></td>
</tr>
</form>
</table>
</section>

<script>
function switch_game(jeu)
{
    var image = document.getElementById('i' + jeu);
	var hidden = document.getElementById('h' + jeu);
	var games = document.querySelectorAll('input[type="hidden"]');
    var accumulator = 0;
    
    // On compte les jeux encore inclus
    for (var i = 0, c = games.length ; i < c ; i++)
    {
        if (games[i].value === "false")
        {
            accumulator++;
        }
    }
    
    // Donc : si l'action consiste à exclure un jeu et que c'est le seul encore inclus, erreur
    if (accumulator == 1 && hidden.value === "false")
    {
        alert('Vous ne pouvez pas exclure tous les jeux !');
    }
    
    // Sinon, application des nouveaux paramètres
    else
    {
        if (hidden.value === "false")
        {
            hidden.value = "true";
            image.src = "templates/images/options/SwitchOFF.png";
        }
        else
        {
            hidden.value = "false";
            image.src = "templates/images/options/SwitchON.png";
        }
    }
}
</script>