<?php 
// Connexion à la BDD
include '../conn.php';

// récupère l'ID de la commande
$ID = $_POST['ID'];
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ouverture de la session
session_start();

// regarde si user est connecter, si non le renvoie vers connexion
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: ../../connexion.php");
}

// récupère tous les champs de la commande
// Sa evite d'effacer tous les champs quand un pdf est mis vue que la page sera actualise
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



// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // On regarde si la valeur type en POST existe
    if(isset($_POST["type"]))
    {
    // Si elle est égale à ADD (ajout d'un pdf)  
        if ($_POST["type"] == "add") 
        {
            // Création du fichier d'hébergement
            $filename = '../../fichier/'. $ID . '';
            if ((file_exists($filename)==false))
            {
            mkdir('../../fichier/'. $ID . '', 0777, true);
            }

    // Si le PDF est un devis et qu'il n'a aucune erreur
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
          if(file_exists("../../fichier/". $ID ."/" . $ID ."_DEVIS.pdf")){
              echo $_FILES["devis"]["name"] . " existe déjà.";
          } else {
              // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
              move_uploaded_file($_FILES["devis"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["devis"]["name"]);
              echo "Votre fichier a été téléchargé avec succès.";
              rename("../../fichier/". $ID ."/". $_FILES["devis"]["name"], "../../fichier/". $ID ."/". $ID ."_DEVIS.pdf");
              // Redirige vers modif-comande avec les arguments des champs
              header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
      } 
  } 

      // Si le PDF est une demande d'achat et qu'il n'a aucune erreur
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
            if(file_exists("../../fichier/". $ID ."/" . $ID ."_DA.pdf")){
                echo $_FILES["da"]["name"] . " existe déjà.";
            } else{
                // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
                move_uploaded_file($_FILES["da"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["da"]["name"]);
                echo "Votre fichier a été téléchargé avec succès.";
                rename("../../fichier/". $ID ."/". $_FILES["da"]["name"], "../../fichier/". $ID ."/". $ID ."_DA.pdf");
                // Redirige vers modif-commande avec les arguments des champs
                header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
            } 
        } 
    } 

    // Si le PDF est un bon de cmmande et qu'il n'a aucune erreur
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
          if(file_exists("../../fichier/". $ID ."/" . $ID ."_BC.pdf")){
              echo $_FILES["bc"]["name"] . " existe déjà.";
          } else{
              // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
              move_uploaded_file($_FILES["bc"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["bc"]["name"]);
              echo "Votre fichier a été téléchargé avec succès.";
              rename("../../fichier/". $ID ."/". $_FILES["bc"]["name"], "../../fichier/". $ID ."/". $ID ."_BC.pdf");
              // Redirige vers modif-commande avec les arguments des champs
              header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
      } 
  } 
  
  // Si le PDF est un sf et qu'il n'a aucune erreur
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
        if(file_exists("../../fichier/". $ID ."/" . $ID ."_SF.pdf")){
            echo $_FILES["sf"]["name"] . " existe déjà.";
        } else{
            // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
            move_uploaded_file($_FILES["sf"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["sf"]["name"]);
            echo "Votre fichier a été téléchargé avec succès.";
            rename("../../fichier/". $ID ."/". $_FILES["sf"]["name"], "../../fichier/". $ID ."/". $ID ."_SF.pdf");
            // Redirige vers modif-commande avec les arguments des champs
            header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
        } 
    } 
} 
  }

