<?php
class Game extends AppModel
{
	protected $name;
	protected $is_new;
	
	const NAME_MISSING = "Nom du jeu manquant.";
	
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
	
	public function set_is_new($value)
	{
		$this->is_new = $value;
	}
	
	public function name() { return $this->name; }
	public function is_new() { return $this->is_new; }
}
?>