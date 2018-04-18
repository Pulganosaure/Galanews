
<?php

require_once "../functions.php";

session_start();
$existe = isset($_SESSION['username']);

if($existe == true)
{
  $user = $_SESSION['username'];
}
else
{
  $user = 'guest';
}


$bdd =connect_to_bdd_galanews();


?>
<!doctype html>


<html lang="fr">
  <head>
      <meta charset="utf-8">
      <title> Galanews</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../css/bootstrap.css"> 
  </head>
  <body>
    <header>
      <?php
    header_nav_bar(1, user_is_connected()); ?>
    <div class="alert alert-warning" role="alert">
        Le site est en développement, en cas de problème merci d'utiliser le lien en bas de page pour reporter un bug.
    </div>


      <h1 class="text-center"> POI Finder</h1>
      <p class="mx-5 text-center">Cet outil vous permet de trouver un Point d'intéret a proximité de votre position. Cela peux être une nébuleuse, un geyser, un site Guardians, Thargoids... vous pouvez ajoutez votre propre POI via le formulaire (prochainement)</p>
      <script src="../js/jquery.min.js"></script>
      
      <script src="../js/popper.js"></script>
      <script src="../js/bootstrap.min.js"></script>
    </header>

<div class="container mt-5">
 
  <form method="post" action="#">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label>Type de site :</label>
          <select name="site_type_selector" id="site_type_selector" class="form-control" onchange="car_type()">
            <option value="Thargoid_Site">Sites Thargoids</option>
            <option disabled value="Nebula">Nébuleuses</option>
            <option value="Guardians_Ruins">Ruines Guardians</option>
            <option value="Guardians_Structures">Structures Guardians</option>
            <option disabled value="INRA">INRA</option>
          </select>    
      </div>    
    </div>
    <div class="col">
      <div class="form-group">
        <label>Charactéristiques :</label>
        <select name="car_select" class="form-control" id="car_select">
          <option id="cars_option1">Tous</option>
          <option id="cars_option2">Actif</option>
          <option id="cars_option3">Innactif</option>
       </select>
      </div>     
    </div>  
  </div> 
  <div class="row">

  <div class="col">
      <div class="form-group">
          <label>Localisation :</label>
          <input name="user_localisation" type="text" class="form-control" id="user_localisation" placeholder="SOL">
      </div>
  </div>


    <div class="col">
      <div class="form-group">
        <label>Nombre de résultats :</label>
        <select name="nbr_result" class="form-control" id="nbr_result">
          <option id="1_results">1</option>
          <option id="5_results">5</option>
          <option id="10_results">10</option>
       </select>
      </div>    
    </div>  
  </div>
  <div class="row justify-content-md-center">
    <div class="col-md-auto">
      <button type="submit" class="btn btn-primary">Chercher</button>
    </div> 
  </div>
</form>


<?php



if(isset($_POST['site_type_selector']))
{
  switch ($_POST['site_type_selector']) 
  {
    case ("Guardians_Ruins"):
            $requete= "SELECT System_Name, Coords_X, Coords_Y, Coords_Z from guardians_sites WHERE id >= 0 ";
            get_informations($bdd, $requete);
      break;
    case ("Guardians_Structures"):
            if($_POST['car_select'] == "Actif")
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body, Latitude, Longitude from guardians_structures WHERE is_active LIKE TRUE ";
            }
            elseif($_POST['car_select'] == "Innactif")
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body, Latitude, Longitude from guardians_structures WHERE is_active LIKE FALSE ";
            }
            else
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body, Latitude, Longitude from thargoids_sites WHERE id >= 0 ";              
            }
            get_informations($bdd, $requete);
      break;
    case ("Thargoid_Site"):
            if($_POST['car_select'] == "Actif")
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body Latitude, Longitude from thargoids_sites WHERE is_active LIKE TRUE ";
            }
            elseif($_POST['car_select'] == "Innactif")
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body, Latitude, Longitude from thargoids_sites WHERE is_active LIKE FALSE ";
            }
            else
            {
              $requete = "SELECT System_Name, Coords_X, Coords_Y, Coords_Z, Body, Latitude, Longitude from thargoids_sites WHERE id >= 0 ";              
            }
            get_informations($bdd, $requete);
      break;
    case ("Nebula"):
            {
              $requete= "";
              $requete = $requete."WHERE id >= 0 ";
            }
            get_informations($bdd, $requete);
      break;
    case ("INRA"):
            {
              $requete= "";
              $requete = $requete."WHERE id >= 0 ";
              get_informations($bdd,$requete);
            }
      break;
}
  }
