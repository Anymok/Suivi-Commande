<?php
// Connexion à la BDD
include '../conn.php';
// Ouverture de la session
session_start();
// Regarde si User est co
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../../connexion.php");
}


  // Prendre toutes les valeurs en POST
  $ID=$_POST['ID'];
  $identifiant=$_POST['identifiant'];
  $permission=$_POST['permission'];
  $site=$_POST['site'];


  // si la variable POST MDP n'est pas vide
if (!empty($_POST['MDP'])) 
{
	$mdp1=$_POST['MDP'];
	$mdp = password_hash($mdp1, PASSWORD_DEFAULT); //hahsh le mdp
   // Injecter la ommandes 
   if (!($stmt = $conn->prepare("UPDATE `tbl_user` SET `username` = ".Null($identifiant).", `password` = ".Null($mdp).", `permission` = ".Null($permission).", `site` = ".Null($site)." WHERE `tbl_user`.`user_id` =".  $ID. ""))) {
   
  } else {
    $stmt->execute();
  }
}
else {
	  // Injecter la ommandes 
    if (!($stmt = $conn->prepare("UPDATE `tbl_user` SET `username` = ".Null($identifiant).", `permission` = ".Null($permission).", `site` = ".Null($site)." WHERE `tbl_user`.`user_id` =".  $ID. ""))) {
   
    } else {
      $stmt->execute();
    }
}


 
  $connection = null;




  //// Redirection automatique vers la page mère
header('Location: ../../compte/gestion-compte.php');
  



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


