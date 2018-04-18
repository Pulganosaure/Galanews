<?php

require_once "../functions.php";



session_start();

if(!isset($_SESSION['username']) || !isset($_POST['Build_Name']))
{
	echo isset($_SESSION['username']);
	isset($_POST['Build_Name']);
	//header('location: ../main.php');
}

$bdd = connect_to_bdd_galanews();
$retour_bdd = $bdd->query('Select id from users_list WHERE username LIKE "'.$_SESSION['username'].'"');
$user_id = $retour_bdd->fetch();
print_r($user_id);


$requete = 'INSERT INTO fits_coriolis (Build_Name, Build_Ship, Build_Price, Build_Category, Build_JumpRange, Build_Integrity, Build_Shield_Size, Build_Maximum_Speed, Build_Boost_Speed, Build_Cargo, Build_Author_id, Build_URL) VALUES ("'.$_POST['Build_Name'].'", "'.$_POST['Ship'].'", "'.$_POST['Ship_Price'].'", "'.$_POST['Category'].'", 0, "'.$_POST['Ship_Integrity'].'", "'.$_POST['Ship_Shield_Value'].'", "'.$_POST['Ship_Max_Speed'].'", "'.$_POST['Ship_Boost_Speed'].'", "'.$_POST['Ship_Cargo_Size'].'", "'.$user_id['id'].'", "'.$_POST['Build_Link'].'" )';
echo $requete;
$bdd->exec($requete);



