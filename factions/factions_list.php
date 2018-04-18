<?php

require_once "../functions.php";

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
	<div class="container">
		<h1 class="mt-3">Factions :</h1>

		<div class="row mt-5">
	<?php write_faction_list(); ?>

		</div>
	</div>

	</body>
</html>

<?php

function write_faction_list()
{
	$bdd = connect_to_bdd_galanews();

	foreach ($bdd->query('SELECT * FROM factions WHERE is_validate LIKE 1 ORDER BY id') as $factions_infos) 
	{
		$nbr_member = $bdd->query('SELECT COUNT(*) as nbr_of_member FROM `factions_members` WHERE faction_id LIKE '.$factions_infos['id']);
		$result = $nbr_member->fetch();
		echo '<div class="col-sm mb-5">';
  	echo '<div class="card " style="width: 18rem;">
  			<div class="border-bottom text-center style="width:256px;height:256px">
  			<img class="card-img-top" src="../factions/faction_data/'.$factions_infos['id'].'/icon.png" alt="Card image cap" class="mx-auto " style="width:256px;height:256px;overflow:hide">
  			</div>
  			<div class="card-body pb-2">
		    	<h5 class="card-title">'.$factions_infos['faction_name'].'</h5>
    			<p class="card-text">'.$factions_infos['faction_quick_description'].'</p>';
    			card_button($factions_infos);
  	echo '	</div>
		</div>
		</div>';
	}
	echo '</div>';
}



function card_button($factions_infos)
{
echo '<div class="row"><div class="col text-center align-middle">
<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary bg-primary"><a class="text-white" href="faction.php?faction_name='.$factions_infos['faction_name'].'">  Voir  </button>';
  	if($factions_infos['join_option'] == 0)
  		echo '<button type="button" class="btn btn-secondary bg-success" data-toggle="tooltip" data-placement="bottom" title="Cette Faction est ouverte"><a class="text-white" href="join_faction.php">Ouverte</a></button>';
	elseif($factions_infos['join_option'] == 1)
  		echo '<button type="button" class="btn btn-secondary bg-warning"><a class="text-white" href="join_faction.php"
  	data-toggle="tooltip" data-placement="bottom" title="Cette faction accepte le recrutement par candidature">Candidature</a></button>';
	else
	{
		echo '<button type="button" class="btn btn-secondary bg-danger" data-toggle="tooltip" data-placement="bottom" title="Cette faction à fermé son recrutement"><a class="text-white">Fermé</a></button>';
	}		
echo '</div></div></div>';
}