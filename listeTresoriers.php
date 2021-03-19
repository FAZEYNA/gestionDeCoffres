<?php
    session_start();
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
    $tabTresoriers = getTresoriers();
?>

<!-- Image and text -->
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top animate__animated animate__jackInTheBox animate__slower">
    </a>
    <form method="POST" action="controller/controller.php">
      <button type="submit" class="btn btn-outline-danger shadow-none" name="deconnexion">Deconnexion</button>   
    </form>
  </div>

</nav>

<div class="container animate__animated animate__slideInDown animate__slow">  
    <?php
        if(isset($_SESSION["success"]) && $_SESSION["success"] != "")
        {
            echo "<h5 class='alert alert-success font-italic mt-4' role='alert'>".$_SESSION["success"]."</h5>";
            unset($_SESSION["success"]);
        }
    ?>
    <p class="display-4 text-center mb-3 mt-3">Liste des Trésoriers</p>
    <a href='ajoutAdherents.php' class="btn btn-outline-dark mb-4">Ajouter un Trésorier</a>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
            <tr class="table-primary text-center">
                <th scope="col" >Nom</th>
                <th scope="col">Prénom(s)</th>
                <th scope="col">Téléphone</th>
                <th scope="col" colspan="2" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
              <?php foreach($tabTresoriers as $t) {?>
                  <tr class="text-center">
                    <td><?= $t["nom"]?></td>
                    <td><?= $t["prenom"]?></td>
                    <td><?= $t["tel"]?></td>
                    <!-- LES ID ETAIENT SIMILAIRES, EN METTANT A CHAQUE FOIS LID DE LUTILISATEUR JE SPECIFIE LES COFFRES QUI APPARTIENNENT A CHACUN -->
                    <td><a data-toggle="modal" data-target="#myModal-<?=$t["idUtilisateur"] ?>" class="btn btn-block btn-outline-dark">voir</a> </td>                   
                    <!-- Modal -->
                        <div class="modal fade bs-example-modal-lg" id="myModal-<?=$t["idUtilisateur"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-<?=$t["idUtilisateur"]?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel-<?=$t["idUtilisateur"]?>">Liste des coffres</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                <div class="modal-body">
                                   <?php
                                      $coffresDuTresorier = getCoffresTresorier($t["login"]);                  
                                   ?> 
                                  <div class="flex-row d-flex text-center">
                                    <div class="col">Coffre N°</div>
                                    <div class="col">Début</div>
                                    <div class="col">Fin</div>
                                    <div class="col">Durée</div>                                     
                                    <div class="col">Côtisation</div>                                     
                                    <div class="col">Montant</div>                                                                         
                                  </div>
                                  <?php foreach($coffresDuTresorier as $c){?>
                                    <div class="flex-row d-flex text-center mt-2">
                                      <div class="col"><?= $c["numCoffre"]?></div>
                                      <div class="col"><?= $c["dateDebut"]?></div>
                                      <div class="col"><?= $c["dateFin"]?></div>
                                      <div class="col"><?= datediff($c["dateDebut"],$c["dateFin"])?> jours</div>                                     
                                      <div class="col"><?= $c["cotisation"]?> frs</div>                                     
                                      <div class="col"><?= $c["cotisation"] * $c["nbrAdherents"]?> frs</div>                                                                         
                                    </div>
                                  <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <td><a class="btn text-danger btn-block btn-outline-danger" data-toggle="modal" data-target="#myModal--<?=$t["idUtilisateur"] ?>">supprimer</a> </td>
                        <!-- Ajout d'un Modal qui gere la suppression de trésorier -->
                        <div class="modal fade bs-example-modal-md" id="myModal--<?=$t["idUtilisateur"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel--<?=$t["idUtilisateur"]?>" aria-hidden="true">
                          <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel--<?=$t["idUtilisateur"]?>">Suppression de trésorier</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <div class="modal-body">
                                <p>Voulez-vous vraiment supprimer le trésorier <?= $t['prenom']. " " .$t['nom']?> ?</p>
                              </div>
                              <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                              <form method="POST" action="controller/controller.php">
                                  <button type="submit" class="btn btn-danger" name="supprimerTresorier">Supprimer</button>
                                  <input hidden type="text" name="idTresorier" value="<?=$t['idUtilisateur']?>">
                              </form>
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
