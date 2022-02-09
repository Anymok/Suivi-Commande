<?php
// Connexion à la BDD
include 'conn.php';
// Ouverture de la session
session_start();
// Regarde si user est connecter
if(isset($_SESSION["user_login"]))	
{

    // Recupère la valeur du POST val
    $val=$_POST['val'];

    // Si correspond a C (commande) faire ...
    if ($val == "c") {
      // Recupère les valeur des champs
      $ID=$_POST['ID'];
      $Designation=$_POST['Designation'];
      $Destinataire=$_POST['Destinataire'];
      $site=$_POST['select'];
      $Fournisseur=$_POST['select-1'];
      $EtatLivraison=$_POST['select-2'];
      $ServiceFait=$_POST['select-3'];
      $dateDemandeAchat=$_POST['dateDemandeAchat'];
      $NumeroDemandeAchat=$_POST['NumeroDemandeAchat'];
      $dateValidation=$_POST['dateValidation'];
      $NumeroBonCommande=$_POST['NumeroBonCommande'];
      $dateBonCommande=$_POST['dateBonCommande'];
      $dateConfirmationCommande=$_POST['dateConfirmationCommande'];
      $dateLivraison=$_POST['dateLivraison'];
      $commentaire=$_POST['commentaire'];

        // si aucune erreur modifie la ligne de la commande existante
        if (!($stmt = $conn->prepare("UPDATE `commandes` SET `designation` = ".Null($Designation).", `destinataire` = ".Null($Destinataire).", `site` = ".Null($site).", `fournisseur` = ".Null($Fournisseur).", `EtatLivraison` = ".Null($EtatLivraison).", `ServiceFait` = ".Null($ServiceFait).", `dateDemandeAchat` = ".Null($dateDemandeAchat).", `numDemandeAchat` = ".Null($NumeroDemandeAchat).", `dateValidation` = ".Null($dateValidation).", `numBonCommande` = ".Null($NumeroBonCommande).", `dateBonCommande` = ".Null($dateBonCommande).", `dateConfirmationCommande` = ".Null($dateConfirmationCommande).", `dateLivraison` = ".Null($dateLivraison).", `commentaire` = ".Null($commentaire)." WHERE `commandes`.`ID` = $ID"))) {
          echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
        }
        else 
        {
          $stmt->execute();
        }
        
      //// Redirection automatique vers la page mère
      header('Location: ../commandes.php');
    }

    // Si val = f (fournisseur) faire...
    elseif ($val == "f")
    {
      // recupère les valeur des champs
      $ID=$_POST['ID'];
      $entreprise=$_POST['entreprise'];
      $prenom=$_POST['firstname'];
      $nom=$_POST['lastname'];
      $email=$_POST['email'];
      $phonefix=$_POST['phone'];
      $phonepor=$_POST['phone-1'];
      $site_web=$_POST['site-web'];
      $address=$_POST['address'];
      $cp=$_POST['cp'];
      $city=$_POST['city'];
      $pays=$_POST['pays'];

        // si aucune erreur modifie la ligne du fournisseur
        if (!($stmt = $conn->prepare("UPDATE `fournisseur` SET `Entreprise` = ".Null($entreprise).", `Nom` = ".Null($nom).", `Prenom` = ".Null($prenom).", `Email` = ".Null($email).", `Tel-fix` = ".Null($phonefix).", `Tel-por` = ".Null($phonepor).", `url` = ".Null($site_web).", `Rue` = ".Null($address).", `CP` = ".Null($cp).", `Ville` = ".Null($city).", `Pays` = ".Null($pays)." WHERE `fournisseur`.`ID` = $ID"))) {
          echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
        }
        else 
        {
          $stmt->execute();
        }
      //// Redirection automatique vers la page mère
      header('Location: ../fournisseurs.php');
    } else{
      echo "Erreur: Une erreur à eu lieu";
      // En cas d'erreur redirige vers accueil
      header('Location: ../accueil.php');
    }

} else {
  header("location: ../connexion.php");
}



// Fonction qui permet de remplacer une variable comme $city en NULL si elle est vide. Cela permet que la BDD accepte la requete SQL
function Null($var)
{
  if ($var == '')
  {
    return "NULL" ;
  }
  else{
    return "'$var'";
  }
  
}