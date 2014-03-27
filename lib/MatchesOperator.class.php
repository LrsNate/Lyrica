<?php
class MatchesOperator extends AppOperator
{
	const WIN = 1;
	const DRAW = 0.5;
	const LOSS = 0;
	
	public function generate_opponents()
	{
		// Determining the conditions according to exclusions
		$length = count($_SESSION['excluded_games']);
		
		switch($length)
		{
			case 1: $condition = 'WHERE game_id != '.$_SESSION['excluded_games'][0]; break;
			
			case 0: $condition = ''; break;
			
			default:
				for ($i = 0; $i < $length ; $i++)
				{
					if ($i == 0)
					{
						$condition = 'WHERE game_id != '.$_SESSION['excluded_games'][$i];
					}
					else
					{
						$condition .= ' AND game_id != '.$_SESSION['excluded_games'][$i];
					}
				}
			break;
		}
		
		// Then fetch two ids
		$query = 
			"SELECT DISTINCT character_id 
			FROM appearances 
			$condition 
			ORDER BY RAND() 
			LIMIT 2";
		
		$pst = $this->pdo->query($query);
		while ($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			$character_id[] = $sql['character_id'];
		}
		
		// And therefore fetch two complete users
		$co = new CharactersOperator();
		foreach($character_id as $id)
		{
			$characters[] = $co->fetch_complete($id);
		}
		
		// That's it ! Return the values.
		return $characters;
	}
	
	public function match($w_id, $l_id, $draw)
	{
		// Intergame ranking
		$co = new CharactersOperator();
		
		$w = $co->fetch_single($w_id);
		$l = $co->fetch_single($l_id);
		
		if(!$draw)
		{
			$w->update_elo($l->elo(), self::WIN);
			$l->update_elo($w->elo(), self::LOSS);
		}
		else
		{
			$w->update_elo($l->elo(), self::DRAW);
			$l->update_elo($w->elo(), self::DRAW);
		}
		
		$co->save($w);
		$co->save($l);
		
		// Internal ranking
		
		$ao = new AppearancesOperator();
		$w_app = array();
		$l_app = array();
		$r_app = array();
		
		$query = 
			"SELECT game_id, character_id
			FROM records 
			WHERE character_id = ? 
			OR character_id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $w->id(), PDO::PARAM_INT);
		$pst->bindValue(2, $l->id(), PDO::PARAM_INT);
		$pst->execute();
		
		while($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			if($sql['character_id'] == $w->id())
			{
				$w_app[] = $sql['game_id'];
			}
			else
			{
				$l_app[] = $sql['game_id'];
			}
		}
		
		foreach($w_app as $winner_app)
		{
			foreach($l_app as $loser_app)
			{
				if($winner_app == $loser_app)
				{
					$r_app[] = $winner_app;
				}
			}
		}
		
		foreach($r_app as $game_id)
		{
			$query = 
				"SELECT 
				a.id id, 
				a.game_id game_id, 
				g.name game_name, 
				a.character_id character_id, 
				c.name character_name, 
				a.role_id role_id, 
				r.name role_name, 
				e.elo elo, 
				e.wins wins, 
				e.draws draws, 
				e.losses losses, 
				e.veteran veteran  
				FROM appearances a 
				INNER JOIN games g 
				ON a.game_id = g.id 
				INNER JOIN characters c 
				ON a.character_id = c.id 
				INNER JOIN roles r 
				ON a.role_id = r.id 
				INNER JOIN records e 
				ON e.character_id = a.character_id 
				AND e.game_id = a.game_id 
				WHERE a.game_id = ? 
				AND a.character_id = ?";
			
			$pst = $this->pdo->prepare($query);
			$pst->bindValue(1, $game_id, PDO::PARAM_INT);
			$pst->bindValue(2, $w->id(), PDO::PARAM_INT);
			$pst->execute();
			
			$w_app = new Appearance($pst->fetch(PDO::FETCH_ASSOC));
			
			$pst->bindValue(2, $l->id(), PDO::PARAM_INT);
			$pst->execute();
			
			$l_app = new Appearance($pst->fetch(PDO::FETCH_ASSOC));
			
			$pst->closeCursor();
			
			if(!$draw)
			{
				$w_app->update_elo($l_app->elo(), self::WIN);
				$l_app->update_elo($w_app->elo(), self::LOSS);
			}
			else
			{
				$w_app->update_elo($l_app->elo(), self::DRAW);
				$l_app->update_elo($w_app->elo(), self::DRAW);
			}
			
			$ao->save($w_app);
			$ao->save($l_app);
				
		}
		// register match
		$query = 
			"INSERT INTO matches SET 
			winner_id = ?, 
			loser_id = ?, 
			draw = ?, 
			date_played = NOW()";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $w->id(), PDO::PARAM_INT);
		$pst->bindValue(2, $l->id(), PDO::PARAM_INT);
		$pst->bindValue(3, $draw, PDO::PARAM_INT);
		$pst->execute();
	}
	
	public function save_voting_options()
	{
		// First, reset settings
		$_SESSION['excluded_games'] = array();
		setcookie('excluded_games', null, time() - 42, null, null, false, true);
		
		
		// Then, save games in $_SESSION
		foreach ($_POST as $key => $val)
		{
			if (is_numeric($key) && $val === "true")
			{
				$_SESSION['excluded_games'][] = $key;
			}
		}
		
		// And finally save cookie if needed
		if(isset($_POST['remember']))
		{
			setcookie('excluded_games', serialize($_SESSION['excluded_games']), time() + 3600*365*24, null, null, false, true);
		}
	}
}
?>