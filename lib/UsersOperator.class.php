<?php
class UsersOperator extends AppOperator
{	
	public function fetch_single($id)
	{
		$query = "SELECT * FROM users WHERE id = ?";
		
		$pst = $this->pdo->prepare($query);
		$pst->bindValue(1, $id, PDO::PARAM_INT);
		$pst->execute();
		
		return new User($pst->fetch(PDO::FETCH_ASSOC));
	}
	public function is_user($id, $user_hash)
	{
		$sql_query = 
			"SELECT COUNT(id) AS counts
			FROM users
			WHERE id=:id AND user_hash=:user_hash";
			
		$pst = $this->pdo->prepare($sql_query);
		$pst->bindValue(':id', $id);
		$pst->bindValue(':user_hash', $user_hash);
		$pst->execute();
		$sql = $pst->fetch(PDO::FETCH_OBJ);
		return $sql->counts ? true : false;
	}
	public function sign_in()
	{
		try
		{
			$_SESSION['id'] = 
				(int) $this->user_exists($_POST['name'], $_POST['password']);
			$user = new User($_SESSION['id']);	
			if(isset($_POST['remember']))
			{
				setcookie('id', $user->id(),
						  $this->cookie_expires,
						  null, null, false, true);
				setcookie('user_hash', $user->user_hash(),
						  $this->cookie_expires,
						  null, null, false, true);
			}
		}
		catch(Exception $e)
		{
			throw new Exception("Erreur d'authentification");
		}
	}
	public function sign_off()
	{
		$_SESSION['id'] = null;
		setcookie('id', null, 5, null, null, false, true);
		setcookie('user_hash', null, 5, null, null, false, true);
		if (ini_get("session.use_cookies")) 
		{
			$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        				$params["path"], $params["domain"],
        				$params["secure"], $params["httponly"]
    				);
		}
	}
		public function user_exists($name, $password)
	{
		$sql_query = 
			"SELECT id
			FROM users
			WHERE name=:name AND password=:password";
		
		$pst = $this->pdo->prepare($sql_query);
		$pst->bindValue(':name', $name);
		$pst->bindValue(':password', md5($password));
		$pst->execute();
		if($sql = $pst->fetch(PDO::FETCH_OBJ))
		{
			return $sql->id;
		}
		else
		{
			throw new Exception("Echec de l'authentification");
		}	
	}

}
?>