<?php 
// Importation de la connexion à la BDD
include '../BDD/conn.php'; 

// Ouvertur de la session de l'utilisateur
session_start();

// Si user = air-lh est admin afficher le panel pour gérer les comptes
$getUser=$conn->prepare("SELECT permission FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
$getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
$rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

// Verif qu'il soit connecter; si non envoie vers page de connexion
if ($rowUser["permission"] == "admin")	
{}
else {
  header("location: ../connexion.php");
}
?>

<!-- Importation des CSS et JS, reglage du site -->
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Gestion Compte</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="../CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="../CSS/Commandes.css" media="screen">
    <script class="u-script" type="text/javascript" src="../include/JS/nicepage.js" defer=""></script>

    <!-- JQUERY -->
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/demo.css">
    <script type="text/javascript" src="../include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/color.css">
    <script type="text/javascript" src="../include/Jquery/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/include/JS/datagrid-export.js"></script>


    <!-- Javascript -->
    <script type="text/javascript">
      // Lorsque le site est prêt charge les tableaux en fonction des variables POST de l'accueil
       $(document).ready(function() {
          doSearchS();
        });
      
      // Action du bouton supprimer, la fonction regarde qu'elle tableau est actif et envoie l'ID de la commande avec la val=c (commande) à db_remove
      function getIDDel(){
        var a = document.getElementById('del'); 
      
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
            a.href = '../BDD/compte/db_remove.php?ID='+rowS.user_id+''  
           
          }
      } 

      // Action du bouton modifier, prend l'id selectionner du tableau actif et renvoie vers modif-commande avec la commande a modifer
      function getIDModif(){
        var a = document.getElementById('modif'); 
          var rowS = $('#tableau_simple').datagrid('getSelected');
          if (rowS){
          a.href = 'modif-compte.php?ID='+rowS.user_id+'';
          }
      }

      // Function qui permet d'effectuer la recherche du tableau simple (S), la fonction interagi avec un JS du datagrid (de Jquery)
      function doSearchS(){
        $('#tableau_simple').datagrid('load',{
          user_id: $('#user_id').val(),
          username: $('#username').val(),
          site: $('#site').val(),
          permission: $('#permission').val(),
          tableau_setting: $('#tableau_setting').val()
        });
      }






      // Popup pour confirmer la suppression de la commande
      function openValidation()
        {
            if (($('#tableau_simple').datagrid('getSelected')))
            {
              $('#validation').window('open');
            }
      } 
    </script>
  </head>


  <body class="u-body">
    <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
    <?php include '../include/header.html'; ?>



   <!-- ================================================================================= TABLEAU SIMPLE ====================================================================================== -->
   <section class="u-clearfix u-section-1" id="sec-b38d" style="padding:10px;">
      <div class="u-clearfix u-sheet u-sheet-1" id="Simple" style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
        <div class="u-align-center u-clearfix u-custom-html u-custom-html-1">
            <!-- Création du tableau -->
            <table id="tableau_simple" toolbar="#tb" class="easyui-datagrid" fitColumns="true" style="width:1150px;height:600px" url="../BDD/datagrid/datagrid_compte.php" data-options="nowrap:false, striped:true, singleSelect:true, collapsible:true,">
              <!-- Nom des colonnes -->
              <thead>
                <tr>
                  <th data-options="field:'user_id',align:'center'" width="5%">ID</th>
                  <th data-options="field:'username',align:'left'" width="32%">Identifiant</th>
                  <th data-options="field:'password',align:'center'" width="35%">Mot de passe</th>
                  <th data-options="field:'site',align:'center'" width="10%">Site</th>
                  <th data-options="field:'permission',align:'center'" width="10%">Permission</th>
                  <th data-options="field:'tableau_setting',align:'center'" width="10%">Préférence</th>
                </tr>
              </thead>
            </table>
        <!-- Recherche -->
          <div id="tb" style="padding:3px ">
            <!-- User_id -->
            <input id="user_id" autocomplete="off" name="user_id" style="line-height:26px;border:1px solid #ccc"  placeholder="ID"></input>

            <!-- Username -->
            <input id="username" autocomplete="off" name="username" style="line-height:26px;border:1px solid #ccc"  placeholder="Identifiant"></input>
                      
            <!-- Site (liste déroulante avec choix proposer) -->
            <span>Site:</span>
            <select id="site" name="site" style="line-height:26px;border:1px solid #ccc">
              <!-- Selectionne les sites dans la table site de la BDD -->
              <?php
                $reponse = $conn->query('SELECT s.nom FROM site s WHERE s.Nom!="' . $_POST['site'] . '" '); 
                //$reponse1 = $conn->query('SELECT s.nom FROM site s WHERE s.Nom="' . $_POST['site'] . '" ');
                //while ($donnees1 = $reponse1->fetch()) { echo '<option>' . $donnees1['nom'] . '</option>'; }
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['nom'] . '</option>'; }
               ?>
            </select>
            
         

            <!-- permission (liste déroulante avec choix proposer) -->
            <span>Permission:</span>
            <select id="permission"  style="line-height:26px;border:1px solid #ccc">
              <?php
                $reponse = $conn->query('SELECT p.etat FROM permissions p'); 
                echo '<option></option>';
                while ($donnees = $reponse->fetch()) { echo '<option>' . $donnees['etat'] . '</option>'; } 
              ?>
            </select>

            <!-- permission (liste déroulante avec choix proposer) -->
            <span>Préférence:</span>
            <select id="tableau_setting"  style="line-height:26px;border:1px solid #ccc">
              <?php
                 echo '<option></option>';
                 echo '<option>on</option>';
                 echo '<option>off</option>';
              ?>
            </select>

            <a class="easyui-linkbutton" plain="false" iconCls="icon-search" onclick="doSearchS()">Rechercher</a>
            <a href="gestion-compte.php" class="easyui-linkbutton" plain="false" iconCls="icon-reload">Rafraîchir</a>
            <!-- Bouton d'exporation qui interagi avec un JS (datagrid-export) (qui n'est pas à moi) -->
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('toExcel','dg.xls')">Vers Excel</a>
            <a href="javascript:;" class="easyui-linkbutton" onclick="$('#tableau_simple').datagrid('print','DataGrid')">Vers PDF</a>
            

          </div>
        </div>
      </div>
    </section>

 
          
   <!-- Bouton d'interaction avec les datagrid (aout,modif,suppression) -->
    <section class="u-clearfix u-section-5" id="sec-9bc6">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-list u-list-1">
          <div class="u-repeater u-repeater-1">
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1">
                <a style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" href="ajout-compte.php" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-1">Ajouter un compte</a>
              </div>
            </div>
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2">
                <a style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" id="modif" onclick="getIDModif();"  class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-2">Modifier le compte</a>
              </div>
            </div>
            <div class="u-container-style u-list-item u-repeater-item">
              <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3">
                <a  style="box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.20);" onclick="openValidation();" class="u-btn u-button-style u-custom-item u-hover-palette-1-dark-1 u-palette-1-base u-btn-3">Supprimer le compte</a>
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
                <B>Voulez vous supprimer ce compte ?</B>
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
  </body>
</html>