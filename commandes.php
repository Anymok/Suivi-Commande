<?php 
// Importation de la connexion à la BDD
include 'BDD/conn.php'; 

// Ouvertur de la session de l'utilisateur
session_start();

// Verif qu'il soit connecter; si non envoie vers page de connexion
if(isset($_SESSION["user_login"]))	
{}
else {
  header("location: connexion.php");
}
?>

<!-- Importation des CSS et JS, reglage du site -->
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Commandes</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="CSS/Commandes.css" media="screen">
    <script class="u-script" type="text/javascript" src="/include/JS/nicepage.js" defer=""></script>

   
    <!-- JQUERY -->
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/demo.css">
    <script type="text/javascript" src="/include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/color.css">
    <script type="text/javascript" src="/include/Jquery/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/include/JS/datagrid-export.js"></script>

    <!-- Javascript -->
    <script type="text/javascript">
      // Lorsque le site est prêt charge les tableaux en fonction des variables POST de l'accueil
       $(document).ready(function() {
         
         check("#parameters");
          doSearchC();
          doSearchS();
        });
      
      // Action du bouton supprimer, la fonction regarde qu'elle tableau est actif et envoie l'ID de la commande avec la val=c (commande) à db_remove
      function getIDDel(){
        var a = document.getElementById('del'); 
        if ($('#parameters').is(":checked"))
        {
          var rowC = $('#tableau_complexe').datagrid('getSelected');
          if (rowC){
            a.href = 'BDD/db_remove.php?ID='+rowC.ID+'&val=c'  
          }
        } else {
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
            a.href = 'BDD/db_remove.php?ID='+rowS.ID+'&val=c'  
          }
        }
      } 

      // Action du bouton modifier, prend l'id selectionner du tableau actif et renvoie vers modif-commande avec la commande a modifer
      function getIDModif(){
        var a = document.getElementById('modif'); 
        if ($('#parameters').is(":checked"))
        {
          var rowC = $('#tableau_complexe').datagrid('getSelected');
          if (rowC){
          a.href = 'commande/modif-commande.php?ID='+rowC.ID+'';
          }
        } else {
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
          a.href = 'commande/modif-commande.php?ID='+rowS.ID+'';
          }
        }
      }

      // Function qui permet d'effectuer la recherche du tableau simple (S), la fonction interagi avec un JS du datagrid (de Jquery)
      function doSearchS(){
        $('#tableau_simple').datagrid('load',{
          Designation: $('#DesignationS').val(),
          Destinataire: $('#DestinataireS').val(),
          site: $('#siteS').val(),
          ServiceFait: $('#ServiceFaitS').val(),
          EtatLivraison: $('#EtatLivraisonS').val()
        });
      }

      // De même que pour la précédente mais pour le tableau complexe.
      function doSearchC(){
        $('#tableau_complexe').datagrid('load',{
          Designation: $('#DesignationC').val(),
          Destinataire: $('#DestinataireC').val(),
          site: $('#siteC').val(),
          ServiceFait: $('#ServiceFaitC').val(),
          EtatLivraison: $('#EtatLivraisonC').val()
        });
      }

      // Checkbox des tableaux, si cocher affiche le tableau complexe sinon le simple
      function check(cb){
        if($(cb).is(":checked"))
        {
          doSearchC()
          $('#Simple').hide();
          $('#Complexe').show();
          $('#Simple').css('visibility', 'hidden');
          $('#Complexe').css('visibility', 'visible');
          $('#Complexe').css('height', 'auto');
          $('#Complexe').css('overflow', 'visible');
        } else {
          $('#Simple').show();
          $('#Complexe').hide();
          $('#Simple').css('visibility', 'visible');
          $('#Complexe').css('visibility', 'hidden');
        }
      }


      // Popup pour confirmer la suppression de la commande
      function openValidation()
        {
          if ($('#parameters').is(":checked"))
          {
            if (($('#tableau_complexe').datagrid('getSelected')))
            {
                $('#validation').window('open');
            }
          } else {
            if (($('#tableau_simple').datagrid('getSelected')))
            {
              $('#validation').window('open');
            }
          }
      } 
    </script>
  </head>


  <body class="u-body">
    <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
    <?php include 'include/header.html'; ?>



   <!-- ================================================================================= TABLEAU SIMPLE ====================================================================================== -->
   <section class="u-clearfix u-section-1" id="sec-b38d" style="padding:10px;">
      <div class="u-clearfix u-sheet u-sheet-1" id="Simple" style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
        <div class="u-align-center u-clearfix u-custom-html u-custom-html-1">
            <!-- Création du tableau -->
            <table id="tableau_simple" toolbar="#tb" class="easyui-datagrid" fitColumns="true" style="width:1150px;height:600px" url="BDD/datagrid/datagrid_commande_simple.php" data-options="nowrap:false, striped:true, singleSelect:true, collapsible:true,">
              <!-- Nom des colonnes -->
              <thead>
                <tr>
                  <th data-options="field:'ID',align:'center'" width="3%">ID</th>
                  <th data-options="field:'designation',align:'left'" width="32%">Designation</th>
                  <th data-options="field:'destinataire',align:'center'" width="12%">Destinataire</th>
                  <th data-options="field:'site',align:'center'" width="6%">Site</th>
                  <th data-options="field:'ServiceFait',align:'center'" width="9%">État service</th>
                  <th data-options="field:'EtatLivraison',align:'center'" width="9%">État livraison</th>
                  <th data-options="field:'commentaire',align:'left'" width="30%">Commentaire</th>
                </tr>
              </thead>
            </table>
        <!-- Recherche -->
          <div id="tb" style="padding:3px ">
            <!-- Designation -->
            <input id="DesignationS" autocomplete="off" name="Designation" style="line-height:26px;border:1px solid #ccc"  placeholder="Designation"></input>

            <!-- Destinataire -->
            <input id="DestinataireS" autocomplete="off" name="Destinataire" style="line-height:26px;border:1px solid #ccc" placeholder="Destinataire" ></input>

            <!-- Site (liste déroulante avec choix proposer) -->
            <span>Site:</span>
            <select id="siteS" name="site" style="line-height:26px;border:1px solid #ccc">
              <!-- Selectionne les sites dans la table site de la BDD -->
              <?php
                $reponse = $conn->query('SELECT s.nom FROM site s WHERE s.Nom!="' . $_POST['site'] . '" '); 
                $reponse1 = $conn->query('SELECT s.nom FROM site s WHERE s.Nom="' . $_POST['site'] . '" ');
                while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['nom'] . '</option>'; }
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['nom'] . '</option>'; }
               ?>
            </select>
            
            <!-- Service (liste déroulante avec choix proposer) -->
            <span>Service:</span>
            <select id="ServiceFaitS" name="ServiceFait" style="line-height:26px;border:1px solid #ccc">
              <?php 
                $reponse = $conn->query('SELECT s.etat FROM servicefait s '); 
                echo '<option></option>'; 
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } 
              ?>
            </select>

            <!-- livraison (liste déroulante avec choix proposer) -->
            <span>Livraison:</span>
            <select id="EtatLivraisonS"  style="line-height:26px;border:1px solid #ccc">
              <?php
                $reponse = $conn->query('SELECT e.etat FROM etatlivraison e WHERE e.etat!="' . $_POST['EtatLivraison'] . '" '); 
                $reponse1 = $conn->query('SELECT e.etat FROM etatlivraison e WHERE e.etat="' . $_POST['EtatLivraison'] . '" ');
                while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['etat'] . '</option>'; }
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } 
              ?>
            </select>

            <a class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchS()">Rechercher</a>
            <a href="commandes.php" class="easyui-linkbutton" plain="false" iconCls="icon-reload">Rafraîchir</a>
            <!-- Bouton d'exporation qui interagi avec un JS (datagrid-export) (qui n'est pas à moi) -->
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('toExcel','dg.xls')">Vers Excel</a>
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('print','DataGrid')">Vers PDF</a>
            

          </div>
        </div>
      </div>



