<?php
require_once "../functions.php";


	$bdd = connect_to_bdd_galanews();


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

		<h1> Ajouter une entrée </h1>
	</header>
<div class="container">
	<div class="row">
		<div class="col">
			<div id="logbook">
				<form method="post" action="my_logbook_entry_submit.php">
					<input type="text" name="title">
					<textarea name="contains">
				
					</textarea>
					<button type="submit" class="btn btn-primary">Ajouter</button>	
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>
