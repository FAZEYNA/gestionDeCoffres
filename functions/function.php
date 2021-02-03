<?php

    //Vérifier la validité du nom et du prénom
    function isStringAlpha($string)
    {
        $string = trim(strip_tags(htmlspecialchars(strtolower($string))));
        if(preg_match("/^[ \p{L}-]*$/u", $string)) //AVEC ACCENTS
            return true;
        else
            return false;
    }

    //VERIFICATION DE LA VALIDITÉ DU NUMÉRO DE TÉLÉPHONE
    function isNumValid($string)
    {
        if(preg_match('#^(78|77|76|70|33)[0-9]{7}$#', $string)) 
            return true;
        else
            return false;
    }

    // VERIFICATION DE L'EXISTENCE DU LOGIN ET DU MOT DE PASSE
    function getLoginAndPassword($login, $password)
    {
        global $db;
        $requete = "SELECT * FROM utilisateur WHERE login = '$login' AND mdp = '$password'";
        $reponse = $db->query($requete)->fetch();
        return $reponse;
    }
     
    //AJOUT D'ADHERENT DANS LA BD
    function registerUser($nom, $prenom, $telephone, $login, $mdp, $mail, $adresse, $idProfil)
    {
        global $db;
        $requete = "INSERT INTO utilisateur(idUtilisateur, nom, prenom, tel, login, mdp, adresse, mail, idProfilF) VALUES(null, '$nom', '$prenom', '$telephone', '$login', '$mdp', '$adresse', '$mail', $idProfil)" ;
        return $db->exec($requete);
    }

    //VERIFICATION DE LA REDONDANCE DU LOGIN
    function isLoginAlreadyTaken($login)
    {
        global $db;
        $login = strtolower($login);
        $requete =  $db->prepare('SELECT login FROM utilisateur WHERE login=?');
        $requete->execute(array($login));
        $reponse = $requete->fetch();
        return $reponse;
    }

    // ME RETOURNE LE NUMERO DE COFFRE PROCHAIN
    function getNumeroCoffre()
    {
        global $db;

        $requete = "SELECT MAX(numCoffre) FROM coffre"; 
        $rslt = $db->query($requete)->fetch(); //array
        $numCoffre = $rslt[0] + 1;
        return $numCoffre;
    }

    // ENREGISTRER UN COFFRE DANS LA BD
    function addCoffre($dateDebut, $dateFin, $nbAdherents, $cotisation, $idUtilisateur)
    {
        global $db;

        $numCoffre = getNumeroCoffre();
        $requete = "INSERT INTO coffre(idCoffre, numCoffre, dateDebut, dateFin, nbrAdherents, cotisation, idUtilisateurF) VALUES(null, '$numCoffre', '$dateDebut', '$dateFin', '$nbAdherents', '$cotisation', '$idUtilisateur')" ;

        return $db->exec($requete);
    }

    // Retourne l'id de l'utilisateur connecté
    function getIdUtilisateur($login)
    {
        global $db;
        $requete = $db -> prepare("SELECT idUtilisateur FROM utilisateur WHERE login=?");
        $requete->execute(array($login));
        $reponse = $requete->fetch();
        return intval($reponse[0]); // j'avais un string j'étais obligé de caster car l'id c'est un integer
    }

    // Retourne le numéro de téléphone de l'utilisateur connecté
    function getTelephone($login)
    {
        global $db;
        $requete = $db -> prepare("SELECT tel FROM utilisateur WHERE login=?");
        $requete->execute(array($login));
        $reponse = $requete->fetch();
        return intval($reponse[0]);
    }

    // Compare les dates de début et de fin
    function compareDates($datefin, $dateDebut)
    {
        return (strtotime($datefin)-strtotime($dateDebut))>0;
    }

    // RETOURNE UN TABLEAU CONTENANT TOUS LES COFFRES DE LA BD
    function getTousLesCoffres()
    {
        global $db;
        $requete = "SELECT * FROM coffre, utilisateur WHERE coffre.idUtilisateurF = utilisateur.idUtilisateur ORDER BY numCoffre";
        $reponse = $db->query($requete)->fetchAll(PDO::FETCH_ASSOC);
        return $reponse;
    }

    // RETOURNE UN TABLEAU CONTENANT TOUS LES COFFRES CREES PAR UN TRESORIER
    function getCoffresTresorier($login)
    {
        global $db;
        $requete = $db -> prepare("SELECT * FROM coffre, utilisateur WHERE coffre.idUtilisateurF = utilisateur.idUtilisateur AND login=? ORDER BY numCoffre");
        $requete->execute(array($login));
        $reponse = $requete->fetchAll();
        return $reponse;
    }

    //RETOURNE LA DIFFERENCE DE JOURS ENTRE DEUX DATES
    function dateDiff($date1, $date2){
        return (strtotime($date2) - strtotime($date1)) / (24 * 60 * 60); 
    }

    //RETOURNE LE PROFIL DE L'UTILISATEUR CONNECTÉ
    function getProfilUser($login)
    {
        global $db;
        $requete = $db -> prepare("SELECT nomProfil FROM utilisateur,profil WHERE utilisateur.idProfilF = profil.idProfil AND login=?");
        $requete->execute(array($login));
        $reponse = $requete->fetch();
        return $reponse[0];
    }

    //RETOURNE TOUS LES TRESORIERS
    function getTresoriers()
    {
        global $db;
        $requete = "SELECT * FROM utilisateur, profil WHERE utilisateur.idProfilF = profil.idProfil AND idProfilF=2";
        $reponse = $db->query($requete)->fetchAll(PDO::FETCH_ASSOC);
        return $reponse;
    }

    //AJOUT D'ADHERENTS AUX COFFRES, IDCOFFRES YI MARCHEIGOUL NAK
    function addUtilisateurCoffre($idUtilisateur, $idCoffre){
        global $db;
        $requete = "INSERT INTO utilisateur_coffre(idUC, idUtilisateurF, idCoffreF) VALUES(null, '$idUtilisateur', '$idCoffre')" ;
        return $db->exec($requete);
    }

    // function isAdherentAlreadyInCoffre($idUtilisateur, $coffre){
    //     global $db;
    //     $requete = $db -> prepare("SELECT idUtilisateurF=?, idCoffre=? FROM utilisateur_coffre");
    //     $requete->execute(array($idUtilisateur,$coffre));
    //     $reponse = $requete->fetch();
    //     return $reponse[0];
    // }







    function getAdherents($numCoffre)
    {
        global $db;
        $requete = $db -> prepare("SELECT * FROM coffre, utilisateur WHERE coffre.idUtilisateurF = utilisateur.idUtilisateur AND numCoffre=?");
        $requete->execute(array($numCoffre));
        $reponse = $requete->fetchAll();
        return $reponse;
    }

?>