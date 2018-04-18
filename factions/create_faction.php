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


try {
$bdd = new PDO('mysql:host=localhost;dbname=galanews;charset=utf8', 'root','');
}
catch (Exception $e)
{
	die('Erreur : ' . $e ->getMessage());
}
?>




<!doctype html>
<html lang="fr">
	<head>
  		<meta charset="utf-8">
  		<title> Galanews</title>

 		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>

		<form method="post" action="add_faction.php">
		<input type="text" name="faction_name">
		<input type="text" name="faction_TAG" style="text-transform:uppercase">
		<input type="checkbox" name="is_ingame">
		<input type="text" name="ingame_system_name" style="text-transform:uppercase">					
		</form>

		<h3>Fonctionnement de la demande d'ajout de votre faction</h3>
		<p>votre demande sera envoyer aux admins, qui vont vérifier que vous êtes bien le propriétaire de la faction afin d'éviter toute usurpation d'identité. Une fois cela fait, vous pourrez accéder au tableau de commande de votre faction depuis l'onglet "ma faction" situer dans votre profil.</p>
	</body>
</html>
