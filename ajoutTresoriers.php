<?php
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
    $jour = date("d");
    $mois = date("m");
    $an = date("Y");
    $dateAujourdhui = $an."-".$mois."-".$jour;
?>
    <!-- Image and text -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top">
            </a>
        </div>
        <div class="float-right d-flex flex-row">
            <form method="POST" action="controller/controller.php">
                <button type="submit" class="btn btn-outline-danger shadow-none" name="deconnexion">Deconnexion</button>   
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h5 class="mb-4">AJOUT DE TRESORIERS</h5>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Nom (*)</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="">Prénom (*)</label>
                    <input type="text" class="form-control" id="prenom" name="prenom"required >
                </div>
                <div class="form-group">
                    <label for="">Téléphone (*)</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <button type="submit" class="btn btn-outline-dark shadow-none">Ajouter</button>
            </div>
    
            <div class="col-sm-6">   
                <div class="form-group">
                    <label for="">Nom d'utilisateur (*)</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="">Courrier électronique</label>
                    <input type="text" class="form-control" id="mail" name="mail" >
                </div>
                <div class="form-group">
                    <label for="">Adresse </label>
                    <input type="text" class="form-control" id="adresse" name="adresse">
                </div>
                <div class="form-group" hidden>
                    <label for="">Mot de passe</label>
                    <input type="text" class="form-control" id="pass" name="pass" required>
                </div>
                <div class="form-group" hidden>
                    <label for="">UserType</label>
                    <input type="text" class="form-control" id="" name="" >
                </div>
                 <a href='listeTresoriers.php' class="btn btn-outline-dark mb-4 float-right">retour</a>
            </div>
        </div>
    </div>
                        
   
<?php include_once "footer.php"?>
