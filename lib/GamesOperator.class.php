<?php
class GamesOperator extends AppOperator
{
	const GAME_NOT_FOUND = "Jeu introuvable.";

	public function add(Game $game)
	{
		$query = "INSERT INTO games SET name = ?, id = ?";

		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $game->name(), PDO::PARAM_STR);
		$pst->bindValue(2, $game->id(), PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}

	public function delete($id)
	{
		$query = "DELETE FROM games WHERE id = ?";

		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $id);
		$pst->execute();
		$pst->closeCursor();
	}

	public function fetch_all()
	{
		$games = array();

		$query = "SELECT * FROM games ORDER BY id ASC";
		$pst = $this->pdo->query($query);

		while($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			$games[] = new Game($sql);
		}

		return $games;
	}

	public function fetch_single($id)
	{
		$query = "SELECT * FROM games WHERE id = ?";
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, (int) $id, PDO::PARAM_INT);
		$pst->execute();

		if($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			return new Game($sql);
		}
		else
		{
			throw new Exception(self::GAME_NOT_FOUND);
		}
	}

	public function save(Game $game)
	{
		$game->is_new() ? $this->add($game) : $this->update($game);
	}

	public function update(Game $game)
	{
		$query = "UPDATE games SET name = ? WHERE id = ?";

		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $game->name(), PDO::PARAM_STR);
		$pst->bindValue(2, $game->id(), PDO::PARAM_INT);
		$pst->execute();
		$pst->closeCursor();
	}
}
?>