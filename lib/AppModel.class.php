<?php
abstract class AppModel
{
	protected $id;
	
	public function __construct($array)
	{
		if(!empty($array)) $this->hydrate($array);
	}
		
	protected function hydrate($array)
	{
		foreach($array as $attribute => $value)
		{
			$method = 'set_'.$attribute;
			if(method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}
	
	public function set_id($value)
	{
		$this->id = $value;
	}
	
	public function is_new()
	{
		return empty($this->id);
	}
	
	public function id()
	{
		return $this->id;
	}
}
?>