<?php
class User extends AppModel
{
	private $name;
	private $password;
	private $user_hash;
	
	public function set_name($value)
	{
		$this->name = $value;
	}
	
	public function set_password($value)
	{
		$this->password = $value;
	}
	
	public function set_user_hash($value)
	{
		$this->user_hash = $value;
	}

	public function name() { return $this->name; }
	public function password() { return $this->password; }
	public function user_hash() { return $this->user_hash; }
}
?>