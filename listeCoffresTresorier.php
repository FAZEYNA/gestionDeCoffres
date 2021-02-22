<?php
    session_start();
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
    $id = $_SESSION["login"];
    $tabCoffres = getCoffresTresorier($id);
?>

<!-- Image and text -->
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top">
    </a>
    <form method="POST" action="controller/controller.php">
        <button type="submit" class="btn btn-outline-danger shadow-none" name="deconnexion">Deconnexion</button>   
    </form>
  </div>
</nav>

<?php

?>
<div class="container">  
    <?php
        if(isset($_SESSION["success"]) && $_SESSION["success"] != "")
        {
            echo "<h4 class='text-success text-center mb-4 mt-3'>".$_SESSION["success"]."</h4>";
            unset($_SESSION["success"]);
        }
    ?>
    <p class="display-4 text-center mb-3 mt-3">Liste des coffres</p>
    <a href='ajoutCoffre.php' class="btn btn-outline-dark mb-4 ">Ajouter un coffre</a>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
            <tr class="table-primary text-center">
                <th scope="col">N°</th>
                <th scope="col">Date de début</th>
                <th scope="col">Durée</th>
                <th scope="col">Nombre d'adhérents</th>
                <th scope="col">Montant</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($tabCoffres as $t) { ?>
                    <tr class="text-center">
                        <td><?=$t["numCoffre"]?></td> 
                        <td><?=$t["dateDebut"]?></td>
                        <td><?= dateDiff($t["dateDebut"],$t["dateFin"])?> jours</td>
                        <td><?=$t["nbrAdherents"]?></td>
                        <td><?=$t["nbrAdherents"] * $t["cotisation"]?></td>
                        <!-- CREATION DUN PETIT FORMULAIRE QUI VA NOUS REDIRIGER VERS LA PAGE ajoutAdherents.php AVEC UN BOUTON QUI AURA LA VALEUR DE L'ID COFFRE ACTUEL -->
                        <form method="POST" action="ajoutAdherents.php">
                        <td><button type="submit" class="btn btn-block btn-outline-dark" name="idCoffre" value="<?=$t["idCoffre"]?>">ajouter</button></td>
                        </form>
                        <td><a data-toggle="modal" data-target="#myModal-<?=$t["numCoffre"]?>" class="btn btn-block btn-outline-dark">voir</a></td>
                          <!-- Modal -->
                        <div class="modal fade" id="myModal-<?=$t["numCoffre"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-<?=$t["numCoffre"]?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel-<?=$t["numCoffre"]?>">Liste des Adhérents</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <div class="modal-body">
                                    <?php
                                      $adherentsDuCoffre = getAdherents($t["numCoffre"]);                  
                                   ?> 
                                    <div class="flex-row d-flex text-center mb-4">
                                        <div class="col">Nom</div>
                                        <div class="col">Prénom(s)</div>
                                        <div class="col">Téléphone</div>
                                        <div class="col">Action</div>
                                    </div>
                                    <?php foreach($adherentsDuCoffre as $a){?>
                                    <div class="flex-row d-flex text-center mb-3">
                                      <div class="col"><?= $a["prenom"]?></div>
                                      <div class="col"><?= $a["nom"]?></div>
                                      <div class="col"><?= $a["tel"]?></div>  
                                      <div class="col" hidden><input type="text" value="<?=$a["idUC"]?>" name="idUC"></div>  
                                      <div class="col"><button type="button" class="btn btn-outline-danger shadow-none" data-toggle="modal" data-target="#exampleModal-<?=$a["idUC"]?>">Supprimer</button></div> 
                                        <!-- Ajout d'un Modal pour confirmer la suppression d'adherent -->
                                        <div class="modal fade" id="exampleModal-<?=$a["idUC"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-<?=$a["idUC"]?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel-<?=$a["idUC"]?>">Suppression</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <p>Voulez-vous vraiment supprimer l'adhérent(e) <?= $a["prenom"]. " " .$a["nom"]?> ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <form method="POST" action="controller/controller.php">
                                                <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
                                                    <input hidden type="text" name="idUC" value="<?=$a["idUC"]?>">
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                  <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </tr>
                <?php }?>
            </tbody>
        </table>
         
</div>

<?php include_once "footer.php"?>
