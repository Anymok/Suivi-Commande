
<?php
// Connexion à la BDD
include 'conn.php';
// Ouverture de la session
session_start();
// Regarde si User est co
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../connexion.php");
}

// $val prend la valeur de POST val (pour c = commande et f = fournisseur)
$val=$_POST['val'];
// Pour c faire...
if ($val == "c")
{
  // Prendre toutes les valeurs en POST
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
  
  // Si temp-code est existant (pour récuperer les PDF temporaire et les assigner a cette commande)
  if (!empty($_POST["temp_code"]))
  {
    // On prend la valeur du temp_code
    $temp_code=$_POST['temp_code'];
    //// Le prepare permet d'eviter les injection SQL
    // on regarde si aucune erreur a lieu
    if (!($stmt = $conn->prepare("INSERT INTO commandes (`designation`, `destinataire`, `site`, `fournisseur`, `EtatLivraison`, `ServiceFait`, `dateDemandeAchat`, `numDemandeAchat`, `dateValidation`, `numBonCommande`, `dateBonCommande`, `dateConfirmationCommande`, `dateLivraison`, `commentaire` , `temp_code`) VALUES (".Null($Designation).", ".Null($Destinataire).", ".Null($site).", ".Null($Fournisseur).", ".Null($EtatLivraison).", ".Null($ServiceFait).", ".Null($dateDemandeAchat).", ".Null($NumeroDemandeAchat).", ".Null($dateValidation).", ".Null($NumeroBonCommande).", ".Null($dateBonCommande).", ".Null($dateConfirmationCommande).", ".Null($dateLivraison).", ".Null($commentaire)." , ".Null($temp_code).")"))) {
      echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
    }
    else // On lance la requête sql si aucun probleme
    {
      $stmt->execute();
    }
    // Deconnexion de la BDD
    $connection = null;

  
   // Redirige vers code_reception afin d'attribuer les PDF à la commande 
  header('Location: pdf/code_reception.php?temp_code=' . $temp_code );

  } else {
    // Injecter la ommandes 
    if (!($stmt = $conn->prepare("INSERT INTO commandes (`designation`, `destinataire`, `site`, `fournisseur`, `EtatLivraison`, `ServiceFait`, `dateDemandeAchat`, `numDemandeAchat`, `dateValidation`, `numBonCommande`, `dateBonCommande`, `dateConfirmationCommande`, `dateLivraison`, `commentaire`) VALUES (".Null($Designation).", ".Null($Destinataire).", ".Null($site).", ".Null($Fournisseur).", ".Null($EtatLivraison).", ".Null($ServiceFait).", ".Null($dateDemandeAchat).", ".Null($NumeroDemandeAchat).", ".Null($dateValidation).", ".Null($NumeroBonCommande).", ".Null($dateBonCommande).", ".Null($dateConfirmationCommande).", ".Null($dateLivraison).", ".Null($commentaire).")"))) {
      echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
    }
    else 
    {
      $stmt->execute();
    }
    $connection = null;

  //// Redirection automatique vers la page mère
  header('Location: ../commandes.php');
  }

}

// Pour un fournisseur faire ...
elseif ($val == "f")
{
  // prend toutes les valeurs
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

    
    //// Ajoute le fournisseur si il y a aucune erreur.
    if (!($stmt = $conn->prepare("INSERT INTO fournisseur (`Entreprise`, `Prenom`, `Nom`, `Email`, `Tel-fix`, `Tel-por`, `url`, `Rue`, `CP`, `Ville`, `Pays`) VALUES (".Null($entreprise).", ".Null($prenom).", ".Null($nom).", ".Null($email).", ".Null($phonefix).", ".Null($phonepor).", ".Null($site_web).", ".Null($address).", ".Null($cp).", ".Null($city).", ".Null($pays).")"))) {
      echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
    }
    else 
    {
   
      $stmt->execute();
      
    }
    $connection = null;
  
    
  
  
  

  //// Redirection automatique vers la page mère
  header('Location: ../fournisseurs.php');
  
}
else{
  echo "Erreur, redirection à l'accueil.";
// En cas d'erreur renvoie vers accueil
  header('Location: ../accueil.php');
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