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


?>



<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title> Galanews</title>

	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<header>
		<div class="navbar">
			<a>profil(soon)</a>
			<a>Mon journal de bord</a>
			<a>Liste des factions</a>
			<a></a>
			<?php
			if($existe == false)
			{
				echo '<a href="profile/inscription.php">connexion/inscription</a>';
			}
			else
			{
				echo '<a href="profile/deconnexion.php">déconnexion</a>';
			}
			?>
		</div>

		<h1> WebSite</h1>
	</header>
	<img src="">
	<?php echo 	'<a href="../factions/faction.php?faction_name='.$reponse.'">ma faction</a>' ?>
</div>
<div>
</div>

</body>
</html>
