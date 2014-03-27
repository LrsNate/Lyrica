<?php
class Page
{
	public static function appearance_to_html($array)
{
	$a = '<ul class="first_level">';
	
	for ($i = 0, $c = count($array) ; $i < $c ; $i++)
	{
		$current = $array[$i];
		if(isset($array[$i-1]))
		{
			$previous = $array[$i-1];
			
			if($previous->game_id() == $current->game_id())
			{
				 $a .= '<li>'.$current->role_name().'</li>';
			}
			else
			{
				$a .= '</ul><li>Touhou '.$current->game_id().' : '.$current->game_name().'</li>';
				$a .= '<ul class="second_level"><li>'.$current->role_name().'</li>';
			}
		}
		else
		{
			$a .= '<li>Touhou '.$current->game_id().' : '.$current->game_name().'</li>';
			$a .= '<ul class="second_level"><li>'.$current->role_name().'</li>';
		}
	}
	
	return $a.'</ul></ul>';
}

	public static function is_admin()
	{
		if(!LOGGED)
		{
			if(IS_EXEC)
			{
				header('Location: ../index.php');
			}
			else
			{
				header('Location: index.php');
			}
		}
	}
	
	public static function is_posting()
	{
		if(empty($_POST))
		{
			if(IS_EXEC)
			{
				header('Location: ../index.php');
			}
			else
			{
				header('Location: index.php');
			}
		}
	}
	
	public static function parse($referer)
	{
		ob_get_clean();
		include 'templates/layout/header.php';
		include 'templates/'.$referer;
		include 'templates/layout/footer.php';
	}
}
?>