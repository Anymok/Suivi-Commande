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
    <title>Fournisseurs</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="CSS/Fournisseurs.css" media="screen">
    <script class="u-script" type="text/javascript" src="/include/JS/nicepage.js" defer=""></script>

    <!-- Importation des script de Jquery -->
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/demo.css">
    <script type="text/javascript" src="/include/Jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/include/Jquery/jquery.easyui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/color.css">
    <script type="text/javascript" src="/include/JS/datagrid-export.js"></script>

    <script type="text/javascript">
      // Au chargement du site faire
      $(document).ready(function() {
         
         doSearchS(); // Effecte une recherche pour charger le tableau
          check("#parameters");
        });
      // Function pour supprimer
      function getIDDel(){
        var a = document.getElementById('del'); 
        if ($('#parameters').is(":checked")) // regarde quel tableau est actif
        {
          var rowC = $('#tableau_complexe').datagrid('getSelected');
          if (rowC){
            a.href = 'BDD/db_remove.php?ID='+rowC.ID+'&val=f'  // Prend l'id de la commande et la renvoie  db_remove avec un get val=f pour dire que c un fournisseur
          }
        } else {
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
            a.href = 'BDD/db_remove.php?ID='+rowS.ID+'&val=f'   // Prend l'id de la commande et la renvoie  db_remove avec un get val=f pour dire que c un fournisseur
          }
        }
      } 

      // function pour modifier
      function getIDModif(){
        var a = document.getElementById('modif'); 
        if ($('#parameters').is(":checked"))
        {
          var rowC = $('#tableau_complexe').datagrid('getSelected'); // regarde quel tableau est actif
          if (rowC){
          a.href = 'fournisseur/modif-fournisseur.php?ID='+rowC.ID+''; // Prend l'id de la commande et la renvoie  db_modif avec un get val=f pour dire que c un fournisseur
          }
        } else {
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
          a.href = 'fournisseur/modif-fournisseur.php?ID='+rowS.ID+''; // Prend l'id de la commande et la renvoie  db_modif avec un get val=f pour dire que c un fournisseur
          }
        }
      }

      // Effectue une recherche pour la tableau simple
      function doSearchS(){
        $('#tableau_simple').datagrid('load',{ Entreprise: $('#EntrepriseS').val()
      });}

      // Effectue une recherche pour le tableau complexe
      function doSearchC(){
        $('#tableau_complexe').datagrid('load',{ Entreprise: $('#EntrepriseC').val() 
      });}

      // Permet de changer de tableau quand on clique sur la checkbox
      function check(cb)
      {
      if($(cb).is(":checked"))
      {
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

      // Ouvre un popup pour confirmer la suppresion
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
  <section class="u-clearfix u-section-1" id="sec-b37d" style="min-height:0; padding:10px;">
        <div class="u-clearfix u-sheet u-sheet-1" id="Simple"  style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
          <div class="u-align-center u-clearfix u-custom-html u-custom-html-1" style="min-height:0; ">
            <!-- Tableau simple -->
            <table id="tableau_simple" toolbar="#tb" class="easyui-datagrid" style="width:1150px;height:600px" url="BDD/datagrid/datagrid_fournisseur_simple.php" data-options="nowrap:false,striped:true,singleSelect:true,collapsible:true,">     
              <!-- nom des colonnes -->
              <thead>
                <tr>
                  <th data-options="field:'ID',align:'center'"  width="3%">ID</th>
                  <th data-options="field:'Entreprise'"  width="16%">Entreprise</th>
                  <th data-options="field:'Nom',align:'center'"  width="9%">Nom</th>
                  <th data-options="field:'Prenom',align:'center'"  width="9%">Prénom</th>
                  <th data-options="field:'Email',align:'center'"  width="15%">Email</th>
                  <th data-options="field:'Tel-fix',align:'center'"  width="13%">Téléphone Fixe</th>
                  <th data-options="field:'Tel-por',align:'center'"  width="13%">Téléphone Portable</th>
                  <th data-options="field:'url',align:'center'"  width="23%">Site Web</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

          <!-- Recherche -->
          <div id="tb" style="padding:3px">
            <!-- input Entreprise -->
            <span>Entreprise:</span>
            <input id="EntrepriseS" autocomplete="off" style="line-height:26px;border:1px solid #ccc">

            <a class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchS()">Rechercher</a> 
            <a href="fournisseurs.php" class="easyui-linkbutton" plain="false" iconCls="icon-reload" >Rafraîchir</a>
            <!-- Bouton d'exporation qui interagi avec un JS (datagrid-export) (qui n'est pas à moi) -->
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('toExcel','dg.xls')">Vers Excel</a>
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('print','DataGrid')">Vers PDF</a>
          </div>
 

       <!-- ================================================================================= TABLEAU COMPLEXE ====================================================================================== -->

      <div class="u-clearfix u-sheet u-sheet-1" id="Complexe" style="visibility: hidden;  margin: 0; height: 1px; overflow: hidden; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
        <div class="u-align-center u-clearfix u-custom-html u-custom-html-1" style="min-height:0; " >
          <!-- Tableau complexe -->
          <table id="tableau_complexe"  toolbar="#tb2" class="easyui-datagrid" title="" style="width:1880px;height:600px" data-options="nowrap:false,striped:true,singleSelect:true,collapsible:true,url:'datagrid_data1.json',url:'BDD/datagrid/datagrid_fournisseur_complexe.php'">
            <!-- Nom des colonnes -->
            <thead>
              <tr>
                <th data-options="field:'ID',align:'center'"  width="2%">ID</th>
                <th data-options="field:'Entreprise',align:'left'"  width="10%">Entreprise</th>
                <th data-options="field:'Nom',align:'center'"  width="7%">Nom</th>
                <th data-options="field:'Prenom',align:'center'"  width="7%">Prenom</th>
                <th data-options="field:'Email',align:'center'"  width="11%">Email</th>
                <th data-options="field:'Tel-fix',align:'center'"  width="8%">Téléphone Fixe</th>
                <th data-options="field:'Tel-por',align:'center'"  width="8%">Téléphone Portable</th>
                <th data-options="field:'url',align:'center'"  width="15%">Site Web</th>
                <th data-options="field:'Rue',align:'center'"  width="15%">Rue</th>
                <th data-options="field:'CP',align:'center'"  width="6%">Code Postal</th>
                <th data-options="field:'Ville',align:'center'"  width="6%">Ville</th>
                <th data-options="field:'Pays',align:'center'"  width="6%">Pays</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>

        <!-- Recherche -->
        <div id="tb2" style="padding:3px">
          <!-- input Entreprise -->
          <span>Entreprise:</span>
          <input id="EntrepriseC" autocomplete="off" style="line-height:26px;border:1px solid #ccc">

		      <a class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchC()">Rechercher</a>
          <a href="fournisseurs.php" class="easyui-linkbutton" plain="false" iconCls="icon-reload" >Rafraîchir</a>
          <!-- Bouton d'exporation qui interagi avec un JS (datagrid-export) (qui n'est pas à moi) -->
          <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_complexe').datagrid('toExcel','dg.xls')">Vers Excel</a>
          <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_complexe').datagrid('print','DataGrid')">Vers PDF</a>
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
        
    <!-- Partie interaction -->
    <section class="u-clearfix u-section-5" id="sec-9bc6">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <!-- Bouton ajout -->
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1">
                <a  style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" href="fournisseur/ajout-fournisseur.php" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-1">Ajouter un fournisseur</a>
              </div>
            </div>
            <!-- Bouton modifier -->
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2">
                <a  style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" id="modif" onclick="getIDModif();"  class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Modifier le fournisseur</a>
              </div>
            </div>
            <!-- Bouton suppression -->
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3">
                <a style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);"  onclick="openValidation();" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-3">Supprimer le fournisseur</a>
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
                <B>Voulez vous supprimer ce fournisseur ?</B>
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