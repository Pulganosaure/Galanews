
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
		<?php write_faction_informations(); ?>
	</div>

	</body>
</html>
<?php





function write_faction_informations()
{
	if(!isset($_GET['faction_name']))
	{
		header("Location: factions_list.php");
		exit();
	}
	$bdd = connect_to_bdd_galanews();

	$requete =  'SELECT COUNT(*) as faction_exist FROM factions WHERE faction_name LIKE "'.$_GET['faction_name'].'"';
	$result = $bdd->query($requete);
	$faction_exist = $result->fetch();
	if($faction_exist['faction_exist'] <= 0)
	{
		header("Location: factions_list.php");
		exit();		
	}

	$bdd_result = $bdd->query('SELECT * FROM factions WHERE faction_name LIKE "'.$_GET['faction_name'].'" ORDER BY id');
	$factions_infos = $bdd_result->fetch();

	echo '
	<div class="row mt-5 ">
		<div class="col-sm">
			<img class="card-img-top" src="../factions/faction_data/'.$factions_infos['faction_name'].'/icon.png" alt="Card image cap" class="mx-auto img-thumbnail" style="max-width:300px;max-height:300px" >			
		</div>
		<div class="col-6 align-middle">
			<h1 class="text-center align-middle">'.$factions_infos['faction_name'].'</h1>
			
		</div>
		<div class="col-sm">
			<div class="row ">
				<div class="col-sm">
					<h5>système :</h5>
				</div>	
				<div class="col-sm">

					<h5>'.$factions_infos['faction_system_name'].'</h5>
				</div>		
			</div>
			<div class="row">
				<div class="col-sm">
					<h5>Créer le :</h5>
				</div>	
				<div class="col-sm">
					<h5>SOON</h5>
				</div>		
			</div>
			<div class="row">
				<div class="col-sm">
					<h5>Créer par :</h5>
				</div>	
				<div class="col-sm">
					<h5>'.$factions_infos['Leader_Name'].'</h5>
				</div>		
			</div>			
		</div>		
	</div>';
}