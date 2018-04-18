<?php

	require_once "../functions.php";
	session_start();

	$bdd = connect_to_bdd_galanews();

  $requete= 'SELECT id FROM `users_list` WHERE username LIKE "'.$_SESSION['username'].'"';
  $result = $bdd->query($requete)->fetch();
  $user_infos['user_id'] = $result['id'];

  $requete = 'SELECT faction_id, rank FROM `factions_members` WHERE `member_id` LIKE "'.$user_infos['user_id'].'"';
  $result = $bdd->query($requete)->fetch();
  $user_infos['faction_id'] = $result['faction_id'];
  $user_infos['user_permission'] = $result['rank'];



	$requete = 'SELECT * FROM `factions` WHERE id LIKE '.$user_infos['faction_id'];
  	$result = $bdd->query($requete);
  	$faction_infos = $result->fetch();
  	$current_faction_name = $faction_infos['faction_name'];

	if(!isset($_POST['faction_name']))
		header("Location: ../main.php");


	$requete = 'UPDATE `factions` SET faction_name = "'.$_POST['faction_name'].'",
				faction_TAG = "'.$_POST['faction_tag'].'",
				faction_quick_description = "'.$_POST['faction_quick_description'].'",
				faction_long_description = "'.$_POST['faction_description'].'",
				join_option = "'.$_POST['recrut_mode'].'" 
				 WHERE faction_name LIKE "'.$current_faction_name.'"
				';
				echo $requete;
	$bdd->exec($requete);

	header("Location: faction_gestion.php");
