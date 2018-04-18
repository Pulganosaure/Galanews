<?php
session_start();
$existe = isset($_SESSION['username']);

if($existe == true)
{
	$user = $_SESSION['username'];
}
else
{
	$user = 'guest';
}


try 
{
	$bdd = new PDO('mysql:host=localhost;dbname=galanews;charset=utf8', 'root','');
}
catch (Exception $e)
{
	die('Erreur : ' . $e ->getMessage());
}



if(isset($_POST['title']) && isset($_POST['contains']))
{
	$bdd->exec('INSERT INTO `logbooks`(`author`, `title`,`Contains`) VALUES ("'.$_SESSION['username'].'", "'.$_POST['title'].'", "'.$_POST['contains'].'") ');
}

?>
