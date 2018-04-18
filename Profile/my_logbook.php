<?php
require_once "../functions.php";


	$bdd = connect_to_bdd_galanews();


session_start(); 	
?>



<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title> Galanews</title>

      <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
	<header>
		<?php
      header_nav_bar(1, user_is_connected());
      script_list();
      ?>
		<h1> Entrées du journal de bord du Commandant "machin"</h1>
	</header>
<div class="container mb-5">
	<div class="row">
		<div>
			<form action="my_logbook_entry.php">
				<button type="submit" class="btn btn-primary">Ajouter un message a votre journal de bord</button>	
			</form>
		</div>
	</div>
    	<?php
		// foreach( $bdd->query('Select title, Contains, Creation_Date  FROM logbooks WHERE author LIKE "'.$_SESSION['username'].'" ORDER BY Creation_Date DESC') as $reponse)
		// {
		// 	write_logbook_entry($reponse['Creation_Date'], $reponse['title'], $reponse['Contains']);
		// }
		foreach( $bdd->query('SELECT * FROM ((SELECT id, pseudo, tchat FROM minitchat ORDER BY id DESC LIMIT 0, 2)) as result ORDER BY id') as $reponse)
		{
			echo $reponse['id']." : ".$reponse['pseudo']." : ".$reponse['tchat'].'</br>';
		}
		?>
</div>


</body>
</html>



<?php

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
