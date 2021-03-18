<?php
    session_start();
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
?>
    <!-- Image and text -->
    <nav class="navbar navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top">
        </a>
    </div>
    </nav>

    <div class="container mt-5">
        <?php 
            if(isset($_SESSION["error"]) && $_SESSION["error"] != "")
            {
                echo "<h5 class='alert alert-danger font-italic mt-4' role='alert'>".$_SESSION["error"]."</h5>";
                unset($_SESSION["error"]);
            }
        ?>
        <h5 class="mb-4">INSCRIPTION</h5>
        <form method="POST" action="controller/controller.php">
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
                    <label for="">Adresse </label>
                    <input type="text" class="form-control" id="adresse" name="adresse">
                </div>
                <div class="form-group">
                    <label for="">Téléphone (*)</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <button type="submit" class="btn btn-outline-dark shadow-none" name="inscription">S'inscrire</button>
            </div>
    
            <div class="col-sm-6">   
                <div class="form-group">
                    <label for="">Courrier électronique </label>
                    <input type="email" class="form-control" id="mail" name="mail" >
                </div>
                <div class="form-group">
                    <label for="">Nom d'utilisateur (*)</label>
                    <input type="text" class="form-control" id="username" name="login" required>
                </div>
                <div class="form-group">
                    <label for="">Mot de passe (*)</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <div class="form-group">
                    <label for="">Confirmez votre mot de passe (*)</label>
                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                </div>
                <div class="form-group" hidden>
                    <label for="">UserType</label>
                    <input type="text" class="form-control" id="usertype" name="usertype" value="3">
                </div>
                <a href='listeDesCoffres.php' class="btn btn-outline-dark mb-4 float-right">retour</a>
            </div>
        </div>
        </form>
    </div>
                        
   
<?php include_once "footer.php"?>
