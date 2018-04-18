<?php



require_once "../functions.php";

 $bdd = connect_to_bdd_galanews(); 	

	$requete = "SELECT COUNT(*) AS NBRE FROM users_list WHERE username LIKE '".$_POST['username']."'";
	$reponse = $bdd->query($requete)->fetchColumn();
  echo $reponse;
	//echo $reponse;
	if($reponse >=1)
	{
		$requete = "SELECT permissions, faction FROM users_list WHERE username LIKE '".$username."'";
		$reponse = $bdd->query($requete)->fetchColumn();
		session_start();
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['permissions'] = $reponse['permissions'];
		$_SESSION['faction'] = $reponse['faction'];

		header("Location: ../main.php");
	}

	// else
	// {
	// 	header('Location: Connexion');
	// 	echo "meh";
	// }
?>