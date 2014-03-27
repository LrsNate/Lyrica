<?php 
class AppearancesOperator extends AppOperator
{
	public function add(Appearance $app)
	{
		$query = 
			"INSERT INTO appearances SET 
			game_id = ?, 
			character_id = ?, 
			role_id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $app->game_id(), PDO::PARAM_INT);
		$pst->bindValue(2, $app->character_id(), PDO::PARAM_INT);
		$pst->bindValue(3, $app->role_id(), PDO::PARAM_INT);
		try{ $pst->execute(); } catch(Exception $e) { throw new Exception($e->getMessage()); }
		$pst->closeCursor();
		
		$query = 
			"SELECT COUNT(*) counts 
			FROM records 
			WHERE character_id = ? AND game_id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $app->character_id(), PDO::PARAM_INT);
		$pst->bindValue(2, $app->game_id(), PDO::PARAM_INT);
		$pst->execute();
		$sql = $pst->fetch(PDO::FETCH_ASSOC);
		
		if($sql['counts'] == 0)
		{
			$query = 
				"INSERT INTO records SET 
				character_id = ?, 
				game_id = ?, 
				elo = 1400, 
				wins = 0, 
				draws = 0, 
				losses = 0, 
				veteran = 0";
			
			$pst = $this->pdo->prepare($query);
			$pst->bindValue(1, $app->character_id(), PDO::PARAM_INT);
			$pst->bindValue(2, $app->game_id(), PDO::PARAM_INT);
			$pst->execute();
			$pst->closeCursor();
		}
		
	}
	
	public function delete($id)
	{
		$query = "DELETE FROM appearances WHERE id = ?";
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, (int) $id, PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}
	
	public function fetch_complete($id)
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
			WHERE a.id = :a_id";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(':a_id', $id, PDO::PARAM_INT);
		$pst->execute();
		$sql = $pst->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($sql))
		{
			return new Appearance($sql);
		}
		else
		{
			throw new Exception("Apparition introuvable");
		}
	}

	public function save(Appearance $app)
	{
		$app->is_new() ? $this->add($app) : $this->update($app);
	}
	
	public function update(Appearance $app)
	{
		$query = 
			"UPDATE appearances SET 
			game_id = ?, 
			character_id = ?, 
			role_id = ?
			WHERE id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $app->game_id(), PDO::PARAM_INT);
		$pst->bindValue(2, $app->character_id(), PDO::PARAM_INT);
		$pst->bindValue(3, $app->role_id(), PDO::PARAM_INT);
		$pst->bindValue(4, $app->id(), PDO::PARAM_INT);
		try{ $pst->execute(); } catch(Exception $e) { throw new Exception($e->getMessage()); }
		$pst->closeCursor();
		
		$query = 
			"UPDATE records SET 
			elo = ?, 
			wins = ?, 
			draws = ?, 
			losses = ?, 
			veteran = ? 
			WHERE character_id = ? 
			AND game_id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $app->elo(), PDO::PARAM_INT);
		$pst->bindValue(2, $app->wins(), PDO::PARAM_INT);
		$pst->bindValue(3, $app->draws(), PDO::PARAM_INT);
		$pst->bindValue(4, $app->losses(), PDO::PARAM_INT);
		$pst->bindValue(5, $app->veteran(), PDO::PARAM_INT);
		$pst->bindValue(6, $app->character_id(), PDO::PARAM_INT);
		$pst->bindValue(7, $app->game_id(), PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}
}
?>