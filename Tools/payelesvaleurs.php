  
<?php

require_once "../functions.php";

  $bdd = connect_to_bdd_galanews_poi();

  foreach($bdd->query('SELECT System_Name FROM guardians_sites ORDER BY id') as $coucou)
  {
    $url = file_get_contents('https://beta.edsm.net/api-v1/system?systemName='.urlencode($coucou['System_Name']).'&showCoordinates=1');
  //récupération des données
    $decodeFlux = json_decode($url, true);


  $my_system = array (
    "Coords_X"  => $decodeFlux['coords']['x'],
    "Coords_Y" => $decodeFlux['coords']['y'],
    "Coords_Z"   => $decodeFlux['coords']['z']
  );
  echo 'UPDATE guardians_sites SET Coords_X = '.$my_system['Coords_X'].', Coords_Y = '.$my_system['Coords_Y'].', Coords_Z = '.$my_system['Coords_Z'].' WHERE System_Name LIKE '.$coucou['System_Name'].'</br></br>';
  $bdd->exec('UPDATE guardians_sites SET Coords_X = '.$my_system['Coords_X'].', Coords_Y = '.$my_system['Coords_Y'].', Coords_Z = '.$my_system['Coords_Z'].' WHERE System_Name LIKE "'.$coucou['System_Name'].'"');

  }