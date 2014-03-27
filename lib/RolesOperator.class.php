<?php
class RolesOperator extends AppOperator
{
	public function fetch_all()
	{
		$roles = array();
		
		$query = "SELECT * FROM roles";
		$pst = $this->pdo->query($query);
		while($sql = $pst->fetch(PDO::FETCH_ASSOC))
		{
			$roles[] = new Role($sql);
		}
		return $roles;
	}
}
?>