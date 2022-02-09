
<?php 

// Connexion à la BDD
include '../conn.php'; 
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verification que user est connecter
session_start();
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../../connexion.php");
}

// Récupère les anciens champs de la commande
// le urlencode permet de ne pas effacer les caractère +
$designation = urlencode ($_POST['designation']);
$destinataire = urlencode ($_POST['destinataire']);
$site = urlencode ($_POST['site']);
$fournisseur = urlencode ($_POST['fournisseur']);
$dateDemandeAchat = urlencode ($_POST['dateDemandeAchat']);
$numDemandeAchat = urlencode ($_POST['numDemandeAchat']);
$dateValidation = urlencode ($_POST['dateValidation']);
$dateBonCommande = urlencode ($_POST['dateBonCommande']);
$numBonCommande = urlencode ($_POST['numBonCommande']);
$dateConfirmationCommande = urlencode ($_POST['dateConfirmationCommande']);
$etatService = urlencode ($_POST['etatService']);
$dateLivraison = urlencode ($_POST['dateLivraison']);
$etatLivraison = urlencode ($_POST['etatLivraison']);
$commentaire = urlencode ($_POST['commentaire']);

// Récupère temp_code en POST
$temp_code = $_POST['temp_code'];

// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){

// regarde si la données type existe
if(isset($_POST["type"]))
{
  // Regarde s'il s'agit d'un ajout
  if ($_POST["type"] == "add") 
  {
    // Création du fichier d'hébergement
      $filename = '../../fichier/temp/'. $temp_code . '';
      if ((file_exists($filename)==false))
      {
        mkdir('../../fichier/temp/'. $temp_code . '', 0777, true);
      }



      // Vérifie si le fichier a été uploadé sans erreur.
      if(isset($_FILES["devis"]) && $_FILES["devis"]["error"] == 0){
        $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
        $filename = $_FILES["devis"]["name"];
        $filetype = $_FILES["devis"]["type"];
        $filesize = $_FILES["devis"]["size"];
        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
        // Vérifie la taille du fichier - 10Mo maximum
        $maxsize = 10 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DEVIS.pdf")){
                echo $_FILES["devis"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["devis"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["devis"]["name"]);
                echo "Votre fichier a été téléchargé avec succès.";
                rename("../../fichier/temp/". $temp_code ."/". $_FILES["devis"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_DEVIS.pdf");
                header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
        } 
      } 

        // Vérifie si le fichier a été uploadé sans erreur.
      if(isset($_FILES["da"]) && $_FILES["da"]["error"] == 0){
          $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
          $filename = $_FILES["da"]["name"];
          $filetype = $_FILES["da"]["type"];
          $filesize = $_FILES["da"]["size"];
          // Vérifie l'extension du fichier
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
          // Vérifie la taille du fichier - 10Mo maximum
          $maxsize = 10 * 1024 * 1024;
          if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
          // Vérifie le type MIME du fichier
          if(in_array($filetype, $allowed)){
              // Vérifie si le fichier existe avant de le télécharger.
              if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DA.pdf")){
                  echo $_FILES["da"]["name"] . " existe déjà.";
              } else{
                  move_uploaded_file($_FILES["da"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["da"]["name"]);
                  echo "Votre fichier a été téléchargé avec succès.";
                  rename("../../fichier/temp/". $temp_code ."/". $_FILES["da"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_DA.pdf");
                  header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
              } 
          } 
      } 

      // Vérifie si le fichier a été uploadé sans erreur.
      if(isset($_FILES["bc"]) && $_FILES["bc"]["error"] == 0){
        $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
        $filename = $_FILES["bc"]["name"];
        $filetype = $_FILES["bc"]["type"];
        $filesize = $_FILES["bc"]["size"];
        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
        // Vérifie la taille du fichier - 10Mo maximum
        $maxsize = 10 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_BC.pdf")){
                echo $_FILES["bc"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["bc"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["bc"]["name"]);
                echo "Votre fichier a été téléchargé avec succès.";
                rename("../../fichier/temp/". $temp_code ."/". $_FILES["bc"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_BC.pdf");
                header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
        } 
      } 

      // Vérifie si le fichier a été uploadé sans erreur.
      if(isset($_FILES["sf"]) && $_FILES["sf"]["error"] == 0){
      $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
      $filename = $_FILES["sf"]["name"];
      $filetype = $_FILES["sf"]["type"];
      $filesize = $_FILES["sf"]["size"];
      // Vérifie l'extension du fichier
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
      // Vérifie la taille du fichier - 10Mo maximum
      $maxsize = 10 * 1024 * 1024;
      if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
      // Vérifie le type MIME du fichier
      if(in_array($filetype, $allowed)){
          // Vérifie si le fichier existe avant de le télécharger.
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_SF.pdf")){
              echo $_FILES["sf"]["name"] . " existe déjà.";
          } else{
              move_uploaded_file($_FILES["sf"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["sf"]["name"]);
              echo "Votre fichier a été téléchargé avec succès.";
              rename("../../fichier/temp/". $temp_code ."/". $_FILES["sf"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_SF.pdf");
              header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
      } 
  } 
    }

// Regarde s'il s'agit d'une modif
if ($_POST["type"] == "mod") 
{
  
// Création du fichier d'hébergement
  $filename = '../../fichier/temp/'. $temp_code . '';
  if ((file_exists($filename)==false))
  {
    mkdir('../../fichier/temp/'. $temp_code . '', 0777, true);
  }
  
  // Vérifie si le fichier a été uploadé sans erreur.
  if(isset($_FILES["devis"]) && $_FILES["devis"]["error"] == 0){
    unlink("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DEVIS.pdf");
    $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
    $filename = $_FILES["devis"]["name"];
    $filetype = $_FILES["devis"]["type"];
    $filesize = $_FILES["devis"]["size"];
    // Vérifie l'extension du fichier
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
    // Vérifie la taille du fichier - 10Mo maximum
    $maxsize = 10 * 1024 * 1024;
    if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
    // Vérifie le type MIME du fichier
    if(in_array($filetype, $allowed)){
        // Vérifie si le fichier existe avant de le télécharger.
        if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DEVIS.pdf")){
            echo $_FILES["devis"]["name"] . " existe déjà.";
        } else{
            move_uploaded_file($_FILES["devis"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["devis"]["name"]);
            echo "Votre fichier a été téléchargé avec succès.";
            rename("../../fichier/temp/". $temp_code ."/". $_FILES["devis"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_DEVIS.pdf");
            header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
        } 
    } 
} 


    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["da"]) && $_FILES["da"]["error"] == 0){
      unlink("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DA.pdf");
      $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
      $filename = $_FILES["da"]["name"];
      $filetype = $_FILES["da"]["type"];
      $filesize = $_FILES["da"]["size"];
      // Vérifie l'extension du fichier
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
      // Vérifie la taille du fichier - 10Mo maximum
      $maxsize = 10 * 1024 * 1024;
      if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
      // Vérifie le type MIME du fichier
      if(in_array($filetype, $allowed)){
          // Vérifie si le fichier existe avant de le télécharger.
          if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_DA.pdf")){
              echo $_FILES["da"]["name"] . " existe déjà.";
          } else{
              move_uploaded_file($_FILES["da"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["da"]["name"]);
              echo "Votre fichier a été téléchargé avec succès.";
              rename("../../fichier/temp/". $temp_code ."/". $_FILES["da"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_DA.pdf");
              header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
      } 
  } 

  // Vérifie si le fichier a été uploadé sans erreur.
  if(isset($_FILES["bc"]) && $_FILES["bc"]["error"] == 0){
    unlink("../../fichier/temp/". $temp_code ."/" . $temp_code ."_BC.pdf");
    $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
    $filename = $_FILES["bc"]["name"];
    $filetype = $_FILES["bc"]["type"];
    $filesize = $_FILES["bc"]["size"];
    // Vérifie l'extension du fichier
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
    // Vérifie la taille du fichier - 10Mo maximum
    $maxsize = 10 * 1024 * 1024;
    if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
    // Vérifie le type MIME du fichier
    if(in_array($filetype, $allowed)){
        // Vérifie si le fichier existe avant de le télécharger.
        if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_BC.pdf")){
            echo $_FILES["bc"]["name"] . " existe déjà.";
        } else{
            move_uploaded_file($_FILES["bc"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["bc"]["name"]);
            echo "Votre fichier a été téléchargé avec succès.";
            rename("../../fichier/temp/". $temp_code ."/". $_FILES["bc"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_BC.pdf");
            header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
        } 
    } 
} 

// Vérifie si le fichier a été uploadé sans erreur.
if(isset($_FILES["sf"]) && $_FILES["sf"]["error"] == 0){
  unlink("../../fichier/temp/". $temp_code ."/" . $temp_code ."_SF.pdf");
  $allowed = array("pdf" => "application/pdf", "PDF" => "application/pdf");
  $filename = $_FILES["sf"]["name"];
  $filetype = $_FILES["sf"]["type"];
  $filesize = $_FILES["sf"]["size"];
  // Vérifie l'extension du fichier
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
  // Vérifie la taille du fichier - 10Mo maximum
  $maxsize = 10 * 1024 * 1024;
  if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
  // Vérifie le type MIME du fichier
  if(in_array($filetype, $allowed)){
      // Vérifie si le fichier existe avant de le télécharger.
      if(file_exists("../../fichier/temp/". $temp_code ."/" . $temp_code ."_SF.pdf")){
          echo $_FILES["sf"]["name"] . " existe déjà.";
      } else{
          move_uploaded_file($_FILES["sf"]["tmp_name"], "../../fichier/temp/". $temp_code ."/". $_FILES["sf"]["name"]);
          echo "Votre fichier a été téléchargé avec succès.";
          rename("../../fichier/temp/". $temp_code ."/". $_FILES["sf"]["name"], "../../fichier/temp/". $temp_code ."/". $temp_code ."_SF.pdf");
          header("Location: ../../commande/ajout-commande.php?temp_code=" . $temp_code . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
      } 
  } 
} 
}
}
}
?>