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


<!--==================================    PARTIE HTML   ====================================================== -->

<!-- Importation des CSS et JS, reglage du site -->
<!DOCTYPE html>
<html style="font-size: 16px; background: #E5E5E5;">
  <head>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="CSS/Accueil.css" media="screen">
    <script class="u-script" type="text/javascript" src="/include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="/include/JS/nicepage.js" defer=""></script>

    <!-- Script JS -->
    <script type="text/javascript">
      // Fonction pour les redirections des boutons recherche.
      function getHREF($ID)
      {
        // Réupère l'ID du bouton
        ////////////////////////////
        // La prmière lettre correspond à la ville L pour Le havre, S pour Saint malo etc...
        // La deuxième lettre correspond à l'état de la commande,  T pour total, P pour partiel et N pour non livré.
        ////////////////////////////
        const sentence = $ID;
        const lettre1 = 0;
        const lettre2 = 1;

        /// Lecture de la première lettre pour ensuite attribuer le nom complet à une valeur qui servira de $_POST
          if (`${sentence.charAt(lettre1)}` == "L")
          { $site_val = "LH"; }

          if (`${sentence.charAt(lettre1)}` == "S")
          { $site_val = "SM"; }

          if (`${sentence.charAt(lettre1)}` == "C")
          { $site_val = "CS"; }
          
          if (`${sentence.charAt(lettre1)}` == "N")
          { $site_val = "NA"; }

          if (`${sentence.charAt(lettre1)}` == "M")
          { $site_val = "MRS"; }

          if (`${sentence.charAt(lettre1)}` == "E")
          { $site_val = "ENSM"; }
          
        /// Lecture de la deuxième lettre pour ensuite attribuer le nom complet à une valeur qui servira de $_POST
          if (`${sentence.charAt(lettre2)}` == "T")
          {  $etat_val = "Total"; }

          if (`${sentence.charAt(lettre2)}` == "P")
          {  $etat_val = "Partiel"; }

          if (`${sentence.charAt(lettre2)}` == "N")
          {  $etat_val = "Non livré"; }

        // Modifie la valeur du input hidden afin de le transferer en POST pour la valeur de la ville
        document.getElementById("I1").name="site"; 
        document.getElementById("I1").value=$site_val; 

        // Modifie la valeur du input hidden afin de le transferer en POST pour l'etat de la commande
        document.getElementById("I2").name="EtatLivraison"; 
        document.getElementById("I2").value=$etat_val; 
          
        // déclenche le form qui renvoie vers commande.php avec les donnés en POST
        document.getElementById("F1").submit();
      
      }
    </script>
  </head>


  <body class="u-body">
    <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
    <?php include 'include/header.html'; ?>

   

    <!-- Tableau -->
    <section class="u-align-center u-clearfix u-section-2" id="sec-ed2f">
      <div class="u-clearfix u-sheet u-sheet-1" >
        <div class="u-expanded-width u-table u-table-responsive u-table-1">
          <table class="u-table-entity u-table-entity-1" style="background-color: #DDE2E3; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.50);">
            <!-- Taille des cellules -->
            <colgroup>
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
            </colgroup>
            <!-- Nom des colonnes -->
            <thead class="u-align-center u-custom-color-1 u-table-header u-table-header-1">
              <tr style="height: 21px;">
                <th class="u-border-1 u-border-custom-color-1 u-table-cell">Site</th>
                <th class="u-border-1 u-border-custom-color-1 u-table-cell">Commandes livrées</th>
                <th class="u-border-1 u-border-custom-color-1 u-table-cell">Commandes partielles</th>
                <th class="u-border-1 u-border-custom-color-1 u-table-cell">Commandes non livrées</th>
              </tr>
            </thead>
            <!-- Nom des lignes et remplissage des lignes en allant compter les commandes dans la BDD-->
            <!-- Pour chaque case on selectionne les données nécessaires (le nombre de commandes de LH qui sont total par exemple) puis on affiche le résultat-->
            <!-- à drotie de chaque on place un bouton en forme de loupe qui active le JS avec comme données l'ID (première lettre de la ville et première lettre de l'état) -->
            <!-- Le JS créera des inputs hidden avec les valeur des _POST nécessaire à la recherche sur la page connexion. -->
            <tbody class="u-table-body">
              <tr style="height: 75px;">
                <td class="u-border-1 u-border-grey-30 u-first-column  u-table-cell u-table-cell-5", align="center"><B>Le Havre</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="LH" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?>     <input onclick='getHREF("LT")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:10%;"></input> </td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="LH" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("LP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:10%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="LH" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?>	<input onclick='getHREF("LN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:10%;"></input></td>
              </tr>
              <tr style="height: 76px;">
                <td class="u-border-1 u-border-grey-30 u-first-column  u-table-cell u-table-cell-9", align="center"><B>Saint-Malo</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="SM" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("ST")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:25%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="SM" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("SP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:25%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="SM" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("SN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:25%;"></input></td>
              </tr>
              <tr style="height: 76px;">
                <td class="u-border-1 u-border-grey-30 u-first-column  u-table-cell u-table-cell-13", align="center"><B>Césame</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="CS" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("CT")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:40%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="CS" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("CP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:40%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="CS" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("CN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:40%;"></input></td>
              </tr>
              <tr style="height: 76px;">
                <td class="u-border-1 u-border-grey-30 u-first-column  u-table-cell u-table-cell-17", align="center"><B>Nantes</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="NA" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("NT")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:55%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="NA" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("NP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:55%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="NA" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("NN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:55%;"></input></td>
              </tr>
              <tr style="height: 76px;">
                <td class="u-border-1 u-border-grey-30  u-table-cell u-table-cell-21", align="center"><B>Marseille</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="MRS" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("MT")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:70%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="MRS" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("MP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:70%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="MRS" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("MN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:70%;"></input></td>
              </tr>
              <tr style="height: 76px;">
                <td class="u-border-1 u-border-grey-30  u-table-cell u-table-cell-25", align="center"><B>ENSM</B></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="ENSM" AND EtatLivraison="Total"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("ET")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 50%; max-width: 6%;top:85%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="ENSM" AND EtatLivraison="Partiel"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("EP")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 25%; max-width: 6%;top:85%;"></input></td>
                <td class="u-border-1 u-border-grey-30 u-table-cell"><?php $reponse = $conn->query('SELECT count(*) as total FROM commandes c WHERE site="ENSM" AND EtatLivraison="Non Livré"'); $donnees = $reponse->fetch(); echo "" . $donnees["total"]; ?><input onclick='getHREF("EN")' type="image"  id="image"  src="images/search-logo.png" style="padding:20px; position:absolute; right: 0%; max-width: 6%;top:85%;"></input></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Le form qui renvoie le résultat du JS vers commandes.php-->
        <form id="F1" action="commandes.php" method="POST"><input id="I1" type="hidden"><input id="I2" type="hidden"></form>
     
      </div>
    </section>
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" style="position: absolute; width: 100%; bottom: 0;"></footer>
    <section class="u-backlink u-clearfix u-grey-80" style="position: absolute; width: 100%; bottom: 0;">
      <a href="mailto:arthur.heude@laposte.net"><h8 style="color:white;"> <b>2022 </b>- Arthur HEUDE</h8></a>
    </section>


  </body>
  
</html>
