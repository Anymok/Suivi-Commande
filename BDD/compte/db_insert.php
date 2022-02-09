
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
  $identifiant=$_POST['identifiant'];
  $mdp1=$_POST['MDP'];
  $permission=$_POST['permission'];
  $site=$_POST['site'];
  $mdp = password_hash($mdp1, PASSWORD_DEFAULT); //hahsh le mdp

  $select_stmt=$conn->prepare("SELECT username FROM tbl_user WHERE username=:uname"); // Regarde si user existe
  $select_stmt->execute(array(':uname'=>$identifiant)); 
  $row=$select_stmt->fetch(PDO::FETCH_ASSOC);	

  if($row["username"]==$identifiant){
   // Si le nom du compte existe déjà ne rien faire
  } else {

      // Injecter la commandes 
      if (!($stmt = $conn->prepare("INSERT INTO tbl_user (`username`, `password`, `site`, `permission`, `tableau_setting`) VALUES (".Null($identifiant).", ".Null($mdp).", ".Null($site).", ".Null($permission).", 'off')"))) {

      } else {
        $stmt->execute();
      }
      $connection = null;

  }

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