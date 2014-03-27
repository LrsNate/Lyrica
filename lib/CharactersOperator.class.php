<?php 
class CharactersOperator extends AppOperator
{
	const CHARACTER_NOT_FOUND = "Personnage introuvable ; id invalide.";
	
	public function add(Character $character)
	{
		$query = 
			"INSERT INTO characters SET 
			name = ?, 
			elo = 1400, 
			veteran = 0, 
			wins = 0, 
			draws = 0, 
			losses = 0, 
			image = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $character->name(), PDO::PARAM_STR);
		$pst->bindValue(2, $character->image(), PDO::PARAM_STR);
		$pst->execute();
		$pst->closeCursor();
	}
	
	public function delete($id)
	{
		$query = "DELETE FROM characters WHERE id = ?";
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, (int) $id, PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}
	public function fetch_all($admin = false)
	{
		$characters = array();
		$query = "SELECT * FROM characters ORDER BY ";
		$query .= ($admin ? "name ASC" : "elo DESC");
		
		$pst = $this->pdo->query($query);
		
		while($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			$characters[] = new Character($sql);
		}
		
		return $characters;
	}
	
	public function fetch_complete($id)
	{
		$query = "SELECT * FROM characters WHERE id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $id, PDO::PARAM_INT);
		try{$pst->execute();} catch(Exception $e){ throw new Exception($e->getMessage()); }
		
		$sql = $pst->fetch(PDO::FETCH_ASSOC);
		$pst->closeCursor();
		
		if(empty($sql))
		{
			throw new Exception(self::CHARACTER_NOT_FOUND);
		}
		
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
			WHERE a.character_id = ? 
			ORDER BY a.game_id, a.role_id 
			ASC";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $id, PDO::PARAM_INT);
		try{$pst->execute();} catch(Exception $e){ throw new Exception($e->getMessage()); }

		while($return = $pst->fetch(PDO::FETCH_ASSOC))
		{
			$sql['appearances'][] = new Appearance($return);
		}
		return new Character($sql);
	}
	
	public function fetch_single($id)
	{
		$sql_query = "SELECT * FROM characters WHERE id = ?";
		
		$pst = $this->pdo->prepare($sql_query);
		$pst->bindValue(1, (int) $id, PDO::PARAM_INT);
		$pst->execute();
		$sql = $pst->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($sql)) return new Character($sql); else throw new Exception(self::CHARACTER_NOT_FOUND);
	}
	
	public function save(Character $character)
	{
		$character->is_new() ? $this->add($character) : $this->update($character);
	}
	
	public function update(Character $character)
	{
		$query = 
			"UPDATE characters SET 
			name = :name, 
			elo = :elo, 
			veteran = :veteran, 
			image = :image, 
			wins = :wins, 
			draws = :draws, 
			losses = :losses 
			WHERE id = :id";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(':name', $character->name(), PDO::PARAM_STR);
		$pst->bindValue(':elo', $character->elo(), PDO::PARAM_INT);
		$pst->bindValue(':veteran', $character->veteran(), PDO::PARAM_INT);
		$pst->bindValue(':image', $character->image(), PDO::PARAM_STR);
		$pst->bindValue(':wins', $character->wins(), PDO::PARAM_INT);
		$pst->bindValue(':draws', $character->draws(), PDO::PARAM_INT);
		$pst->bindValue(':losses', $character->losses(), PDO::PARAM_INT);
		$pst->bindValue(':id', $character->id(), PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}
}
?>