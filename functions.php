<?php


function current_user()
{
	session_start();
	$existe = isset($_SESSION['username']);

	if($existe == true)
	{
	  return $_SESSION['username'];
	}
  	return 'guest';
}

function user_is_connected()
{
	if (session_status() == PHP_SESSION_NONE) 
	{
    	session_start();
	}
	return(isset($_SESSION['username']));

}

function script_list()
{
 echo '<script src="../js/jquery.min.js"></script>
      <script src="../js/popper.js"></script>
      <script src="../js/bootstrap.min.js"></script>';
}

function start_session($heading)
{
	session_start();
	if(!isset($_SESSION['username']))
	{

		if($heading == "true")
		{
			header('location: ../profile/connexion');
		}
		else
		{
			return "guest";
		}
	}
	else
	{
		return $_SESSION['username'];
	}
}
//ajoute "../" le nombre de fois indiquer par le paramètre 1. utiliser pour les urls de redirection dans le header
function br_for_folders($nbr_folder)
{
	for($i = 0; $i< $nbr_folder ;$i++)
    {
      	echo '../';
    }
}

function connect_to_bdd_galanews_poi()
{
  try 
  {
    $bdd = new PDO('mysql:host=localhost;dbname=galanews_poi;charset=utf8', 'root','');
  }
  catch (Exception $e)
  {
    die('Erreur : ' . $e ->getMessage());
  }
  return $bdd;
}


//renvoi la connexion à la base de donnée galanews
function connect_to_bdd_galanews()
{
	try 
	{
		$bdd = new PDO('mysql:host=localhost;dbname=galanews;charset=utf8', 'root','');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e ->getMessage());
	}
	return $bdd;
}






//default nav bar arg 1 : nombre de dossier depuis la racine | arg 2 : l'utilisateur est connecté (true/false)
function header_nav_bar($nbr_folder, $is_connected)
{	
	echo '<nav class="navbar navbar-expand-sm navbar-dark bg-dark" role="navigation">
      	<a class="navbar-brand" href="#">Galanews</a>
      	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    	</button>
      	<div class="collapse navbar-collapse" id="navbar">
        	<ul class="navbar-nav mr-auto">
          	<li class="nav-item">
            	<a class="nav-link" href="';br_for_folders($nbr_folder); echo 'main">Home</a>
          	</li>
	          <li class="nav-item">
    	        <a class="nav-link" href="factions/factions_list.php">Communauté</a>
        	</li>
          <li class="pr-2">
          <div  class="btn-group dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Le jeu</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item "href="';br_for_folders($nbr_folder); echo 'Tools/CoriolisFits">Les bases</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Les Activités</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Les Puissances</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Les Races Aliens</a>
                </div>
          </div>
          </li>
          <li class="pr-2">
          <div  class="btn-group dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Guides</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item "href="';br_for_folders($nbr_folder); echo 'Tools/CoriolisFits">Combats</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Commerce</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Exploration</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Transport</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Minage</a>
                  <a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">Chasse aux Thargoids</a>
                </div>
          </div>
          </li>
          <li class="pr-2">
          <div  class="btn-group dropdown">
            	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Outils</a>
              	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            	    <a class="dropdown-item "href="';br_for_folders($nbr_folder); echo 'Tools/CoriolisFits">Coriolis</a>
                	<a class="dropdown-item" href="';br_for_folders($nbr_folder); echo 'Tools/POIfinder">POI Finder</a>
                	<a class="dropdown-item disabled" href="#">Comming Soon</a>
             	</div>
          	</div> 
            </li>
        	</ul>
        	<ul class="nav">
            	<li class="nav-item">';
            	if($is_connected == "true")

              	{
                	echo '<a class="nav-link" href="';
                	br_for_folders($nbr_folder);
                	echo 'profile/deconnexion.php">Deconnexion</a>';
              	}
              	else              	
            	{
                	echo '<a class="nav-link" href="';
                	br_for_folders($nbr_folder);
                	echo 'profile/connexion">Connexion</a>';
              	}


              	echo '         
            	</li>
        	</ul>
        	<ul class="nav">
            	<li class="nav-item">';


            	if($is_connected == "true")
            	{
                	echo '<a class="nav-link" href="';
                	br_for_folders($nbr_folder);
                	echo 'profile/profil">Profil</a>';
              	}
            	else              	
            	{
            	    echo '<a class="nav-link" href="';
                	br_for_folders($nbr_folder);
            	    echo 'profile/inscription">Inscription</a>';
            	}


              	echo '  



           		</li>
        	</ul>
      	</div>
    </nav>';
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CALL FUNCTION FROM THIS FILE REQUIRE : require_once "functions.php"; ON THE HEADER OF THE FILE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////