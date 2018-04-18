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


try 
{
  $bdd = new PDO('mysql:host=localhost;dbname=galanews;charset=utf8', 'root','');
}
catch (Exception $e)
{
  die('Erreur : ' . $e ->getMessage());
}


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
    <?php header_nav_bar(1, user_is_connected()); ?>
    <div class="alert alert-warning" role="alert">
        Le site est en développement, en cas de problème merci d'utiliser le lien en bas de page pour reporter un bug.
    </div>     
  </header>
      

    <div class="container">
      <div class="row">
        <div class="col">
          <a href="coriolisfits.php"><h6> < retour</h6></a>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h1 class="mt-4 mb-4">Ajouter un fit :</h1>
          <script src="js/fitvote.js"></script>
          <?php script_list(); ?>
        </div>
      </div>
    <div class="row">
      <div class="col">




<div class="container">
  <form method="POST" action="Add_Coriolis_fit_verif.php">
  <div class="row">
    <div class="col">
        <div class="form-group mb-2">
          <select name="Ship" class="custom-select custom-select-lg mb-3">
            <option  value="Eagle" selected >Eagle</option>
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
          <select name="Category" class="custom-select custom-select-lg mb-3">
            <option value="Multi-Roles" selected>Multi-roles</option>
            <option value="Exploration">Exploration</option>
            <option value="Combat">Combat</option>
            <option value="Marchand">Marchand</option>
            <option value="Chasse aux xenomorphes">Chasse aux xenomorphes</option>
            <option value="Scientifique">Scientifique</option>
            <option value="Autre">Autre</option>
          </select>
        </div>         
    </div>

  </div>
  <div class="row">
    <div class="col">
        <div class="form-group">
          <label for="Maximum_Speed">Vitesse Maximum :</label>
          <input type="number" name="Ship_Max_Speed" class="form-control" id="Maximum_Speed" placeholder="200">
        </div>      
    </div>
    <div class="col">
        <div class="form-group">
          <label for="Boost_Speed">Vitesse (Boost) :</label>
          <input type="number" name="Ship_Boost_Speed" class="form-control" id="Boost_Speed" placeholder="350">
        </div>        
    </div>

  </div>
  <div class="row">
    <div class="col">
        <div class="form-group">
          <label for="Cargo_Size">Cargo :</label>
          <input type="number" name="Ship_Cargo_Size" class="form-control" id="Cargo_Size" placeholder="64">
        </div>  
    </div>
    <div class="col">
        <div class="form-group">
          <label for="Ship_Integrity">Intégrité :</label>
          <input type="number" name="Ship_Integrity" class="form-control" id="Ship_Integrity" placeholder="3400">
        </div>      
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="Ship_Price">Prix :</label>
        <input type="number" name="Ship_Price" class="form-control" id="Ship_Price" placeholder="10000000">
      </div>       
    </div>
    <div class="col">
        <div class="form-group">
          <label for="Shield_Value">Bouclier :</label>
          <input type="number" name="Ship_Shield_Value" class="form-control" id="Shield_Value" placeholder="200">
        </div>   
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="Build_Name">Nom du build :</label>
        <input type="number" name="Build_Name" class="form-control" id="Build_Name" placeholder="Cute eur de combat...">
      </div>       
    </div>
    <div class="col">
        <div class="form-group">
          <label for="Fit_Link">lien coriolis :</label>
          <input type="text" name="Build_Link" class="form-control" id="Fit_Link" placeholder="https://coriolis.edcd.io/...">
        </div>   
    </div>

  </div>
  <div align="center">
     <button type="submit" class="btn btn-primary">Ajouter</button>
  </div>
</form>
</div>

</body>
</html>
