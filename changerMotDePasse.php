<?php
    session_start(); // Je démarre ma session
    require_once "functions/function.php"; // J'inclus mon fichier de fonctions
    require_once "database/connection.php"; // J'inclus mon fichier de connexion à ma BD
    include_once "header.php";
?>

<!-- Image and text -->
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top animate__animated animate__jackInTheBox animate__slower">
    </a>
    <div class="float-right d-flex flex-row">
        <a class="btn btn-outline-light mr-2" data-toggle="modal" data-target="#myModal" >Connexion</a>
    </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Se connecter</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                <div class="modal-body">
                    <form class="form mt-3" method="POST" action="controller/controller.php">                    
                        <div class="form-group">
                          <label for="login">Login</label>
                          <input type="text" class="form-control" id="login" name="login">
                        </div>
                        <div class="form-group">
                          <label for="password">Mot de Passe</label>
                          <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <a href="inscription.php">Pas de compte? Inscrivez-vous.</a>
                        </div>
                        <button type="submit" class="btn btn-outline-dark shadow-none" name="connexion">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</nav>

<div class="container mt-5 animate__animated animate__slideInLeft animate__slow">  
  <?php 
    if(isset($_SESSION["error"]) && $_SESSION["error"] != "")
    {
      echo "<h5 class='alert alert-danger font-italic mt-4' role='alert'>".$_SESSION["error"]."</h5>";
      unset($_SESSION["error"]);
    }elseif(isset($_SESSION["success"]) && $_SESSION["success"] != "")
    {
        echo "<h5 class='alert alert-success font-italic mt-4' role='alert'>".$_SESSION["success"]."</h5>";
        unset($_SESSION["success"]);
    }
    ?>
  <h5 class="mb-4 mt-3">Changement du mot de passe</h5>
    <form method="POST" action="controller/controller.php">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="">Mot de passe (*)</label>
              <input type="password" class="form-control" id="pass" name="pass" required>
          </div>
          <div class="form-group">
            <label for="">Confirmez votre mot de passe (*)</label>
            <input type="password" class="form-control" id="pass2" name="pass2" required>
          </div>  
          <div class="form-group" hidden>
            <label for="">ID Utilisateur connecté</label>
            <input type="text" class="form-control" id="idUser" name="idUser" value="<?php if (isset($_SESSION["login"])){echo getIdUtilisateur($_SESSION["login"]);} ?>">
          </div>     
          <button type="submit" class="btn btn-outline-dark shadow-none" name="changerMotDePasse">Confirmer</button>
        </div>
      </div>
    </form>
</div>

<?php include_once "footer.php"?>
