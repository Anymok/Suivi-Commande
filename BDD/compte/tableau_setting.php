<?php 
// Importation de la connexion à la BDD
include '../conn.php'; 

// Ouvertur de la session de l'utilisateur
session_start();
// Si user est connecter
if(isset($_SESSION["user_login"]))	
{

        // recupère les user avec l'id du user connecter
        $getUser=$conn->prepare("SELECT * FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
        $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
        $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

        // si user à tableau avancé en off 
        if ($rowUser["tableau_setting"] == "off") {
          $tableau_setting = "on"; // le passe en on
        } 
        else { // sinon
          $tableau_setting = "off"; // le passe en off
        }



        
          
          // requête sql pour changer le tableau setting
          if (!($stmt = $conn->prepare("UPDATE `tbl_user` SET `tableau_setting` = '". $tableau_setting ."' WHERE `tbl_user`.`user_id` = " . $_SESSION['user_login'] . ""))) {
          } else {
            $stmt->execute();
          }
        

} else { // Si user n'est pas co
  header("location: ../../connexion.php");
}
header('Location: ../../compte.php');
?>

