<?php
// Connexion  la BDD
include 'conn.php';
// Ouverture de la session
session_start();
// Regarde si user et co
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../connexion.php");
}

//Prend la valeur du GET val
$val=$_GET['val'];
// Si val = c (commande) faire...
if ($val == "c")
{
  // Recupère l'ID
  $ID=$_GET['ID'];

    //// Supprime la ligne si aucune erreur
    if (!($stmt = $conn->prepare("delete from `commandes` WHERE `id` =".$ID))) {
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

// Si val = f (fournisseur) faire...
elseif ($val == "f")
{
  // Recupère l'ID
  $ID=$_GET['ID'];

    //// Supprime la ligne si aucune erreur
    if (!($stmt = $conn->prepare("DELETE FROM `fournisseur` WHERE `id` =".$ID))) {
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
// En cas d'erreur retourner à l'accueil
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