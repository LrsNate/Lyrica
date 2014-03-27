<?php
class Character extends AppModel
{
	private $name;
	private $elo;
	private $appearances = array();
	private $matches;
	private $wins;
	private $draws;
	private $losses;
	private $veteran;
	private $image;
	
	const NAME_MISSING = "Nom du personnage manquant.";
	const IMAGE_MISSING = "Adresse de l'image manquante.";
	const APPEARANCES_MISSING = "Apparitions non-invocables ; erreur d'instanciation.";
	
	public function __construct($array)
	{
		parent::__construct($array);
		$this->matches = $this->wins + $this->draws + $this->losses;
	}
	
	// Updaters
	
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
	
	// Initial setters
	
	public function set_name($value)
	{
		if(empty($value) or !is_string($value))
		{
			throw new Exception(self::NAME_MISSING);
		}
		else
		{
			$this->name = $value;
		}
	}
	
	public function set_elo($value)
	{
		$this->elo = $value;
	}
	
	public function set_wins($value)
	{
		$this->wins = $value;
	}
	
	public function set_draws($value)
	{
		$this->draws = $value;
	}
	
	public function set_veteran($value)
	{
		$this->veteran = $value;
	}
	
	public function set_losses($value)
	{
		$this->losses = $value;
	}
	
	public function set_appearances($value)
	{
		$this->appearances = $value;
	}
	
	public function set_image($value)
	{
		if(empty($value) or !is_string($value))
		{
			throw new Exception(self::IMAGE_MISSING);
		}
		else
		{
			$this->image = $value;
		}
	}
	
	// Getters
	
	public function id() { return $this->id; }
	public function name() { return $this->name; }
	public function elo() { return $this->elo; }
	public function wins() { return $this->wins; }
	public function draws() { return $this->draws; }
	public function losses() { return $this->losses; }
	public function image() { return $this->image; }
	public function appearances() { return $this->appearances; }
	public function veteran() { return $this->veteran; }
	
	public function record()
	{
		return $this->wins.'-'.$this->draws.'-'.$this->losses;
	}
}
?>