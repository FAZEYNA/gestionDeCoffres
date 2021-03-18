<?php
    session_start();
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
    $id = $_SESSION["login"];
    $idUser = getIdUtilisateur($id);
    $telephoneUser = getTelephone($id);    
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

<div class="container mt-3">
    <p class="display-4 text-center mb-4">Ajout de coffres</p>
    <form method="POST" action="controller/controller.php"> 
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Numéro</label>
                    <input type="number" class="form-control" id="numero" name="numero" disabled value="<?= getNumeroCoffre()?>">
                </div>
                <div class="form-group">
                    <label for="">Durée</label>
                    <input type="text" class="form-control" id="duree" name="duree" disabled >
                </div>
                <div class="form-group">
                    <label for="">Côtisation (*) </label>
                    <input type="number" min="500" max="50000" class="form-control" id="cotisation" name="cotisation" required>
                </div>
                <div class="form-group">
                    <label for="">Montant</label>
                    <input type="number" min="1" class="form-control" id="montant" name="montant" disabled value="">
                </div>
                <button type="submit" name="ajoutCoffre" class="btn btn-outline-dark shadow-none">Ajouter</button>
            </div>
    
            <div class="col-sm-6">   
                <div class="form-group">
                    <label for="">Date début (*)</label>
                    <input type="date" min="<?= date("Y-m-d")?>" class="form-control" id="datedebut" name="datedebut" required>
                </div>
                <div class="form-group">
                    <label for="">Date fin (*)</label>
                    <input type="date" min="<?= date("Y-m-d")?>" class="form-control" id="datefin" name="datefin" required>
                </div>
                <div class="form-group">
                    <label for="">Nombre d'adhérents (*)</label>
                    <input type="number" min="2"  max="20" class="form-control" id="nbAdherent" name="nbAdherent" required>
                </div>
                <div class="form-group">
                    <label for="">Contact (*)</label>
                    <input type="text" class="form-control" id="contact" name="contact"  value="<?= $telephoneUser?>" disabled>
                </div>
                <div class="form-group" hidden>
                    <label for="">idUtilisateur</label>
                    <input type="text" class="form-control" id="idUtilisateur" name="idUtilisateur" value="<?= $idUser?>">
                </div>
                <a href='listeCoffresTresorier.php' class="btn btn-outline-dark mb-4 float-right">retour</a>
            </div>
        </div>
    </form>
    </div>
<?php include_once "footer.php"?>
