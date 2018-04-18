<?php
session_start();

	require_once "../functions.php";
?>


<!doctype html>
<html lang="fr">
	<head>
  		<meta charset="utf-8">
      	<title> Galanews</title>
      	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../css/bootstrap.css">
	</head>
	<body>
		<header>

			<?php 
			header_nav_bar(1, user_is_connected());
			script_list(); ?>
		</header>

		<div class="container">

			<?php 
			do_I_Show_informations();
			 ?>
			
		</div>

	</body>
</html>


<?php

function collapse_faction_information($permission, $bdd, $user_infos)
{

	if($permission)
	{
	echo '<div class="row">
				<div class="col">
					<div>
						<p class="mb-0">
  							<button class="btn btn-primary border-warning bg-warning btn-block" type="button" data-toggle="collapse" data-target="#faction_informations" aria-expanded="false" aria-controls="faction_informations">
    							informations
  							</button>
						</p>
						<div class="collapse" collapse.show  id="faction_informations">
  							<div class="card card-body">';
  								$requete = 'SELECT * FROM `factions` WHERE id LIKE '.$user_infos['faction_id'];
  								$result = $bdd->query($requete);
  								$faction_infos = $result->fetch();
  								$ingame_checkbox_state = faction_is_ingame($faction_infos);

  								echo '<form method="post" action="faction_update_infos.php" >
        							<div class="form-group">
          								<label for="faction_name">Nom :</label>
          								<input type="text" name="faction_name" class="form-control"  id="faction_name" placeholder="FrontierDev" value="'.$faction_infos['faction_name'].'" required>
        							</div>
        							<div class="form-group">
          								<label for="faction_tag">Tag :</label>
          								<input type="text" name="faction_tag" class="form-control" id="faction_tag" placeholder="FD" value="'.$faction_infos['faction_TAG'].'" required>
        							</div>
        				  			<div class="form-group">
    									<label for="faction_quickdescription">Description Rapide</label>
    									<textarea class="form-control" name="faction_quick_description" id="faction_quickdescription" rows="3" placeholder="Ceci est une description rapide qui s\'affichera dans la liste des factions" required>'.$faction_infos['faction_quick_description'].'</textarea>
  									</div>
         				  			<div class="form-group">
    									<label for="faction_description">Description Complète</label>
    									<textarea class="form-control" name="faction_description" id="faction_description" rows="5"
    									placeholder="Ceci est une description complète qui s\'affichera sur la page de votre faction" required>'.$faction_infos['faction_long_description'].'</textarea>
  									</div>
  									<div class="form-check my-4s">
  										<input class="form-check-input" checked="'.$ingame_checkbox_state.'" type="checkbox"  value="" id="ingame_checkbox">
  										<label class="form-check-label"  for="ingame_checkbox">
    										en jeu ?
  										</label>
									</div>
         				  			<div class="form-group">
         				  			    <label for="recrut_type">Type de Recrutement</label>
										<select id="recrut_type" name="recrut_mode" class="form-control form-control-lg">
										';
										faction_recrut_mode($faction_infos);
										echo '
										</select>
									</div>
									 <button type="submit" class="btn btn-primary">Mettre à jour</button>
  								</form>';
  					echo	'</div>
						</div>
					</div>
				</div>
			</div>';
	}
	else
	{
	echo '<div class="row">
				<div class="col">
					<div>
						<p class="mb-0">
  							<button class="btn btn-primary border-warning bg-warning btn-block" type="button" data-toggle="collapse" data-target="#faction_informations" aria-expanded="false" aria-controls="faction_informations">
    							informations
  							</button>
						</p>
						<div class="collapse " id="faction_informations">
  							<div class="card card-body">';
 								echo '<h3 class="text-danger">Vous n\'avez pas la permission de modifier ces informations</h3>';
  					echo	'</div>
						</div>
					</div>
				</div>
			</div>';
		}

}

function faction_is_ingame($faction_infos)
{
	if($faction_infos['ingame'])
		return "checked";
	else
		return "unchecked";
}
function faction_recrut_mode($faction_infos)
{
	switch ($faction_infos['join_option']) {
		case 0:
		echo '
  			<option value=0 selected="selected">Ouverte</option>
  			<option value=1>Candidature</option>
  			<option value=2>Fermé</option>';
			break;
		case 1:
		echo '
  			<option value=0>Ouverte</option>
  			<option value=1 selected="selected">Candidature</option>
  			<option value=2>Fermé</option>';
			break;
		case 2:
		echo '
  			<option value=0>Ouverte</option>
  			<option value=1>Candidature</option>
  			<option value=2 selected="selected">Fermé</option>';
			break;
		
		default:
			# code...
			break;
	}
}

function collapse_members_list($permission, $bdd , $user_infos)
{
	echo '<div class="row">
				<div class="col">
					<div>
						<p class="mb-0">	
  							<button class="btn btn-primary bg-success border-success btn-block" type="button" data-toggle="collapse" data-target="#faction_members_list" aria-expanded="false" aria-controls="faction_members_list">
								koukou	
  							</button>
						</p>
						<div class="collapse " id="faction_members_list">
  							<div class="card card-body">';
  								$requete = 'SELECT * FROM `factions` WHERE id LIKE '.$user_infos['faction_id'];
  								$result = $bdd->query($requete);
  								$faction_infos = $result->fetch();
  							$requete = "SELECT * from `factions_members` WHERE faction_id LIKE ".$user_infos['faction_id'];
  								// foreach ($bdd->query($requete)) 
  								// {
  									
  								// }
  				echo		'</div>
						</div>
					</div>
				</div>
			</div>';
}


function do_I_Show_informations()
{
	$bdd = connect_to_bdd_galanews();

  $user_infos = array (
    "faction_id"  => "",
    "user_id" => "",
    "user_permission" => "",
  );
  $requete= 'SELECT id FROM `users_list` WHERE username LIKE "'.$_SESSION['username'].'"';
  $result = $bdd->query($requete)->fetch();
  $user_infos['user_id'] = $result['id'];

  $requete = 'SELECT faction_id, rank FROM `factions_members` WHERE `member_id` LIKE "'.$user_infos['user_id'].'"';
  $result = $bdd->query($requete)->fetch();
  $user_infos['faction_id'] = $result['faction_id'];
  $user_infos['user_permission'] = $result['rank'];



  if($user_infos['user_permission'] < 2)
  {
  	acces_denied();		
  }
  else
	{
  	if($user_infos['user_permission'] > 2)
		collapse_faction_information(1, $bdd, $user_infos);  	
  	else
		collapse_faction_information(0, $bdd, $user_infos);  	

  	if($user_infos['user_permission'] > 1)
		collapse_members_list(1, $bdd, $user_infos);  	
 	else
		collapse_members_list(0, $bdd, $user_infos);  
	}
}

function acces_denied()
{
  echo '
  <div class="row mt-5">
    <div class="col " align="center">';
  echo "Vous n'avez pas la permission d'accéder à cette ressource. Veuillez contacter vos membres supérieurs. (autre que votre bras)";
  echo '
    </div>
  </div>';
  echo '
  <div class="row mt-5">
    <div class="col " align="center">';
  echo '<a href="../main.php">retourner au menu principal</a>';
  echo '
    </div>
  </div>';
}