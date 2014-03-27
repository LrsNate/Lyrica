<?php
ob_start();

header('Content-Type: text/html; charset=utf-8'); 

function load_class($class)
{
	if(defined('IS_EXEC'))
	{
		require_once '../lib/'.$class.'.class.php';
	}
	else
	{
		require_once 'lib/'.$class.'.class.php';
	}
}

spl_autoload_register('load_class');

session_start();

function stripslashes_r($var)
{
        if(is_array($var))
        {
                return array_map('stripslashes_r', $var);
        }
        else
        {
                return stripslashes($var);
        }
}
 
if(get_magic_quotes_gpc())
{
   $_GET = stripslashes_r($_GET);
   $_POST = stripslashes_r($_POST);
   $_COOKIE = stripslashes_r($_COOKIE);
}

$uo = new UsersOperator();

if(isset($_COOKIE['id']) && isset($_COOKIE['user_hash']))
{
	if($uo->is_user($_COOKIE['id'], $_COOKIE['user_hash']))
	{
		$_SESSION['id'] = $_COOKIE['id'];
	}
}

if(isset($_SESSION['id']))
{
	$GLOBALS['user'] = $uo->fetch_single($_SESSION['id']);
	define('LOGGED', true);
}
else
{
	define('LOGGED', false);
}

if(isset($_COOKIE['excluded_games']))
{
	$_SESSION['excluded_games'] = unserialize($_COOKIE['excluded_games']);
}

if(!isset($_SESSION['excluded_games']))
{
	$_SESSION['excluded_games'] = array();
}

?>
