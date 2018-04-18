<?php
session_start();
$existe = isset($_SESSION['username']);
require_once "../functions.php";

if($existe == true)
{
	$user = $_SESSION['username'];
}
else
{
	$user = 'guest';
}

$bdd = connect_to_bdd_galanews();


$requete = 'SELECT faction FROM users_list WHERE username LIKE "'.$_SESSION['username'].'"';
$reponse = $bdd->query($requete)->fetchColumn();
$faction_name = $reponse;
$requete = 'SELECT id FROM users_list WHERE username LIKE "'.$_SESSION['username'].'"';
$reponse = $bdd->query($requete)->fetchColumn();
$user_id = $reponse;
$requete = 'SELECT rank FROM factions_members WHERE member_id LIKE "'.$user_id.'"';
$reponse = $bdd->query($requete)->fetchColumn();
$user_rank = $reponse;


if(isset($_POST['user_to_promote']))
	{
		$bdd->exec('UPDATE '.$faction_name.' SET rank = '.$_POST['rank'].' WHERE username LIKE "'.$_POST['user_to_promote'].'"');
	}

?>




<!doctype html>
<html lang="fr">
	<head>
  		<meta charset="utf-8">
      	<title> Galanews</title>
      	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/bootstrap.css">
	</head>
	<body>
		<?php
		foreach( $bdd->query('Select member_id, rank FROM `factions_members` WHERE faction_id LIKE ') as $reponse)
			{
				echo 'commandant '.$reponse['username']." | rang ".$reponse['rank'];

				if($user_rank > 0)
				{
					echo '<form method="post" action="faction_members_tools.php">
					<select name="rank">
					    <option disabled selected value>select rank</option>
  						<option value="0">Membre</option>
  						<option value="1">Modérateur</option>
  						<option value="3">Admin</option>
					</select>
						<button type="submit" name="user_to_promote" value="'.$reponse['username'].'">changer le rang</button>
					</form></br></br></br></br>';
				}
			}
			?>
	</body>
</html>