// Si elle est égale à MOD (modification d'un PDF, il faudra supprimer l'ancien pour en mettre un nouveau)  
if ($_POST["type"] == "mod") 
{
  
  // Création du fichier d'hébergement
  $filename = '../../fichier/'. $ID . '';
  if ((file_exists($filename)==false))
  {
    mkdir('../../fichier/'. $ID . '', 0777, true);
  }
  
  // Si le PDF est un devis et qu'il n'a aucune erreur
  if(isset($_FILES["devis"]) && $_FILES["devis"]["error"] == 0){
    // Supprimer l'ancien fichier  
    unlink("../../fichier/". $ID ."/" . $ID ."_DEVIS.pdf");
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
        if(file_exists("../../fichier/". $ID ."/" . $ID ."_DEVIS.pdf")){
            echo $_FILES["devis"]["name"] . " existe déjà.";
        } else{
            // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
            move_uploaded_file($_FILES["devis"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["devis"]["name"]);
            echo "Votre fichier a été téléchargé avec succès.";
            rename("../../fichier/". $ID ."/". $_FILES["devis"]["name"], "../../fichier/". $ID ."/". $ID ."_DEVIS.pdf");
            // Redirige vers modif-commande avec les arguments des champs
            header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
        }
    } 
} 


    // Si le PDF est un sf et qu'il n'a aucune erreur
    if(isset($_FILES["da"]) && $_FILES["da"]["error"] == 0){
      // Supprimer l'ancien fichier  
      unlink("../../fichier/". $ID ."/" . $ID ."_DA.pdf");
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
          if(file_exists("../../fichier/". $ID ."/" . $ID ."_DA.pdf")){
              echo $_FILES["da"]["name"] . " existe déjà.";
          } else{
              // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
              move_uploaded_file($_FILES["da"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["da"]["name"]);
              echo "Votre fichier a été téléchargé avec succès.";
              rename("../../fichier/". $ID ."/". $_FILES["da"]["name"], "../../fichier/". $ID ."/". $ID ."_DA.pdf");
               // Redirige vers modif-commande avec les arguments des champs
              header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
          } 
      } 
  } 

  // Si le PDF est un sf et qu'il n'a aucune erreur
  if(isset($_FILES["bc"]) && $_FILES["bc"]["error"] == 0){
    // Supprimer l'ancien fichier  
    unlink("../../fichier/". $ID ."/" . $ID ."_BC.pdf");
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
        if(file_exists("../../fichier/". $ID ."/" . $ID ."_BC.pdf")){
            echo $_FILES["bc"]["name"] . " existe déjà.";
        } else{
            // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
            move_uploaded_file($_FILES["bc"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["bc"]["name"]);
            echo "Votre fichier a été téléchargé avec succès.";
            rename("../../fichier/". $ID ."/". $_FILES["bc"]["name"], "../../fichier/". $ID ."/". $ID ."_BC.pdf");
             // Redirige vers modif-commande avec les arguments des champs
            header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
        } 
    } 
} 

// Si le PDF est un sf et qu'il n'a aucune erreur
if(isset($_FILES["sf"]) && $_FILES["sf"]["error"] == 0){
  // Supprimer l'ancien fichier  
  unlink("../../fichier/". $ID ."/" . $ID ."_SF.pdf");
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
      if(file_exists("../../fichier/". $ID ."/" . $ID ."_SF.pdf")){
          echo $_FILES["sf"]["name"] . " existe déjà.";
      } else{
          // déplace le fichier dans le dossier correspondant à l'ID de la commande et le renommer 
          move_uploaded_file($_FILES["sf"]["tmp_name"], "../../fichier/". $ID ."/". $_FILES["sf"]["name"]);
          echo "Votre fichier a été téléchargé avec succès.";
          rename("../../fichier/". $ID ."/". $_FILES["sf"]["name"], "../../fichier/". $ID ."/". $ID ."_SF.pdf");
        // Redirige vers modif-commande avec les arguments des champs
          header("Location: ../../commande/modif-commande.php?ID=" . $ID  . "&designation=" . $designation . "&destinataire=" . $destinataire . "&site=" . $site . "&fournisseur=" . $fournisseur . "&dateDemandeAchat=" . $dateDemandeAchat . "&numDemandeAchat=" . $numDemandeAchat . "&dateValidation=" . $dateValidation . "&dateBonCommande=" . $dateBonCommande . "&numBonCommande=" . $numBonCommande . "&dateConfirmationCommande=" . $dateConfirmationCommande . "&etatService=" . $etatService . "&dateLivraison=" . $dateLivraison . "&etatLivraison=" . $etatLivraison . "&commentaire=" . $commentaire . "" );
      } 
  } 
} 
}
}
}
?>