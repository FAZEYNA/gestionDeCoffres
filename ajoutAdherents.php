<?php
    session_start();
    require_once "functions/function.php";
    require_once "database/connection.php";
    include_once "header.php";
    extract($_POST);
?>
    <!-- Image and text -->
    <nav class="navbar navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo.png " alt="logo" width="90" height="54" class="d-inline-block align-top">
        </a>
        <div class="float-right d-flex flex-row">
            <form method="POST" action="controller/controller.php">
                <button type="submit" class="btn btn-outline-danger shadow-none" name="deconnexion">Deconnexion</button>   
            </form>
        </div>
    </div>
    </nav>

    <div class="container mt-5">
        <h5 class="mb-4">AJOUT</h5>
        <?php 
            if(isset($_SESSION["error"]) && $_SESSION["error"] != "")
            {
                echo "<h4 class='text-danger text-center mb-4 mt-3'>".$_SESSION["error"]."</h4>";
                unset($_SESSION["error"]);
            }
        ?>
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
                        <label for="">Téléphone (*)</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <form method="POST" action="controller/controller.php">
                        <button type="submit" class="btn btn-outline-dark shadow-none" name="ajoutUserOuTresorier">Ajouter</button>
                    </form>
                </div>
        
                <div class="col-sm-6">   
                    <div class="form-group">
                        <label for="">Nom d'utilisateur (*)</label>
                        <input type="text" class="form-control" id="login" name="login" required>
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
                        <input type="text" class="form-control" id="pass" name="pass" value="passer" required>
                    </div>
                    <div class="form-group" hidden> <!--AJOUT D'UNE DIVISION QUI VA NOUS FOURNIR L'ID DU COFFRE DANS LEQUEL NS DEVONS AJOUTER L'ADHERENT-->
                        <label for="">ID COFFRE</label>
                        <input type="text" class="form-control" id="idCoffreAdherent" name="idCoffreAdherent" value="<?php if(isset($_POST["idCoffre"])) echo $_POST["idCoffre"];?>" >
                    </div>
                    <div class="form-group" hidden>
                        <label for="">UserType</label>
                        <?php 
                         if($_SESSION["profil"] == "admin") 
                            echo '<input type="text" class="form-control" id="usertype" name="usertype" value="2" >';
                         elseif($_SESSION["profil"] == "tresorier") 
                            echo '<input type="text" class="form-control" id="usertype" name="usertype" value="3" >';
                        ?>
                    </div>
                    <?php
                        if($_SESSION["profil"] == "admin")
                            echo '<a href="listeTresoriers.php" class="btn btn-outline-dark mb-4 float-right">retour</a>';
                        elseif($_SESSION["profil"] == "tresorier")
                            echo '<a href="listeCoffresTresorier.php" class="btn btn-outline-dark mb-4 float-right">retour</a>';
                    ?>
                </div>
            </div>
        <form>
    </div>
<?php include_once "footer.php"?>
