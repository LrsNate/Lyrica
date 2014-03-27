<?php 
class Appearance extends AppModel
{
	protected $game_id;
	protected $game_name;
	protected $character_id;
	protected $character_name;
	protected $role_id;
	protected $role_name;
	protected $wins;
	protected $draws;
	protected $losses;
	protected $matches;
	protected $elo;
	protected $veteran;
	
	public function __construct($array)
	{
		parent::__construct($array);
		$this->matches = $this->wins + $this->losses + $this->draws;
	}
	
	public function set_game_id($value)
	{
		$this->game_id = $value;
	}
	
	public function set_game_name($value)
	{
		$this->game_name = $value; 
	}
	
	public function set_character_id($value)
	{
		$this->character_id = $value;
	}
	
	public function set_character_name($value)
	{
		$this->character_name = $value;
	}
	
	public function set_role_id($value)
	{
		$this->role_id = $value;
	}
	
	public function set_role_name($value)
	{
		$this->role_name = $value;
	}
	
	public function set_wins($value)
	{
		$this->wins = $value;
	}
	
	public function set_draws($value)
	{
		$this->draws = $value;
	}
	
	public function set_losses($value)
	{
		$this->losses = $value;
	}
	
	public function set_elo($value)
	{
		$this->elo = $value;
	}
	
	public function set_veteran($value)
	{
		$this->veteran = $value;
	}
	
	public function update_elo($opponent_elo, $result)
	{
		// p(D) (Probabilité de victoire)
		$d = - $this->elo + $opponent_elo; // Différence (.-1 pour faciliter le calcul de p)
		$p = 1 / (1 + pow(10, $d / 400)); 
		
		// k (Coefficient de développement)
		if($this->matches < 30)
		{
			$k = 30;
		}
		elseif(!$this->veteran)
		{
			$k = 15;
		}
		else
		{
			$k = 10;
		}
		
		// Nouveau score
		$this->elo = round($this->elo + $k * ($result - $p));
		
		// Mise à jour du compteur de matches
		switch($result)
		{
			case MatchesOperator::WIN : $this->wins++; break;
			case MatchesOperator::DRAW : $this->draws++; break;
			case MatchesOperator::LOSS : $this->losses++; break;
		}
		
		// Promotion éventuelle
		if($this->elo >= 2400)
		{
			$this->veteran = 1;
		}
	}
	
	public function game_id() { return $this->game_id; }
	public function game_name() { return $this->game_name; }
	public function character_id() { return $this->character_id; }
	public function character_name() { return $this->character_name; }
	public function role_id() { return $this->role_id; }
	public function role_name() { return $this->role_name; }
	public function wins() { return $this->wins; }
	public function draws() { return $this->draws; }
	public function losses() { return $this->losses; }
	public function elo() { return $this->elo; }
	public function veteran() { return $this->veteran; }
	
	public function record()
	{
		return $this->wins.'-'.$this->draws.'-'.$this->losses;
	}
}
?>