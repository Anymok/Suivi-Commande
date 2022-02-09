
<?php 

// Connexion à la BDD
include '../conn.php'; 
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verifier si User est connecter
session_start();
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../../connexion.php");
}

// Récupération du temp_code en GET
$temp_code = $_GET['temp_code'];


// Récupération de l'ID de la commande actuelle
$reponse = $conn->query('SELECT c.ID FROM commandes c WHERE c.temp_code="' . $temp_code . '"'); 
while ($donnees = $reponse->fetch()) { $ID = $donnees['ID'] ; } 



    // Création du fichier avec l'ID de la commande (hebergeur des pdf)
      $filename = '../../fichier/'. $ID . '';
      if ((file_exists($filename)==false))
      {
        mkdir('../../fichier/'. $ID . '', 0777, true);
      }

          // Si fichier existe le déplacer en le renommant

          // DEVIS
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DEVIS.pdf")){
            rename("../../fichier/temp/". $temp_code ."/". $temp_code ."_DEVIS.pdf", "../../fichier/". $ID ."/". $ID ."_DEVIS.pdf");
          } 
          
          // DA
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DA.pdf")){
            rename("../../fichier/temp/". $temp_code ."/". $temp_code ."_DA.pdf", "../../fichier/". $ID ."/". $ID ."_DA.pdf");
          } 

          // BC
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_BC.pdf")){
            rename("../../fichier/temp/". $temp_code ."/". $temp_code ."_BC.pdf", "../../fichier/". $ID ."/". $ID ."_BC.pdf");
          } 

          // SF
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_SF.pdf")){
            rename("../../fichier/temp/". $temp_code ."/". $temp_code ."_SF.pdf", "../../fichier/". $ID ."/". $ID ."_SF.pdf");
          } 

        // Suppression du dossier temporaire de la commande
        if(file_exists("../../fichier/temp/". $temp_code ."" )){
          rmdir("../../fichier/temp/". $temp_code ."");
        } 


        // Suppression du temp_code sur la commande
        if (!($stmt = $conn->prepare("UPDATE commandes SET temp_code = NULL WHERE temp_code='". $temp_code ."'"))) {
          echo "Échec de la préparation : (" . $conn->errno . ") " . $conn->error;
        }
        else 
        {
          $stmt->execute();
        }

        // Redirection à la page commandes
        header("Location: ../../commandes.php");

?>