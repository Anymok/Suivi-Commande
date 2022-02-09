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
// récupère l'ID du fournisseur à modifier
$ID = $_GET['ID'];
$where = " ID=". $ID ;

///////////////////////////////////////
// Pour chaque champs on va chercher sa valeur dans la BDD
// On récuèpre toutes les données du fournisseur avec les 3 lignes en dessous
// En suite il suffit d'appeler le tableau et de selectionner la variable à ressortir (par exemple $rowFournisseur['Entreprise'] donnera le nom de l'entreprise)
// Pour chaque input la value="" sera égale à la valeur dans le tableau rowFournisseur
///////////////////////////////////////
$getFournisseur=$conn->prepare("SELECT * FROM fournisseur WHERE ID=:uid"); // On obtient le fournisseur avec l'ID uid
$getFournisseur->execute(array(':uid'=>$_GET['ID']));	// uid ID devient l'ID passer en _GET
$rowFournisseur=$getFournisseur->fetch(PDO::FETCH_ASSOC); // On met le fournisseur dans un talbeau pour l'exploiter 
?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Modif Fournisseur</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="../CSS/Modif-Fournisseur.css" media="screen">
    <script class="u-script" type="text/javascript" src="../include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="../include/JS/nicepage.js" defer=""></script>
  </head>
  <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
  <?php include '../include/header.html'; ?>
  <body class="u-body">

    
  <div style="width: 30%; height: fit-content; left: 35%; top: 9%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50); box-sizing: border-box; position: absolute; background-color: #DDE2E3;">
   
        <h2 style="text-align:center; margin-top:3%; color:#12478B;">Modification d'un fournisseur</h2>
          <div class="u-form u-form-1">
          <!-- Form modif fournisseur -->
          <form action="../BDD/db_modif.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-25 u-form-vertical u-inner-form" style="padding: 15px" source="custom" redirect="true">
            <!-- Input hidden val -->
            <input type="hidden" value="f" name="val">
            <!-- input hidden ID commande -->
            <input type="hidden" value="<?php echo $ID; ?>" name="ID">
            <!-- Entreprise -->
            <div class="u-form-group u-form-name">
              <label for="name-558c" class="u-form-control-hidden u-label">Name</label>
              <input type="text" autocomplete="off" placeholder="Entreprise" id="name-558c" name="entreprise" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="" value="<?php echo $rowFournisseur["Entreprise"];?>">
            </div>

            <!-- Nom -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-2">
              <label for="text-e42a" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Nom du contact" id="text-e42a" name="lastname" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Nom"];?>">
            </div>

            <!-- Prénom -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-3">
              <label for="text-c28c" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Prénom du contact" id="text-c28c" name="firstname" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Prenom"];?>">
            </div>

            <!-- Email -->
            <div class="u-form-email u-form-group">
              <label for="email-558c" class="u-form-control-hidden u-label">Email</label>
              <input type="email" autocomplete="off" placeholder="Email" id="email-558c" name="email" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Email"];?>">
            </div>

            <!-- Tel fixe -->
            <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-5">
              <label for="phone-0422" class="u-form-control-hidden u-label"></label>
              <input type="tel" autocomplete="off" pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="Téléphone Fixe" id="phone-0422" name="phone" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Tel-fix"];?>">
            </div>

            <!-- Tel por -->
            <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-6">
              <label for="phone-55be" class="u-form-control-hidden u-label"></label>
              <input type="tel" autocomplete="off" pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="Téléphone Portable" id="phone-55be" name="phone-1" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Tel-por"];?>">
            </div>

            <!-- URL -->
            <div class="u-form-group u-form-group-7">
              <label for="text-79df" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Site web" id="text-79df" name="site-web" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["url"];?>">
            </div>

            <!-- rue -->
            <div class="u-form-address u-form-group u-form-group-8">
              <label for="address-e54f" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Adresse" id="address-e54f" name="address" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Rue"];?>">
            </div>

            <!-- Code postal -->
            <div class="u-form-group u-form-group-9">
              <label for="text-01e2" class="u-form-control-hidden u-label"></label>
              <input type="number" autocomplete="off" placeholder="Code Postal" id="text-01e2" name="cp" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["CP"];?>">
            </div>

            <!-- Ville -->
            <div class="u-form-group u-form-group-10">
              <label for="text-e549" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Ville" id="text-e549" name="city" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Ville"];?>">
            </div>

            <!-- Pays -->
            <div class="u-form-group u-form-group-11">
              <label for="text-c893" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Pays" id="text-c893" name="pays" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo $rowFournisseur["Pays"];?>">
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