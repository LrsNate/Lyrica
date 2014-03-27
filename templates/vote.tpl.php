<table id="vote"><tr>
<td id="left_character" class="character">
<form action="exec/vote.php" method="post" id="first">
	<input type="hidden" name="w_id" value="<?php echo $GLOBALS['c1']->id(); ?>" />
	<input type="hidden" name="l_id" value="<?php echo $GLOBALS['c2']->id(); ?>" />
	<input type="hidden" name="draw" value="false" />

	<p class="character_name"><?php echo $GLOBALS['c1']->name(); ?></p>
	<img src="<?php echo $GLOBALS['c1']->image(); ?>" class="character_image" alt="Voter !" />
</form>
</td>

<td id="tie" class="character">
<form action="exec/vote.php" method="post" id="draw">
	<input type="hidden" name="w_id" value="<?php echo $GLOBALS['c2']->id(); ?>" />
	<input type="hidden" name="l_id" value="<?php echo $GLOBALS['c1']->id(); ?>" />
	<input type="hidden" name="draw" value="true" />
	<p id="draw_link">Blanc</p>
</form>
	<p><a href="vote.php">Je m'abstiens</a></p>
</td>

<td id="right_character" class="character">
<form action="exec/vote.php" method="post">
	<input type="hidden" name="w_id" value="<?php echo $GLOBALS['c2']->id(); ?>" />
	<input type="hidden" name="l_id" value="<?php echo $GLOBALS['c1']->id(); ?>" />
	<input type="hidden" name="draw" value="false" />

	<p class="character_name"><?php echo $GLOBALS['c2']->name(); ?></p>
	<img src="<?php echo $GLOBALS['c2']->image(); ?>" class="character_image" alt="Voter !" />
</form>
</td>
</tr></table>
<script>
// Apparitions
var l_cell = document.getElementById('left_character');
var mid_cell = document.getElementById('tie');
var r_cell = document.getElementById('right_character');

var default_content = mid_cell.innerHTML;
var la = '<p><?php echo $GLOBALS['c1']->name(); ?></p><?php echo Page::appearance_to_html($GLOBALS['c1']->appearances()); ?>';
			
var ra = '<p><?php echo $GLOBALS['c2']->name(); ?></p><?php echo Page::appearance_to_html($GLOBALS['c2']->appearances()); ?>';

l_cell.onmouseover = function () 
{
	mid_cell.innerHTML = la;
};

r_cell.onmouseover = function () 
{
	mid_cell.innerHTML = ra;
};

l_cell.onmouseout = function () 
{
	mid_cell.innerHTML = default_content;
};

r_cell.onmouseout = function () 
{
	mid_cell.innerHTML = default_content;
};

// Triggers
var triggers = document.querySelectorAll('form img');

for (var i = 0, c = triggers.length ; i < c ; i++ )
{
	triggers[i].onclick = function(e)
	{
		e.target.parentNode.submit();
	};
}

var tie = document.getElementById('draw_link');

tie.onclick = function() 
{
	document.getElementById('draw').submit();
};
</script>