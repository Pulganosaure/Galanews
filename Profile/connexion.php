    <?php
require_once "../functions.php";

    session_start();
    if(isset($_SESSION['username']))
    {
    header("Location: ../main.php");
    }
    ?>

    <!doctype html>
    <html lang="en">
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

      <h1 class="mt-4 mb-4">Connexion :</h1>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <?php script_list(); ?>

      <form method="post" action="connexion_verif.php">
        <div class="form-group">
          <label for="exampleInputEmail1">nom de commandant</label>
          <input type="text" name="username" class="form-control" placeholder="nom de commandant">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Mot de passe :</label>
          <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
        <a class="text-primary" href="">mot de passe oublié?</a>
      </form>


      </div>
    </div>
  </div>

    </body>
    </html>



