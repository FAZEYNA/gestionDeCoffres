<?php
    session_start(); // Je démarre ma session
    require_once "functions/function.php"; // J'inclus mon fichier de fonctions
    require_once "database/connection.php"; // J'inclus mon fichier de connexion à ma BD
    include_once "header.php";
    $tabCoffres = getTousLesCoffres();
?>

<!-- Image and text -->
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top">
    </a>
    <div class="float-right d-flex flex-row">
        <a class="btn btn-outline-light mr-2" data-toggle="modal" data-target="#myModal" >Connexion</a>
        <form method="POST" action="controller/controller.php">
            <button type="submit" class="btn btn-outline-danger shadow-none" name="deconnexion">Deconnexion</button>   
        </form>
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

<div class="container">  
    <?php 
        if(isset($_SESSION["error"]) && $_SESSION["error"] != "")
        {
            echo "<h4 class='text-danger text-center mb-4 mt-3'>".$_SESSION["error"]."</h4>";
            unset($_SESSION["error"]);
        }
        if(isset($_SESSION["success"]) && $_SESSION["success"] != "")
        {
            echo "<h4 class='text-success text-center mb-4 mt-3'>".$_SESSION["success"]."</h4>";
            unset($_SESSION["success"]);
        }
    ?>
    <p class="display-4 text-center mb-4 mt-3">Liste des coffres disponibles</p>
    <form method="POST" action="controller/controller.php">
    <div class="row mt-3">
        <?php foreach($tabCoffres as $t){?>
        <div class="col-4 mt-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title p-3">Coffre N°<?=$t["numCoffre"]?></h5>
                    <p class="card-text">Date de début : <?=$t["dateDebut"]?> </p>
                    <p class="card-text">Date de fin : <?=$t["dateFin"]?></p>
                    <p class="card-text">Durée : <?= dateDiff($t["dateDebut"],$t["dateFin"])?> jours</p>
                    <p class="card-text">Côtisation : <?=$t["cotisation"]?> Francs</p>
                    <p class="card-text">Montant : <?=$t["cotisation"] * $t["nbrAdherents"]?> Francs</p>
                    <p class="card-text">Nombre d'Adhérents : <?=$t["nbrAdherents"]?></p>
                    <input type="number"  value="<?=$t["idCoffre"]?>" name="idCoffre">
                    <input type="number" hidden value="<?php if (isset($_SESSION["login"])){echo getIdUtilisateur($_SESSION["login"]);} ?>" name="idUtilisateur">
                    <?php 
                        if(isset($_SESSION["login"]) )
                        {
                            echo '<button type="submit" name="adherer" class="btn btn-outline-dark float-right">Adhérer</button">';
                        }
                        else
                        {
                            echo '<a data-toggle="modal" data-target="#myModal" class="btn btn-outline-dark float-right">Adhérer</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php }?>
</div>
</form>


<?php include_once "footer.php"?>
