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

// Le temp_code est présent lorsque l'on ajouter des PDF à une commande dans ajout-commande.
// Le temp_code existe car lorsque j'ajoute un PDF, il doit être assigner à une commande, cependant elle n'existe pas. 
// Ce fameux temp_code me permet de concerver mon PDF en sachant a qui le donnée
// On regarde si un temps code est présent
if (!empty($_GET["temp_code"]))
{
  $temp_code = $_GET['temp_code']; // si oui le récuperer 
  // On prend aussi tous les reste des données après le temp_code
  $designation = $_GET['designation'];
  $destinataire = $_GET['destinataire'];
  $site = $_GET['site'];
  $fournisseur = $_GET['fournisseur'];
  $dateDemandeAchat = $_GET['dateDemandeAchat'];
  $numDemandeAchat = $_GET['numDemandeAchat'];
  $dateValidation = $_GET['dateValidation'];
  $dateBonCommande = $_GET['dateBonCommande'];
  $numBonCommande = $_GET['numBonCommande'];
  $dateConfirmationCommande = $_GET['dateConfirmationCommande'];
  $etatService = $_GET['etatService'];
  $dateLivraison = $_GET['dateLivraison'];
  $etatLivraison = $_GET['etatLivraison'];
  $commentaire = $_GET['commentaire'];
}
else {
  $temp_code = genererChaineAleatoire(20); // sinon le créer
}


