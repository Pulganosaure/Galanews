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
  $user = 'inconnu';
}


connect_to_bdd_galanews();


?>
<!doctype html>


<html lang="fr">
  <head>
      <meta charset="utf-8">
      <title> Galanews</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
    <header>
            <script src="../js/jquery.min.js"></script>
      <script src="../js/popper.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/EJSChart/EJSChart.js"> </script>
<?php header_nav_bar(0, user_is_connected()) ?>

    <div class="alert alert-warning" role="alert">
        Le site est en développement, en cas de problème merci d'utiliser le lien en bas de page pour reporter un bug.
    </div>
  </header>
  <div class="container">
    <?php
    if(isset($_GET['system_name']))
    {
          get_datas($_GET['system_name']);
    }
    else
    {
      get_datas("karka");
    }
    ?>

  </div>
</body>
</html>


<?php








function print_system_name($system_name)
{
    echo '<h1>'.$system_name.'</h1>';

}
function print_system_details($controllingfaction_name, $faction_allegiance, $faction_government)
{
    ?>
    <div class="row">
      <div class="col">
        Faction dirigeante : 
      </div>
      <div class="col">
        <?php echo $controllingfaction_name; ?>
      </div>
    </div>    
    <div class="row">
      <div class="col">
        Allegance : 
      </div>
      <div class="col">
        <?php echo $faction_allegiance; ?>        
      </div>
    </div>
    <div class="row">
      <div class="col">
        gouvernement : 
      </div>
      <div class="col">
        <?php echo $faction_government; ?>        
      </div>
    </div>
    <?php
}

function print_influences($faction_datas)
{
  $nbr_values_on_graph = 10;

for($faction_nbr = 0; $faction_nbr < count($faction_datas); $faction_nbr++)
{
  for($i = 0; $i < $nbr_values_on_graph; $i++)
  {

       $key = array_keys($faction_datas[$faction_nbr]['influenceHistory']);
          //echo $faction_datas[0]['influenceHistory'][$key[sizeof($faction_datas[0]['influenceHistory'])-1-$nbr_values_on_graph+$i]];
          //echo '</br>';

          $current_value = $faction_datas[$faction_nbr]['influenceHistory'][$key[sizeof($faction_datas[$faction_nbr]['influenceHistory'])-1-$nbr_values_on_graph+$i]] * 100;
          $previous_value = $faction_datas[$faction_nbr]['influenceHistory'][$key[sizeof($faction_datas[$faction_nbr]['influenceHistory'])-2-$nbr_values_on_graph+$i]] * 100;
                          //draw_script($i,$current_value, $previous_value);
          echo '<script type="text/javascript" src="js/draw_influences.js" onload="draw_influences('.$i.','.$current_value.','.$previous_value.')"></script>';
   }
 }


}

function collapse_faction_data($faction_data, $owner_faction_name)
{
  
  for($i = 0; $i < count($faction_data); $i++)
  {
  ?>
          <div>            <p class="mb-2 mt-0">
  <?php
              if($faction_data[$i]['name'] == $owner_faction_name)
                  { 
                    ?>
                <button class="btn btn-primary border-secondary bg-secondary btn-block" type="button" data-toggle="collapse" data-target=<?php echo '"#faction_informations_'.$i.'"'; ?> aria-expanded="false" aria-controls="faction_informations">
                  <h5 class="text-dark">
                    <?php echo $faction_data[$i]['name']; ?>
                  </h5>
                </button>
                <?php
              }
                  else
                  { 
                    ?>
                <button class="btn btn-primary border-secondary bg-light btn-block" type="button" data-toggle="collapse" data-target=<?php echo '"#faction_informations_'.$i.'"'; ?> aria-expanded="false" aria-controls="faction_informations">
                  <h5 class="text-dark">
                    <?php echo $faction_data[$i]['name']; ?>
                  </h5>
                </button>
                <?php
              }
              ?>
            </p>


            <div class="collapse"  id=<?php echo '"faction_informations_'.$i.'"';?>>
                <div class="card card-body mb-4">
                  <div class="row">
                    <div class="col">
                      <div class="row">
                        <h6> Influence : <?php echo number_format($faction_data[$i]['influence'] * 100, 2)." %"; ?>
                        </h6>
                      </div>
                      <div class="row">
                        <h6> Etat : <?php echo $faction_data[$i]['state']; ?>
                        </h6>
                      </div>
                      <div class="row">
                        <h6> faction de joueur : <?php  
                        if($faction_data[$i]['isPlayer'])
                          echo "oui";
                        else
                          echo "non";

                         ?>
                        </h6>
                      </div>
                    </div>
                    
                  </div>
                </div>
            </div>
          </div>
 <?php
  }
}

function get_datas($system_name)
{
    $url = file_get_contents('https://www.edsm.net/api-system-v1/factions?systemName='.urlencode($system_name).'&showHistory=1');
  //récupération des données
  $faction_infos = json_decode($url, true);

  //print_r( $decodeFlux); ?>

  <!-- affichage du nom du système, de sa faction dirigeante, type de sécurité et son gouvernement -->
  <div class="row">
    <div class="col">
      <?php print_system_name($faction_infos['name']); ?>
    </div>
    <div class="col">
      <?php print_system_details($faction_infos['controllingFaction']['name'],$faction_infos['controllingFaction']['allegiance'],$faction_infos['controllingFaction']['government']); ?>
    </div>
  </div>
  <!-- affichage du graphique -->
  <div class="row">
      <label class="mt-5" for="influence_graphic">Courbes d'évolution des influences des factions :</label>
      <canvas id="influence_graphic" style="border:1px solid #000000;width: 100%;height: 250px;"></canvas>

      <?php
      print_influences($faction_infos['factions']); 
?> 
  </div>
  <div class="row mt-3">
    <div class="col">
      <?php collapse_faction_data($faction_infos['factions'], $faction_infos['controllingFaction']['name']); ?>
    </div>
  </div>

    <?php
}