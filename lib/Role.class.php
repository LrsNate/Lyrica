<?php
class Role extends AppModel
{
	private $name;
	
	public function set_name($value)
	{
		$this->name = $value;
	}
	
	public function name() { return $this->name; }
}
?>