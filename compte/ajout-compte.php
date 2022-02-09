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
    <title>Ajout Compte</title>
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
 

    <div style="width: 30%; height: fit-content; left: 35%; top: 20%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50); box-sizing: border-box; position: absolute; background-color: #DDE2E3;">
      
        <h2 class="u-align-center u-text u-text-custom-color-1 u-text-default u-text-1" style="margin-left: 25%;">Ajout d'un compte</h2>
        <div class="u-form u-form-1">
          <!-- Form ajout fournisseur -->
          <form action="../BDD/compte/db_insert.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-25 u-form-vertical u-inner-form" style="padding: 15px" source="custom" redirect="true">
            <!-- Identifiant -->
            <div class="u-form-group u-form-name">
                <label for="identifiant" class="u-form-control-hidden u-label"></label>
                <input type="text" autocomplete="off" placeholder="Identifiant" id="identifiant" name="identifiant" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="">
            </div>


            <!-- MDP -->
            <div class="u-form-email u-form-group">
              <label for="MDP" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Mot de passe" id="MDP" name="MDP" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="">
            </div>

            <!-- Permission -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-2">
            <label for="permission" class="u-label">Permission</label>
              <div class="u-form-select-wrapper">
                <select id="permission"  name="permission" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                <?php
                  $reponse = $conn->query('SELECT p.etat FROM permissions p'); 
                  echo '<option></option>';
                  while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } 
                ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>

            <!-- Site -->
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3">
              <label for="site" class="u-label">Site concerné</label>
              <div class="u-form-select-wrapper">
                <select id="site" name="site" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                <!-- Selectionne les sites dans la table site de la BDD -->
                <?php
                $reponse = $conn->query('SELECT s.nom FROM site s WHERE s.Nom!="' . $_POST['site'] . '" '); 
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['nom'] . '</option>'; }
               ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>


            <!-- bouton Ajouter -->
            <div class="u-align-left u-form-group u-form-submit">
              <a href="#" class="u-btn u-btn-submit u-button-style">Ajouter</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>

            <div style="right: 2%; position: absolute; top: 75%;">
                <!-- bouton Annuler -->
                <a href="gestion-compte.php" class=" u-btn u-button-style u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Annuler</a>
            </div>
          </form>
        </div>
        
      </div>
</div>
  </body>
</html>