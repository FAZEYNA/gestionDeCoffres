# gestionDeCoffres
➢ Espace Admin:
L'administrateur quand il se connecte, il pourra :
• Créer un compte au trésorier
• Lister les comptes trésoriers
• Supprimer un compte
• Sur la liste des trésoriers (proposer un bouton pour voir les coffres créés par chaque
trésorier)
➢ Espace Trésorier
Le trésorier peut :
• Ajouter un coffre
• Lister les coffres qu’il a créé
• Ajouter un adhérent dans un coffre
• Voir les détails d'un coffre (proposer un bouton pour voir les adhérents à un coffre)
• Modifier le nombre d’adhérents
NB: la cotisation par personne n'est pas modifiable.
➢ Espace Visiteur quelconque
Le visiteur doit voir :
• La liste des coffres disponibles
• Voir les détails d'un coffre
• Adhérer sur un coffre
NB:
- A son adhésion il doit obligatoirement se connecter s'il a un compte sinon on lui propose d'en
créer un.
- Un coffre est disponible s’il le nombre d’adhérents et la date d’échéance ne sont pas atteints.
- Un visiteur peut adhérer à plusieurs coffres mais ne peut pas adhérer à même coffre plusieurs
fois.
Schéma de la base de données :
Profil(idProfil, nomProfil)
Utilisateur(idUtilisateur, nom, prenom, tel, login, mdp, #idProfil)
Coffre(idCoffre, numCoffre, dateDebut, dateFin, nbAdherents, duree, idUtilisateurF,cotisation)
Utilisateur_Coffre(idUC, #idUtilisateurF, #idCoffreF)
