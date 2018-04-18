<?php
require_once "../functions.php";
	$username = $_POST['username'];

if(strlen($_POST['password']) >= 6)
{
		$password = hash("sha256",$_POST['password']);
}
else
{
		header("Location: inscription.php");	
}

connect_to_bdd_galanews();


	$requete = "SELECT COUNT(*) AS NBRE FROM users_list WHERE username LIKE '".$username."'";
	$reponse = $bdd->query($requete)->fetchColumn();
	print_r($reponse);
	if($reponse >=1)
	{
		header("Location: inscription.php");
	}

	else
	{
		//echo "$requete";

		$requete = "INSERT INTO users_list(username, password) value('".$username."','".$password."')";
		$bdd->exec($requete);
		header('Location: connexion.php');
	}
?>