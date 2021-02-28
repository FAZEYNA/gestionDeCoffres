<?php
    session_start();
    require_once "../functions/function.php";
    require_once "../database/connection.php";

    extract($_POST);

    if(isset($connexion)) //GERE LA CONNEXION 
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

    if(isset($inscription)) // GERE L'INSCRIPTION
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

    if(isset($ajoutCoffre)) // GERE L'AJOUT DE COFFRES
    {
        if($cotisation>0 && $nbAdherent>0 && compareDates($datefin, $datedebut))
        {
            addCoffre($datedebut, $datefin, $nbAdherent, $cotisation, $idUtilisateur);
            $_SESSION["success"] = "Coffre ajouté avec succès !";
            header("Location:../listeCoffresTresorier.php");
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

    if(isset($deconnexion)) // GERE LA DECONNEXION 
    {
        session_destroy();
        unset($_SESSION["login"]);
        header("Location:../index.php");
    }

    if(isset($ajoutUserOuTresorier)) // GERE LAJOUT DUTILISATEUR OU DE TRESORIER VOIR PAGE AJOUTADHERENTS
    {
        if(isNumValid($telephone) && isStringAlpha($nom) && isStringAlpha($prenom) && !isLoginAlreadyTaken($login))
        {
            if($_SESSION["profil"] == "admin")
            {
                registerUser($nom, $prenom, $telephone, $login, $pass, $mail, $adresse, $usertype);
                $_SESSION["success"] = "Trésorier ajouté avec succès !";
                header("Location:../listeTresoriers.php");
            }
            elseif($_SESSION["profil"] == "tresorier")
            {
                //IL FAUT AUSSI RENSEIGNER LADHESION DANS LA TABLE utilisateur_coffre
                $infosCoffre = getInfoCoffres($idCoffreAdherent); //RECUPERE LES INFOS DU COFFRE
                if(getNumberOfAdherents($idCoffreAdherent)>=$infosCoffre["nbrAdherents"] || compareDates(date('Y-m-d'),$infosCoffre["dateFin"])) //verifie la validité du coffre
                {
                    $_SESSION["error"] = "Plus d'ajout d'adhérent possible !";
                }
                else
                {
                    $_SESSION["success"] = "Adhérent ajouté avec succès !";
                    AjoutAdherentParTresorier($idCoffreAdherent, $nom, $prenom, $telephone, $login, $pass, $mail, $adresse, $usertype);
                }
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

    if(isset($adherer)){ // GERE LADHESION D'UTILISATEURS
        addUtilisateurCoffre($idUtilisateur,$idCoffre);
        $_SESSION["success"] = "Vous avez été ajouté avec succès !";
        header("Location:../ListeDesCoffres.php");
    }

    if(isset($changerMotDePasse)) // GERE LES CHANGEMENTS DE MOT DE PASSE LORSQUE LE MDP == "passer"
    {
        if($pass != $pass2)
        {
            $_SESSION["error"] = "Les mots de passe doivent concorder !";
        }
        else
        {
            updatePassword($idUser,$pass);
            $_SESSION["success"] = "Mot de passe modifié avec succès !";
            unset($_SESSION["login"]);
        }
        header("Location:../changerMotDePasse.php");
    }

    if(isset($supprimer)) // GERE LA SUPPRESSION D'ADHERENT
    {
        deleteAdherent($idUC);
        $_SESSION["success"] = "Adhérent supprimé avec succès !";
        header("Location:../listeCoffresTresorier.php");
    }

    if(isset($supprimerTresorier)) // GERE LA SUPPRESSION DE TRESORIER
    {
        deleteTresorier($idTresorier);
        $_SESSION["success"] = "Tresorier supprimé avec succès !";
        header("Location:../listeTresoriers.php");
    }
?>