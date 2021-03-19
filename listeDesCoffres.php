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

<div class="container animate__animated animate__slideInDown">  
    <?php 
        if(isset($_SESSION["error"]) && $_SESSION["error"] != "")
        {
            echo "<h5 class='alert alert-danger font-italic mt-3' role='alert'>".$_SESSION["error"]."</h5>";
            unset($_SESSION["error"]);
        }
        if(isset($_SESSION["success"]) && $_SESSION["success"] != "")
        {
            echo "<h5 class='alert alert-success font-italic mt-3' role='alert'>".$_SESSION["success"]."</h5>";
            unset($_SESSION["success"]);
        }
    ?>
    <?php
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $pageCourante = (int) strip_tags($_GET['page']);
        }else{
            $pageCourante = 1;
        }
        $pas = 3; //3 Coffres par page
        $nbCoffres = getNumberOfCoffres(); //nbr total de Coffres 
        $nbPages = ceil($nbCoffres / $pas); //nombre total de pages
        $premier = ($pageCourante * $pas) - $pas;
        $tabCoffres = getCoffresParPage($premier,$pas);
    ?>
    <!-- J'ai eu un soucis pour recupérer les ID DE COFFRES LA SOLUTION ETAIT DE METTRE POUR CHAQUE COFFRE UN FORMULAIRE -->
    <p class="display-4 text-center mb-3 mt-2">Liste des coffres disponibles</p>
    <div class="row mt-3">
        <?php foreach($tabCoffres as $t){?>
            <div class="col-4 mt-3">
            <form method="POST" action="controller/controller.php">
                <div class="card border-dark">
                    <div class="card-body">
                        <h5 class="card-title p-3">Coffre N°<?=$t["numCoffre"]?></h5>
                        <p class="card-text">Date de début : <?=$t["dateDebut"]?> </p>
                        <p class="card-text">Date de fin : <?=$t["dateFin"]?></p>
                        <p class="card-text">Durée : <?= dateDiff($t["dateDebut"],$t["dateFin"])?> jours</p>
                        <p class="card-text">Côtisation : <?=$t["cotisation"]?> Francs</p>
                        <p class="card-text">Montant : <?=$t["cotisation"] * $t["nbrAdherents"]?> Francs</p>
                        <p class="card-text">Nombre d'Adhérents : <?=$t["nbrAdherents"]?></p>
                        <input type="number" hidden value="<?=$t["idCoffre"]?>" name='idCoffre'>
                        <input type="number" hidden value="<?php if (isset($_SESSION["login"])){echo getIdUtilisateur($_SESSION["login"]);} ?>" name="idUtilisateur">
                        <?php 
                            //Ne pas oublier qu'un coffre est disponible si le nombre d’adhérents et la date d’échéance ne sont pas atteints
                            if(isset($_SESSION["login"]) && (isAdherentAlreadyInCoffre(getIdUtilisateur($_SESSION["login"]), $t["idCoffre"]) || getNumberOfAdherents($t["idCoffre"])>=$t["nbrAdherents"] || compareDates(date('Y-m-d'),$t["dateFin"])))
                            {
                                echo '<button type="submit" name="adherer" disabled class="btn btn-outline-dark float-right">Adhérer</button">';
                            }
                            else if(isset($_SESSION["login"]))
                            {
                                echo '<button type="submit" name="adherer" class="btn btn-outline-dark float-right">Adhérer</button">';
                            }
                            elseif(!isset($_SESSION["login"]) )
                            {
                                echo '<a data-toggle="modal" data-target="#myModal" class="btn btn-outline-dark float-right">Adhérer</a>';
                            }
                        ?>
                    </div>
                </div>
            </form>
            </div>
        <?php }?>
    </div>
    <nav class="float-right mt-1">
        <ul class="pagination">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($pageCourante == 1) ? "disabled" : "" ?>">
                <a href="./listeDesCoffres.php?page=<?= $pageCourante - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $nbPages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($pageCourante == $page) ? "active" : "" ?>">
                    <a href="./listeDesCoffres.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($pageCourante == $nbPages) ? "disabled" : "" ?>">
                <a href="./listeDesCoffres.php?page=<?=$pageCourante + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>

<?php include_once "footer.php"?>