///////// Pour les champs de type liste déroulante il y a du php/sql car la liste est charger en fonction de ce que possède la BDD
?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Ajout Commande</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <meta charset="utf-8">

    <link rel="stylesheet" href="../CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="../CSS/Ajout-Commande.css" media="screen">
    <script class="u-script" type="text/javascript" src="../include/JS/nicepage.js" defer=""></script>

    <!-- JQUERY -->
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/demo.css">
    <script type="text/javascript" src="/include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/color.css">
    <script type="text/javascript" src="/include/Jquery/jquery.easyui.min.js"></script>

    <script type="text/javascript">
      // fonction pour créer des input hidden, ils seront utiliser pour stocker mes champs quand j'ajoute un PDF
      // Ce dernier me seront retourner par URL
      function setInput($ID_form)
      {
          $($ID_form).append("<input type='hidden' name='designation' value='" + $('#designation').val() +"'>");
          $($ID_form).append("<input type='hidden' name='destinataire' value='" + $('#destinataire').val() +"'>");
          $($ID_form).append("<input type='hidden' name='site' value='" + $('#site').val() +"'>");
          $($ID_form).append("<input type='hidden' name='fournisseur' value='" + $('#fournisseur').val() +"'>");
          $($ID_form).append("<input type='hidden' name='dateDemandeAchat' value='" + $('#dateDemandeAchat').val() +"'>");
          $($ID_form).append("<input type='hidden' name='numDemandeAchat' value='" + $('#numDemandeAchat').val() +"'>");
          $($ID_form).append("<input type='hidden' name='dateValidation' value='" + $('#dateValidation').val() +"'>");
          $($ID_form).append("<input type='hidden' name='dateBonCommande' value='" + $('#dateBonCommande').val() +"'>");
          $($ID_form).append("<input type='hidden' name='numBonCommande' value='" + $('#numBonCommande').val() +"'>");
          $($ID_form).append("<input type='hidden' name='dateConfirmationCommande' value='" + $('#dateConfirmationCommande').val() +"'>");
          $($ID_form).append("<input type='hidden' name='etatService' value='" + $('#etatService').val() +"'>");
          $($ID_form).append("<input type='hidden' name='dateLivraison' value='" + $('#dateLivraison').val() +"'>");
          $($ID_form).append("<input type='hidden' name='etatLivraison' value='" + $('#etatLivraison').val() +"'>");
          $($ID_form).append("<input type='hidden' name='commentaire' value='" + $('#commentaire').val() +"'>");
      }

      // Quand le site est prêt
      $(document).ready(function(){   
        // Si la dateDemandeAchat est vide
        if($('#dateDemandeAchat').val() == ''){
          var today = new Date();
          // Lui donner celle du jours
          document.getElementById("dateDemandeAchat").defaultValue = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        }
        // action du clique pour pdf devis
        $('#submit_devis').click(function()
          {
              if( !$('#devis').val() ) {
                // Si aucun pdf n'a été choisi afficher un message d'erreur
                $("p").remove("#1")
                $("#form_devis").append("<p id='1' style='color:red;margin-top: -40px;margin-left: 80px;'>Veuillez saisir un pdf.</p>")
              } else {
                // Sinon ajoute les input hidden d'au dessus
                setInput("#form_devis");
                // et declanche le form
                $( "#form_devis" ).submit();
              }
              
          });
          // action du clique pour pdf da
          $('#submit_da').click(function()
          {
              if( !$('#da').val() ) {
                // Si aucun pdf n'a été choisi afficher un message d'erreur
                $("p").remove("#2")
                $("#form_da").append("<p id='2' style='color:red;margin-top: -40px;margin-left: 80px;'>Veuillez saisir un pdf.</p>")
              } else {
                // Sinon ajoute les input hidden d'au dessus
                setInput("#form_da");
                // et declanche le form
                $( "#form_da" ).submit();
              }
              
          });
          // action du clique pour pdf bc
          $('#submit_bc').click(function()
          {
              if( !$('#bc').val() ) {
                // Si aucun pdf n'a été choisi afficher un message d'erreur
                $("p").remove("#3")
                $("#form_bc").append("<p id='3' style='color:red;margin-top: -40px;margin-left: 80px;'>Veuillez saisir un pdf.</p>")
              } else {
                // Sinon ajoute les input hidden d'au dessus
                setInput("#form_bc");
                // et declanche le form
                $( "#form_bc" ).submit();
              }
              
          });
          // action du clique pour pdf sf
          $('#submit_sf').click(function()
          {
              if( !$('#sf').val() ) {
                // Si aucun pdf n'a été choisi afficher un message d'erreur
                $("p").remove("#4")
                $("#form_sf").append("<p id='4' style='color:red;margin-top: -40px;margin-left: 80px;'>Veuillez saisir un pdf.</p>")
              } else {
                // Sinon ajoute les input hidden d'au dessus
                setInput("#form_sf");
                // et declanche le form
                $( "#form_sf" ).submit();
              }
          });
      });
    </script>
  </head>

  <body class="u-body">
        <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
        <?php include '../include/header.html'; ?>

  <div style="width: 56%; height: fit-content; left: 22%; top: 10%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50); box-sizing: border-box; position: absolute; background-color: #DDE2E3;">
      
      <h2  style="text-align:center; margin-top:3%; color:#12478B;">Ajout d'une commande </h2>
        <div class="u-form u-form-1">
          <!-- Form ajout commande -->
          <form action="../BDD/db_insert.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-25 u-form-vertical u-inner-form" style="padding: 50px;" source="custom" redirect="true">
            <!-- input hidden val -->
            <input type="hidden" value="c" name="val">  
            <!-- input hidden temp-code -->
            <input type='hidden' name='temp_code' value="<?php echo $code;?>">

          <!-- Designation -->
          <div class="u-form-group u-form-name">
              <label for="name-558c" class="u-form-control-hidden u-label">Name</label>
              <input type="text" autocomplete="off" placeholder="Designation" id="designation" name="Designation" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($designation); ?>" required="">
            </div>

            <!-- destinataire -->
            <div class="u-form-group">
              <label for="email-558c" class="u-form-control-hidden u-label">Email</label>
              <input type="text" autocomplete="off" placeholder="Destinataire" id="destinataire" name="Destinataire" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($destinataire); ?>" required="required">
            </div>

            <!-- site concerné -->
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3">
              <label for="select-5ee0" class="u-label">Site concerné</label>
              <div class="u-form-select-wrapper">
                <select id="site" name="select" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                <?php 
                if (!empty($_GET["temp_code"]))
                {
                  $reponse = $conn->query('SELECT s.Nom FROM site s WHERE s.Nom !="' .  Null($site) . '"');
                  if (!empty($site))
                  {
                    echo '<option>' . Null($site) . '</option>';
                  }
                  while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['Nom'] . '</option>'; } 
                } else {
                
                  $reponse1 = $conn->query('SELECT t.site FROM tbl_user t WHERE t.user_id="' . $ID_test . '"');
                  while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['site'] . '</option>'; $type = $donnees1['site'] ; }

                  $reponse = $conn->query('SELECT s.nom FROM site s WHERE s.nom!="' . $type . '"');
                  while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['nom'] . '</option>'; } 
                }
                ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>

            <!-- fournisseur -->            
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-4">
              <label for="select-e00f" class="u-label">Choix du fournisseur</label>
              <div class="u-form-select-wrapper">
                <select id="fournisseur" name="select-1" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                <?php $reponse = $conn->query('SELECT f.Entreprise FROM fournisseur f WHERE f.Entreprise !="' .  Null($fournisseur) . '"'); 
                if (!empty($fournisseur))
                {
                  echo '<option>' . Null($fournisseur) . '</option>';
                }
                echo '<option> </option>'; 
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['Entreprise'] . '</option>'; } ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>

            <!-- dateDemandeAchat -->
            <div class="u-form-date u-form-group u-form-partition-factor-2 u-form-group-5">
              <label for="date-70cb" class="u-label">Date de la demande d'achat</label>
              <input type="date"  autocomplete="off"  id="dateDemandeAchat" name="dateDemandeAchat" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($dateDemandeAchat); ?>" required="required">
            </div>

            <!-- NumeroDemandeAchat -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-6">
              <label for="text-fd2d" class="u-form-control-hidden u-label"></label>
              <input type="text"  autocomplete="off" placeholder="Numéro demande d'achat" id="numDemandeAchat" name="NumeroDemandeAchat" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($numDemandeAchat); ?>">
            </div>

            <!-- dateValidation -->
            <div class="u-form-date u-form-group u-form-group-7">
              <label for="date-6305" class="u-label">Date de la validation</label>
              <input type="date" autocomplete="off" placeholder="MM/DD/YYYY" id="dateValidation" name="dateValidation" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($dateValidation); ?>">
            </div>

            <!-- dateBonCommande -->
            <div class="u-form-date u-form-group u-form-partition-factor-2 u-form-group-8">
              <label for="date-1d6d" class="u-label">Date du bon de commande</label>
              <input type="date" autocomplete="off" id="dateBonCommande" name="dateBonCommande" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" placeholder="MM/DD/YYYY" value="<?php echo Null($dateBonCommande); ?>">
            </div>

            <!-- NumeroBonCommande -->
            <div class="u-form-group u-form-partition-factor-2 u-form-group-9">
              <label for="text-8e11" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Numéro du bon de commande" id="numBonCommande" name="NumeroBonCommande" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($numBonCommande); ?>">
            </div>

            <!-- dateConfirmationCommande -->
            <div class="u-form-date u-form-group u-form-partition-factor-2 u-form-group-10">
              <label for="date-1e82" class="u-label">Date de la confirmation de la commande</label>
              <input type="date" autocomplete="off" placeholder="MM/DD/YYYY" id="dateConfirmationCommande" name="dateConfirmationCommande" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($dateConfirmationCommande); ?>">
            </div>
            
            <!-- servicefait -->
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-11">
              <label for="select-8ec7" class="u-label">État du service</label>
              <div class="u-form-select-wrapper">
                <select id="etatService" name="select-3" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required" >
                <?php $reponse = $conn->query('SELECT s.etat FROM servicefait s WHERE s.etat !="' .  Null($etatService) . '"'); 
                if (!empty($etatService))
                {
                  echo '<option>' . Null($etatService) . '</option>';
                }
                
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>
            
            <!-- dateLivraison -->
            <div class="u-form-date u-form-group u-form-partition-factor-2 u-form-group-12">
              <label for="date-7338" class="u-label">Date de la livraison</label>
              <input type="date" autocomplete="off" placeholder="MM/DD/YYYY" id="dateLivraison" name="dateLivraison" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" value="<?php echo Null($dateLivraison); ?>">
            </div>
            
            <!-- etatlivraison -->
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-13">
              <label for="select-814a" class="u-label">État de la livraison</label>
              <div class="u-form-select-wrapper">
                <select id="etatLivraison" name="select-2" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                <?php $reponse = $conn->query('SELECT e.etat FROM etatlivraison e WHERE e.etat !="' .  Null($etatLivraison) . '"'); 
                if (!empty($etatLivraison))
                {
                  echo '<option>' . Null($etatLivraison) . '</option>';
                }
                
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } ?>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>
            
            <!-- commentaire -->
            <div class="u-form-group u-form-textarea u-form-group-14">
              <label for="textarea-6609" class="u-form-control-hidden u-label"></label>
              <textarea rows="4" autocomplete="off" cols="50" id="commentaire" name="commentaire" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" placeholder="Commentaire" ><?php echo Null($commentaire); ?></textarea>
            </div>
            
            <!-- Bouton Ajouter -->
            <div class="u-align-left u-form-group u-form-submit u-form-group-15">
              <a href="#" class="u-border-none u-btn u-btn-submit u-button-style u-btn-1">Ajouter</a>
              <input type="submit" value="submit" class="u-form-control-hidden">
            </div>
            <div style="position: absolute; right: 4%; bottom: 3%;">
              <!-- Bouton Annuler -->
              <a href="../commandes.php" class="u-align-right u-btn u-button-style u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Annuler</a>
            </div>
          </form>
        </div>

        
      </div>
  </body>


