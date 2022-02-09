<?php
// Connexion  la BDD
include '../conn.php';
// Ouverture de la session
session_start();
// Regarde si user et connecter
if(isset($_SESSION["user_login"]))	
{
  if (!empty($_GET['ID']))
 {
    // Recupère l'ID
    $ID=$_GET['ID'];
  if ($ID == $_SESSION["user_login"])
  {}
  else {
    //// Supprime la ligne si aucune erreur
    if (!($stmt = $conn->prepare("delete from `tbl_user` WHERE `user_id` =".$ID))) {
    } else {
      
      $stmt->execute();
    }
    $connection = null;
  }
 } 
  //// Redirection automatique vers la page mère
   header('Location: ../../compte/gestion-compte.php');
    
} else {
  header("location: ../../connexion.php");
}


?>