<!-- ================================================================================= TABLEAU COMPLEXE ====================================================================================== -->
      <div class="u-clearfix u-sheet u-sheet-1" id="Complexe" style="visibility: hidden;  margin: 0; height: 1px; overflow: hidden;">
        <div class="u-align-center u-clearfix u-custom-html u-custom-html-1" style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
          <!-- Tableau -->
          <table id="tableau_complexe" class="easyui-datagrid" toolbar="#tb2" title="" style="width:1880px;height:600px" data-options="nowrap:false,striped:true,singleSelect:true,collapsible:true,url:'BDD/datagrid/datagrid_commande_complexe.php'">
            <thead>
              <tr>
                <!-- nom des colonnes -->
                <th data-options="field:'ID',align:'center'" width="2%">ID</th>
                <th data-options="field:'designation',align:'left'" width="15%">Designation</th>
                <th data-options="field:'destinataire',align:'center'" width="7%">Destinataire</th>
                <th data-options="field:'site',align:'center'" width="3%">Site</th>
                <th data-options="field:'fournisseur',align:'center'" width="6%">Fournisseur</th>
                <th data-options="field:'dateDemandeAchat',align:'center'" width="8%">Date demande achat</th>
                <th data-options="field:'numDemandeAchat',align:'center'" width="9%">Numéro demande achat</th>
                <th data-options="field:'dateValidation',align:'center'" width="7%">Date Validation</th>
                <th data-options="field:'dateBonCommande',align:'center'" width="8%">Date bon commande</th>
                <th data-options="field:'numBonCommande',align:'center'" width="9%">Numéro bon commande</th>
                <th data-options="field:'dateConfirmationCommande',align:'center'" width="7%">Date confirmation</th>
                <th data-options="field:'ServiceFait',align:'center'" width="6%">État service</th>
                <th data-options="field:'dateLivraison',align:'center'" width="7%">Date livraison</th>
                <th data-options="field:'EtatLivraison',align:'center'" width="6%">État livraison</th>
                <th data-options="field:'commentaire',align:'left'" width="15%">Commentaire</th>
              </tr>
            </thead>
          </table>

          <!-- Recherche -->
          <div id="tb2" style="padding:3px ">
            <!-- Designation -->
            <input id="DesignationC" autocomplete="off" name="Designation" style="line-height:26px;border:1px solid #ccc"  placeholder="Designation"></input>

            <!-- Destinataire -->
            <input id="DestinataireC" autocomplete="off" name="Destinataire" style="line-height:26px;border:1px solid #ccc" placeholder="Destinataire" ></input>

            <!-- Site -->
            <span>Site:</span>
            <select id="siteC" name="site" style="line-height:26px;border:1px solid #ccc">
             <?php 
                $reponse = $conn->query('SELECT s.nom FROM site s WHERE s.Nom!="' . $_POST['site'] . '" '); 
                $reponse1 = $conn->query('SELECT s.nom FROM site s WHERE s.Nom="' . $_POST['site'] . '" ');
                while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['nom'] . '</option>'; }
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['nom'] . '</option>'; } 
              ?>
            </select>

            <!-- Service -->
            <span>Service:</span>
            <select id="ServiceFaitC" name="ServiceFait" style="line-height:26px;border:1px solid #ccc">
              <?php $reponse = $conn->query('SELECT s.etat FROM servicefait s '); echo '<option></option>'; while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } ?>
            </select>

            <!-- Livraison -->
            <span>Livraison:</span>
            <select id="EtatLivraisonC"  style="line-height:26px;border:1px solid #ccc">
              <?php 
                $reponse = $conn->query('SELECT e.etat FROM etatlivraison e WHERE e.etat!="' . $_POST['EtatLivraison'] . '" '); 
                $reponse1 = $conn->query('SELECT e.etat FROM etatlivraison e WHERE e.etat="' . $_POST['EtatLivraison'] . '" ');
                while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['etat'] . '</option>'; }
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } 
              ?>
            </select>

            <a class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchC()">Rechercher</a>
            <a href="commandes.php" class="easyui-linkbutton" plain="false" iconCls="icon-reload">Rafraîchir</a>
            <!-- Bouton d'exporation qui interagi avec un JS (datagrid-export) (qui n'est pas à moi) -->
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_complexe').datagrid('toExcel','dg.xls')">Vers Excel</a>
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_complexe').datagrid('print','DataGrid')">Vers PDF</a>

          </div>
        </div>
      </div>
    </section>

 
    <!-- Checkbox pour l'affichage des tableaux -->
    <div style="margin: 10px auto; width: max-content; " >
      <input  type="checkbox" autocomplete="off" id="parameters" onclick="check(this);" <?php 
      
      
      
          // Si user = air-lh est admin afficher le panel pour gérer les comptes
          $getUser=$conn->prepare("SELECT tableau_setting FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
          $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
          $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

          if ($rowUser["tableau_setting"] == "on") 
          {
            echo "checked";
          }
          else
          {
            echo "unchecked";
          }
                
                
      
      
      
      ?>>
      <label for="parameters">Tableau avancé</label>
    </div>
          
   <!-- Bouton d'interaction avec les datagrid (aout,modif,suppression) -->
    <section class="u-clearfix u-section-5" id="sec-9bc6">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1">
                <a style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" href="commande/ajout-commande.php" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-1">Ajouter une commande</a>
              </div>
            </div>
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2">
                <a style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" id="modif" onclick="getIDModif();"  class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Modifier la commande</a>
              </div>
            </div>
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3">
                <a  style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" onclick="openValidation();" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-3">Supprimer la commande</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  
    <!-- Code de la popup de confirmation de suppresion -->
    <div id="validation" class="easyui-window" title=" Suppression" data-options="modal:true,closed:true,inline:true,border:'thin',cls:'c5'" style="width:500px;height:200px;padding:10px;">
    <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'center',border:false" style="text-align: center ; min-height: 10em; display: table-cell;vertical-align: middle;">
                <B>Voulez vous supprimer cette commande ?</B>
            </div>
            <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" id="del" onclick="getIDDel();" style="width:80px">Valider</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"  onclick="$('#validation').window('close')"  style="width:80px">Annuler</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.easyui-window').window({
            collapsible: false,
            minimizable: false,
            maximizable: false,
            closable: false
        });
    </script>
    <style type="text/css" scoped="scoped">
        .w-content{
            padding:5px 10px;
        }
    </style>




<footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" style="position: absolute; width: 100%; bottom: 0;"></footer>
    <section class="u-backlink u-clearfix u-grey-80" style="position: absolute; width: 100%; bottom: 0;">
      <a href="mailto:arthur.heude@laposte.net"><h8 style="color:white;"> <b>2022 </b>- Arthur HEUDE</h8></a>
    </section>




  </body>
</html>