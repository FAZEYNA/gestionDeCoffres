<?php
    session_start();
    require_once "../functions/function.php";
    require_once "../database/connection.php";

    extract($_POST);

    if(isset($connexion))
    {
        if(getLoginAndPassword($login,$password)){
            $_SESSION["login"] = $login;
            $_SESSION["profil"] = getProfilUser($login);
            if($password == "passer")
            {
                header("Location:../changerMotDePasse.php");              
            }
            elseif($_SESSION["profil"] == "admin")
            {
                $_SESSION["success"] = "Bienvenue ".ucfirst($login)." ! Content de vous voir.";
                header("Location:../listeTresoriers.php");   
            }
            elseif($_SESSION["profil"] == "tresorier")
            {
                $_SESSION["success"] = "Bienvenue ".ucfirst($login)." ! Content de vous voir.";
                header("Location:../listeCoffresTresorier.php");   
            }
            elseif($_SESSION["profil"] == "user")
            {
                $_SESSION["success"] = "Bienvenue ".ucfirst($login)." ! Content de vous voir.";
                header("Location:../listeDesCoffres.php");
            }
        }
        else
        {
            $_SESSION["error"] = "Login et/ou mot de passe incorrects !";
            header("Location:../listeDesCoffres.php");
        }
    }

    if(isset($inscription))
    {
        if(isNumValid($telephone) && isStringAlpha($nom) && isStringAlpha($prenom) && !isLoginAlreadyTaken($login) && $pass===$pass2)
        {
            registerUser($nom, $prenom, $telephone, $login, $pass, $mail, $adresse, $usertype);
            $_SESSION["login"] = $login;
            $_SESSION["success"] = "Bienvenue ".ucfirst($login)." ! Content de vous voir.";
            header("Location:../listeDesCoffres.php");
        }
        else
        {
            if(!isNumValid($telephone))
            {
                $_SESSION["error"] = "Le numéro de téléphone est invalide !";
            }
            elseif(!isStringAlpha($nom))
            {
                $_SESSION["error"] = "Le nom est incorrect !";
            }
            elseif(!isStringAlpha($prenom))
            {
                $_SESSION["error"] = "Le prénom est incorrect !";
            }
            elseif(isLoginAlreadyTaken($login))
            {
                $_SESSION["error"] = "Login déjà utilisé !";
            }
            else
            {
                $_SESSION["error"] = "Les mots de passe doivent concorder !";
            }
            header("Location:../inscription.php");
        }
    }

    if(isset($ajoutCoffre))
    {
        if($cotisation>0 && $nbAdherent>0 && compareDates($datefin, $datedebut))
        {
            addCoffre($datedebut, $datefin, $nbAdherent, $cotisation, $idUtilisateur);
            $_SESSION["success"] = "Coffre ajouté avec succès !";
            header("Location:../AjoutCoffre.php");
        }
        else
        {
           if(!compareDates($datefin, $datedebut))
            {
                $_SESSION["error"] = "La date de début et/ou de fin sont invalides !";
            }
            header("Location:../AjoutCoffre.php");
        }
    }

    if(isset($deconnexion))
    {
        session_destroy();
        unset($_SESSION["login"]);
        header("Location:../index.php");
    }

    if(isset($ajoutUserOuTresorier))
    {
        if(isNumValid($telephone) && isStringAlpha($nom) && isStringAlpha($prenom) && !isLoginAlreadyTaken($login))
        {
            registerUser($nom, $prenom, $telephone, $login, $pass, $mail, $adresse, $usertype);
            if($_SESSION["profil"] == "admin")
            {
                $_SESSION["success"] = "Trésorier ajouté avec succès !";
                header("Location:../listeTresoriers.php");
            }
            elseif($_SESSION["profil"] == "tresorier")
            {
                //
                $_SESSION["success"] = "Adhérent ajouté avec succès !";
                header("Location:../listeCoffresTresorier.php");
            }
        }
        else
        {
            if(!isNumValid($telephone))
            {
                $_SESSION["error"] = "Le numéro de téléphone est invalide !";
            }
            elseif(!isStringAlpha($nom))
            {
                $_SESSION["error"] = "Le nom est incorrect !";
            }
            elseif(!isStringAlpha($prenom))
            {
                $_SESSION["error"] = "Le prénom est incorrect !";
            }
            elseif(isLoginAlreadyTaken($login))
            {
                $_SESSION["error"] = "Login déjà utilisé !";
            }
            header("Location:../ajoutAdherents.php");
        }
    }

    if(isset($adherer)){
        addUtilisateurCoffre($idUtilisateur,$idCoffre);
        $_SESSION["success"] = "Vous avez été ajouté avec succès !";
        header("Location:../ListeDesCoffres.php");
    }

    if(isset($changerMotDePasse))
    {
        if($pass != $pass2)
        {
            $_SESSION["error"] = "Les mots de passe doivent concorder !";
        }
        else
        {
            $_SESSION["success"] = "Mot de passe modifié avec succès !";
        }
        header("Location:../changerMotDePasse.php");
    }
?>