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
    script_list();
    header_nav_bar(1, user_is_connected()); ?>
    <div class="alert alert-warning" role="alert">
        Le site est en développement, en cas de problème merci d'utiliser le lien en bas de page pour reporter un bug.
    </div>     
  </header>
      

  <div class="container">
<form method="POST" action="#" class="form-inline">
  <div class="col mb-5 pb-4 border-bottom">
  <div class="row mb-3">
      <h1>Fits Coriolis : </h1>
  </div>
  <div class="row">
    <div class="col">
        <div class="form-group mb-2">
            <label for="ship_filter_selector">Vaisseau :</label>
            <select name="Ship" id="ship_filter_selector" class="custom-select custom-select-lg mb-3">
                <option value="" selected>Tous</option>
                <option value="Eagle">Eagle</option>
                <option value="Imperial-Eagle">Imperial Eagle</option>
                <option value="Annaconda">Annaconda</option>
                <option value="Imperial-Eagle">Imperial Eagle</option>
                <option value="Imperial-Courrier">Imperial Courrier</option>
                <option value="Imperial-Clipper">Imperial Clipper</option>
                <option value="Imperial-Cutter">Imperial Cutter</option>
              </select>
          </div>    
    </div>
    <div class="col"> 
          <div class="form-group mb-2">
            <label for="Category_Filter_Selector">Catégorie :</label>
            <select name="Category" id="Category_Filter_Selector" class="custom-select custom-select-lg mb-3">
              <option value="" selected>Tous :</option>
              <option value="Exploration">Exploration</option>
              <option value="Combat">Combat</option>
              <option value="Marchand">Marchand</option>
              <option value="Chasse aux xenomorphes">Chasse aux xenomorphes</option>
              <option value="Scientifique">Scientifique</option>
              <option value="Multi-Roles">Multi-Roles</option>  
              <option value="Autre">Autre</option>
            </select>
          </div>
    </div>
  </div>
  <div class="row">
    <div class="col" align="center">
      <button type="submit" class="btn btn-primary">Chercher</button>
    </div>    
</form>
    <div class="col">
          <?php add_fit_button() ?>   
    </div>
  </div>  
</div>
    <div class="row justify-content-around">
    <?php print_result(); ?>
    </div>
  </div>
    </body>
    </html>

<?php
  
function add_fit_button()
{
  if(user_is_connected() != "")
  {
    echo '
    <div  align="center">
      <form action="Add_Coriolis_fit.php">
        <button type="submit" class="btn btn-primary">Ajouter un fit</button>
      </form>
    </div>';  
  }
  else
  {
    echo '
    <div align="center">
      <form action="#">
        <button disabled class="btn btn-primary  border-secondary bg-secondary" data-toggle="tooltip" data-placement="top" title="Connectez vous pour ajouter un fit" id="add_fit_button">Ajouter un fit</button>
      </form>
    </div>';

  }
}


function getrequest()
{
  $has_filter = 0;

    $requete = 'SELECT * FROM `fits_coriolis`';
  if(!empty($_POST['Ship']))
  {
    $requete = $requete." WHERE Build_Ship LIKE '".$_POST['Ship']."'";
    $has_filter = 1;
  }
  if(!empty($_POST['Category']))
  {
    if(!$has_filter)
      $requete = $requete." WHERE Build_Category LIKE '".$_POST['Category']."'";
    else
      $requete = $requete." AND Build_Category LIKE '".$_POST['Category']."'";
  }
    return $requete.' ORDER BY Build_VoteUp';
}


function write_end_of_result()
{
  echo "Nous n'avons pas de fit a vous proposer pour le moment";
}

function print_result()
{
  $bdd = connect_to_bdd_galanews();
  $request = getrequest();

  foreach ($bdd->query($request) as $result) 
  {
    draw_build($result); 
  }  
}

function draw_build($fit_infos)
{
    echo '
  <div class="col-sm" align="center">
    <div class="card mb-4 " style="width: 18rem;">
      <div class="border-bottom">
        <div class="row">
          <div class="col">
            <img class="card-img-top" src="Ship_Icons/'.strtolower($fit_infos['Build_Ship']).'.png" alt="'.$fit_infos['Build_Ship'].' icon" style="max-width:300px;max-height:300px" > 
          </div>
          <div class="col text-center">
            <div class="row text-center">
              <h6 class="text-center">'.$fit_infos['Build_Ship'].'</h6>
            </div>
            <div class="row">
              <h6 class="text-center">'.$fit_infos['Build_Category'].'</h6>
            </div>
            <div class="row">
              <h6 class="text-center"> auteur : '.'pulgan'.'</h6>
            </div>
            <div class="row" style="padding-right:30px">
              <div class="col">
             
              <a href="" class="badge badge-success"> + </a>
              </div>
              <div class="col">
              <a href="" class="badge badge-danger"> - </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row"> 
          <div class="col">
          <div class="row">

          <div class="col">
            <div class="row">
              <h6 class="text-center">Vitesse</h6>
            </div>
            <div class="row">
              <h6 class="text-center">Intégrité</h6>
            </div>
            <div class="row">
              <h6 class="text-center">Bouclier</h6>
            </div>
          </div>

          <div class="col">
            <div class="row center-text">
              <h6 class="text-center">'.$fit_infos['Build_Maximum_Speed'].'</h6>
            </div>
            <div class="row">
              <h6 class="text-center">'.$fit_infos['Build_Integrity'].'</h6>
            </div>
            <div class="row">
              <h6 class="text-center">'.$fit_infos['Build_Shield_Size'].'</h6>
            </div>
          </div>
         </div>
       </div>
        <div class="col">
          <div class="row">
          <div class="col">
            <div class="row">
              <h6 class="text-center">portée</h6>
            </div>
            <div class="row">
              <h6 class="text-center">Cargo</h6>
            </div>
            <div class="row">
              <h6 class="text-center">Prix</h6>
            </div>
          </div>
          <div class="col">
            <div class="row">
              <h6 class="text-center">'.$fit_infos['Build_JumpRange'].' Al</h6>
            </div>
            <div class="row">
              <h6 class="text-center">'.$fit_infos['Build_Cargo'].' T</h6>
            </div>
            <div class="row">
              <h6 class="text-center">'.number_format($fit_infos['Build_Price']).'</h6>
            </div>
          </div>
        </div>
        </div>
      </div>
      </div>
      
      <button type="submit" class="btn btn-primary border-success bg-success"><a class="text-white" 
      href="'.$fit_infos['Build_URL'].'">Voir</a></button>

    </div>
  </div>
  ';   
}

