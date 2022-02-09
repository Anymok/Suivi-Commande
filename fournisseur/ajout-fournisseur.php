<?php 
// Connexion à la BDD
include '../BDD/conn.php'; 
// Ouverture de la session
session_start();
// vérifie que user est connecter
if(isset($_SESSION["user_login"]))
{}
else {
  header("location: ../connexion.php");
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Ajout Fournisseur</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="../CSS/Ajout-Fournisseur.css" media="screen">
    <script class="u-script" type="text/javascript" src="../include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="../include/JS/nicepage.js" defer=""></script>
  </head>
  
  <body class="u-body">
            <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
            <?php include '../include/header.html'; ?>
 
    
    <div style="width: 30%; height: fit-content; left: 35%; top: 9%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50); box-sizing: border-box; position: absolute; background-color: #DDE2E3;">
    
        <h2  style="text-align:center; margin-top:3%; color:#12478B;">Ajout d'un fournisseur</h2>
        <div class="u-form u-form-1">
          <!-- Form ajout fournisseur -->
          <form action="../BDD/db_insert.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-25 u-form-vertical u-inner-form" style="padding: 15px" source="custom" redirect="true">
            <!-- Input hidden val -->
            <input type="hidden" value="f" name="val">  

            <!-- Entreprise -->
            <div class="u-form-group u-form-name">
                <label for="name-558c" class="u-form-control-hidden u-label">Name</label>
                <input type="text" autocomplete="off" placeholder="Entreprise" id="name-558c" name="entreprise" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="">
            </div>

            <!-- Nom -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-2">
              <label for="text-e42a" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Nom du contact" id="text-e42a" name="lastname" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Prénom -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-3">
              <label for="text-c28c" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Prénom du contact" id="text-c28c" name="firstname" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Email -->
            <div class="u-form-email u-form-group">
              <label for="email-558c" class="u-form-control-hidden u-label">Email</label>
              <input type="email" autocomplete="off" placeholder="Email" id="email-558c" name="email" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Tel fixe -->
            <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-5">
              <label for="phone-0422" class="u-form-control-hidden u-label"></label>
              <input type="tel" autocomplete="off" pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="Téléphone Fixe" id="phone-0422" name="phone" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Tel port -->
            <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-6">
              <label for="phone-55be" class="u-form-control-hidden u-label"></label>
              <input type="tel" autocomplete="off" pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="Téléphone Portable" id="phone-55be" name="phone-1" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- url -->
            <div class="u-form-group u-form-group-7">
              <label for="text-79df" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Site web" id="text-79df" name="site-web" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Rue -->
            <div class="u-form-address u-form-group u-form-group-8">
              <label for="address-e54f" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Adresse" id="address-e54f" name="address" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Code postal -->
            <div class="u-form-group u-form-group-9">
              <label for="text-01e2" class="u-form-control-hidden u-label"></label>
              <input type="number" autocomplete="off" placeholder="Code Postal" id="text-01e2" name="cp" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Ville -->
            <div class="u-form-group u-form-group-10">
              <label for="text-e549" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Ville" id="text-e549" name="city" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- Pays -->
            <div class="u-form-group u-form-group-11">
              <label for="text-c893" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Pays" id="text-c893" name="pays" class="u-border-1 u-border-grey-30 u-input u-input-rectangle">
            </div>

            <!-- bouton Ajouter -->
            <div style="margin-left:4%;">
              <a href="#" class="u-btn u-btn-submit u-button-style">Ajouter</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>

            <!-- bouton Annuler -->
            <div style="right: 2%; position: absolute; bottom: 0%;">
              <a href="../fournisseurs.php" class="u-btn u-button-style u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Annuler</a>
            </div>
          </form>
        </div>
          
      
      </div>
  </body>
</html>