?>
</div>
</body>
    <script src="js/cars.js"></script>

</html>

<?php


function get_informations($bdd, $requete)
{
  if(!isset($_POST['site_type_selector']))
  {
    exit(202);
  }
  if(empty($_POST['user_localisation']))
  {
    exit();
  }
      $bdd = connect_to_bdd_galanews_poi();

  $url = file_get_contents('https://beta.edsm.net/api-v1/system?systemName='.urlencode($_POST['user_localisation']).'&showCoordinates=1');
  //récupération des données
  $decodeFlux = json_decode($url, true);
  if(!isset($decodeFlux['name']))
  {
    exit();
  }

  $my_system = array (
    "Coords_X"  => $decodeFlux['coords']['x'],
    "Coords_Y" => $decodeFlux['coords']['y'],
    "Coords_Z"   => $decodeFlux['coords']['z']
  );

  $excluded_system = "";
  $list_of_results = array ();

  for($i = 0; $i < $_POST['nbr_result']; $i++)
  {
    $destination =found_system($bdd, $my_system, $excluded_system,$requete);
    array_push($list_of_results, $destination);
    $excluded_system = $excluded_system." AND System_Name <> '".$destination['System_Name']."'";

    if(!empty($destination['System_Name']))
    {
      write_informations($destination);
    }
  }
}


function found_system($bdd, $my_system, $excluded_system, $requete)
{

  $destination = array (
    "System_Name" => "",
    "Distance" => -1,
    "Longitude" => "",
    "Latitude" => "",
    "Body" => ""
  );
  foreach ($bdd->query($requete.$excluded_system) as $coucou)
  {

    $distance = sqrt(pow($coucou['Coords_X'] - $my_system['Coords_X'], 2) + pow($coucou['Coords_Y'] - $my_system['Coords_Y'], 2) + pow($coucou['Coords_Z'] - $my_system['Coords_Z'], 2));
    if((int)$destination['Distance'] < 0)
    {
      $destination['Distance'] = $distance;
      $destination['System_Name'] = $coucou['System_Name']; 
      if(isset($coucou['Body']))
      {
        $destination['Longitude'] = $coucou['Longitude'];
        $destination['Body'] = $coucou['Body'];
        $destination['Latitude'] = $coucou['Latitude'];
      }
    }
    elseif($distance < (int)$destination['Distance'])
    {
      $destination['Distance'] = $distance;
      $destination['System_Name'] = $coucou['System_Name']; 
      if(isset($coucou['Body']))
      {
        $destination['Longitude'] = $coucou['Longitude'];
        $destination['Body'] = $coucou['Body'];
        $destination['Latitude'] = $coucou['Latitude'];
      }
  }
  }
  return $destination;
}



function write_informations($destination)
{
  echo 
'<div class="border rounded mt-4">
  <div class="row">
    <div class="col">
      <div class="text-center">
        <h4>Système : '.$destination['System_Name'].'</h4>
      </div>
    </div>  
    <div class="col">
      <div class="text-center">
        <h4>Distance : '.number_format($destination['Distance'], 2, '.', '').' Al</h4>
      </div>
    </div>
  </div>';
  if(!empty($destination['Body']))
  {
    echo
  '<div class="row">
    <div class="col">
      <div class="text-center">
        <h4>Astre : '.$destination['Body'].'</h4>
      </div>      
    </div>
    <div class="col">
      <div class="text-center">
        <h4>Latitude : '.$destination['Latitude'].'</h4>
      </div>      
    </div>
    <div class="col">
      <div class="text-center">
        <h4>Longitude : '.$destination['Longitude'].'</h4>
      </div>      
    </div>
  </div>';
  }
echo '</div>';



}