<!-- Partie des PDF -->
  <div name="files" style="position:absolute; right:2%; top:10%; width:18%;">
      <style>
        input {
          margin-bottom:10px;
        }
        </style>
      
<?php
// Pour chaque champs PDF, afficher ajouter s'il existe aucun pdf pour cette commande, sinon mettre un bouton modifier et un bouton voir pour voir le PDF.

  // DEVIS
  if(file_exists("../fichier/temp/". $temp_code ."/" . $temp_code ."_DEVIS.pdf"))
  { 
  echo "<div style='padding-bottom:20%;'><form id='form_devis' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'>  <input type='hidden' name='type' value='mod'><label for='devis'><B><u>PDF devis</u></B></label><br/><br/> <input type='file' name='devis' id='devis' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_devis' type='button' value='Modifier' /> </form><a href=" . '../fichier/temp/'. $temp_code .'/' . $temp_code .'_DEVIS.pdf' . " target='_blank'> <input type='button' value='Voir' style='color:black;' ></input></a></div>";
  } else {
  echo "<div style='padding-bottom:20%;'><form id='form_devis' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='add'><label for='devis'><B><u>PDF devis</u></B></label><br/><br/> <input type='file' name='devis' id='devis' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_devis' type='button' value='Valider' /> </form></div>";
  }

  // BA
  if(file_exists("../fichier/temp/". $temp_code ."/" . $temp_code ."_DA.pdf"))
  { 
   echo "<div style='padding-bottom:20%;'><form id='form_da' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='mod'><label for='da'><B><u>PDF demande d'achat</u></B></label><br/><br/> <input type='file' name='da' id='da' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_da' type='button' value='Modifier' /> </form><a href=" . '../fichier/temp/'. $temp_code .'/' . $temp_code .'_DA.pdf' . " target='_blank'> <input type='button' value='Voir' style='color:black;' ></input></a></div>";
  } else {
   echo "<div style='padding-bottom:20%;'><form id='form_da' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='add'><label for='da'><B><u>PDF demande d'achat</u></B></label><br/><br/> <input type='file' name='da' id='da' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_da' type='button' value='Valider' /> </form></div>";
  }

  // BC 
  if(file_exists("../fichier/temp/". $temp_code ."/" . $temp_code ."_BC.pdf"))
  { 
   echo "<div style='padding-bottom:20%;'><form id='form_bc' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='mod'><label for='bc'><B><u>PDF bon commande</u></B></label><br/><br/> <input type='file' name='bc' id='bc' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_bc' type='button' value='Modifier' /> </form><a href=" . '../fichier/temp/'. $temp_code .'/' . $temp_code .'_BC.pdf' . " target='_blank'> <input type='button' value='Voir' style='color:black;' ></input></a></div>";
  } else {
   echo "<div style='padding-bottom:20%;'><form id='form_bc' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='add'><label for='bc'><B><u>PDF bon commande</u></B></label><br/><br/> <input type='file' name='bc' id='bc' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_bc' type='button' value='Valider' /> </form></div>";
  }

  // SF
  if(file_exists("../fichier/temp/". $temp_code ."/" . $temp_code ."_SF.pdf"))
  { 
   echo "<div style='padding-bottom:20%;'><form id='form_sf' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='mod'><label for='sf'><B><u>PDF service facturation</u></B></label><br/><br/> <input type='file' name='sf' id='sf' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_sf' type='button' value='Modifier' /> </form><a href=" . '../fichier/temp/'. $temp_code .'/' . $temp_code .'_SF.pdf' . " target='_blank'> <input type='button' value='Voir' style='color:black;' ></input></a></div>";
  } else {
   echo "<div style='padding-bottom:20%;'><form id='form_sf' method='post' action='../BDD/pdf/temp_reception.php' enctype='multipart/form-data'> <input type='hidden' name='type' value='add'><label for='sf'><B><u>PDF service facturation</u></B></label><br/><br/> <input type='file' name='sf' id='sf' /><br /> <input type='hidden' name='temp_code' value=". $temp_code ."> <input id='submit_sf' type='button' value='Valider' /> </form></div>";
  }
  ?>

  </div>

<?php
// fonction qui génère le temp_code (pris sur le web)
function genererChaineAleatoire($longueur = 10)
{
 $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $longueurMax = strlen($caracteres);
 $chaineAleatoire = '';
 for ($i = 0; $i < $longueur; $i++)
 {
 $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
 }
 return $chaineAleatoire;
}

// fonction qui permet de retourner NULL si la valeur est vide ou retourne juste la valeur
// Eviter les bugs
function Null($var)
{
  if ($var == '')
  {
    return "" ;
  }
  else{
    return "$var";
  }
  
}

?>

</html>

<style>
body {
        background: #135589  !important;
      }



      /* Cacher la barre de scroll */
      html { 
        scrollbar-width: none;  /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
      }
      .html::-webkit-scrollbar { 
        display: none;  /* Safari and Chrome */
      }    
    </style>