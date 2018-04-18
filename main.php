<?php
require_once "functions.php";

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
      <link rel="stylesheet" href="css/bootstrap.css">
  </head>
  <body>
    <header>
            <script src="js/jquery.min.js"></script>
      <script src="js/popper.js"></script>
      <script src="js/bootstrap.min.js"></script>
<?php header_nav_bar(0, user_is_connected()) ?>

    <div class="alert alert-warning" role="alert">
        Le site est en développement, en cas de problème merci d'utiliser le lien en bas de page pour reporter un bug.
    </div>

      <h1 class="text-center"> Galanews</h1>
    <?php script_list(); ?>
    </header>

<div class="container mt-5">
  <div class="row">

    <div class="col-10">
      <div class="news">
        <h3 class="text-center">Dernières nouvelles : </h3>
      </div>
    </div>
    <div class="col">
      <div class="row">
        <div class="col">
        <?php echo '<img  class="media-object" style="width:100px" src="profile/users_data/'.$user.'/icon.png">'; ?>
        <?php echo "<p>bonjour ".$user."</p>"; ?>
        </div>
      </div>
    </div>
  </div>
</div>



  </body>
</html>

