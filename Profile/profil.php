<?php
require_once "../functions.php";



	$bdd = connect_to_bdd_galanews();


?>


<!doctype html>
    <html lang="fr">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../css/bootstrap.css">
      <title>Galanews</title>
    </head>
    <body>
    <header>
      <?php
      header_nav_bar(1, user_is_connected());
      script_list();
      ?>

	</header>

    <div class="container mb-5">

 <?php       do_I_write_profil();
 ?>


    </div>
</body>
</html>



<?php

function write_information($legend, $bdd_name, $donnees)
{
	echo 	'<tr> 
			<td>';
	echo 	$legend; 	
	echo	'</td>
			<td>';

	echo $donnees[$bdd_name];

	echo 	'</td>
			</tr>';
}

function write_faction_information($legend, $bdd_name, $donnees)
{
	echo 	'<tr> 
			<td >'.
			$legend
			.'</td>
			<td>'

			.'<a href="../factions/faction?faction_name=kevin">'.$donnees[$bdd_name].'</a>'
			.'<img src="../factions/faction_data/'.$donnees['faction'].'/icon.png" style="width:24px;height:24px" class="ml-2" alt=""></img>'

	 		.'</td>
			</tr>';
}


function do_I_write_profil()
{
  $bdd = connect_to_bdd_galanews();
  if(isset($_GET['username']))
  {
    $username = $_GET['username'];
    $users_infos_result = $bdd->query('SELECT * FROM users_list WHERE username LIKE "'.$username.'"');
    $users_infos = $users_infos_result->fetch();
    if($users_infos == 0 || $users_infos['security_level'] < 1 || $users_infos['security_level'] == 3)
    {
      no_result_found_for_this_username();
    }
    else
    {
      write_profil($users_infos);
      write_last_logbook_entry($users_infos);
    }
  }
  elseif(isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];

    $users_infos_result = $bdd->query('SELECT * FROM users_list WHERE username LIKE "'.$username.'"');
    $users_infos = $users_infos_result->fetch();
    if($users_infos == 0 || $users_infos['security_level'] < 1 || $users_infos['security_level'] == 3)
    {
      no_result_found_for_this_username();
    }
    else
    {
      write_profil($users_infos);
      write_last_logbook_entry($users_infos);

    }
  }
  else
  {
      header("Location: ../main.php"); 
  }

}

function no_result_found_for_this_username()
{
  echo '
  <div class="row mt-5">
    <div class="col " align="center">';
  echo "Nous n'avons pas trouvé d'utilisateurs a ce nom :/";
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

function no_logbook_entry_found_for_this_username()
{
  echo '
  <div class="row">
    <div class="col " align="center">';
  echo "Nous n'avons pas trouvé d'entrée dans le journal de bord de ce commandant :/";
  echo '
    </div>
  </div>';
}

function write_profil($users_infos)
{
    echo '
    <div class="row">
        <div class="col-8">
            <h1 class="mt-4 mb-4">Mon profil :</h1>
        </div>
      </div>
    <div class="row">
    <div class="col">

      <table class="table table-striped  table-white">
        <tbody>';     
          write_information("Nom de commandant :", "username", $users_infos);
          write_information("Rang Combat :", "combat_rank", $users_infos);
          write_information("Rang de Commerce :", "trader_rank", $users_infos);
          write_information("Rang Explorateur :", "explorer_rank", $users_infos);
          write_information("Rang Fédéral :", "federation_rank_name", $users_infos);
          write_information("Rang Imperial :", "empire_rank_name", $users_infos);
          write_information("Assets :", "current_asset_value", $users_infos);
          write_information("Temps de jeu : ", "play_time", $users_infos);
          write_faction_information("Faction :", "faction", $users_infos);

     echo '</tbody>
      </table>      
        </div></div>';



}

function write_logbook_entry($Date, $title, $containt)
{
	$Current_Date = new DateTime($Date);

	echo   	'<div class="row border rounded mt-2">
  				<div class="col-md-auto w-100">
  					<div class="row border-bottom ">
  						<h5 class="ml-1 mt-1 mb-2">'.$Current_Date->format('d-m-Y : H:i:s').'</h5>
  					</div>
  					<div class="row border-bottom ">
  						<h5 class="ml-1 mt-1 mb-2">'.$title.'</h5>
  					</div>
  					<div class="row">
  						<p class="ml-1 mt-1 mb-2">'.$containt.'</p>
  					</div>
  				</div>
  			</div>';
}

function write_no_logbook_entry()
{
  echo "aucune entrée de journal de bord du commandant";  
}
function write_last_logbook_entry($users_infos)
{
  $bdd = connect_to_bdd_galanews();
  $bdd2 = connect_to_bdd_galanews();
  echo '<div class="row">
          <div class="col">
            <h2 class="text-center mt-4 mb-4">Dernières entrées du journal de bord :</h2>
          </div>
        </div
        <div class="row">
          <div class="col">';
          $result = $bdd->query('SELECT COUNT(*) as total From `logbooks` WHERE author LIKE "'.$users_infos['username'].'"');
          $nbr_logbookentry = $result->fetch();
            if($nbr_logbookentry['total'] > 0)
            {
              echo "pouet";
              $requete = 'SELECT * FROM logbooks WHERE author LIKE "'.$users_infos['username'].'" ORDER BY Creation_Date DESC LIMIT 3';
              foreach ($bdd2->query($requete) as $result)
              {
                write_logbook_entry($result['Creation_Date'], $result['title'], $result['Contains']);
              }
            }
            else
            {
              no_logbook_entry_found_for_this_username();
            }
echo     '</div>
        </div>


  </div>';
      ?>
    <div class="col mb-4">
      <div class="row mt-4">
        <div class="col" align="center">
          <form action="my_logbook.php">
            <button type="submit" class="btn btn-primary">Voir toutes les entrées</button>
          </form>
        </div>
        <div class="col" align="center">
          <form action="my_logbook_entry.php">
            <button type="submit" class="btn btn-primary">Ajouter une entrée</button>
          </form>
        </div>
      </div>
    </div>
    <?php
}

?>

