<?php
require_once "../functions.php";

session_start();
$existe = isset($_SESSION['username']);

if(isset($_SESSION['username']) && $_SESSION['permissions'] >= 1)
{
	$bdd = connect_to_bdd_galanews();


	if(isset($_POST['faction_name']))
	{
		$requete = "SELECT COUNT(*) AS NBRE FROM factions WHERE faction_name LIKE '".$_POST['faction_name']."'";
		$reponse = $bdd->query($requete)->fetchColumn();
		if($reponse != 0)
		{
			$bdd->exec('UPDATE factions SET is_validate = TRUE WHERE faction_name LIKE "'.$_POST['faction_name'].'"');



			$sql = 'CREATE TABLE '.$_POST['faction_name'].' (username VARCHAR(255) NOT NULL, rank int(11) NOT NULL DEFAULT "0",join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)';
			$bdd->exec($sql);
			//$requete = 'INSERT into ' //ajoute du demandeur en tant que admin de la faction
		}
	}
	unset($_POST);
}
else
{
	header('Location: ../main.php');
}



?>



<!doctype html>
<html lang="fr">
	<head>
 		<meta charset="utf-8">
		<title> Galanews - confirm faction</title>

 		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
			<?php
			foreach( $bdd->query('Select faction_name, Leader_Name FROM factions WHERE is_validate LIKE FALSE ORDER BY id') as $reponse)
			{
				echo $reponse['faction_name']." | ".$reponse['Leader_Name']; 
				//	echo '    UPDATE factions SET is_validate = TRUE WHERE faction_name LIKE "'.$_POST['faction_name'].'"'; ?>

				<form method="post" action="faction_confirm.php">
    			<button type="submit" name="faction_name" <?php echo 'value="'.$reponse['faction_name'].'"' ?> >valider la faction</button>
				</form>
				<?php
			}
			?>

	</body>
</html>
