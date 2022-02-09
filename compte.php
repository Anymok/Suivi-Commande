<?php 
// Importation de la connexion à la BDD
include 'BDD/conn.php'; 

// Ouvertur de la session de l'utilisateur
session_start();

/// Partie MDP modif
if(isset($_REQUEST['btn_login']))	//Sur l'action du clique connexion
{
  $getUser=$conn->prepare("SELECT * FROM tbl_user t WHERE t.user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
  $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
  $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

	$username	=strip_tags($rowUser["username"]);	//prendre la valeur user
	$password_last	=strip_tags($_REQUEST["password_last"]); //prendre la valeur MDP
  $password_new	=strip_tags($_REQUEST["password_new"]); //prendre la valeur MDP
		
	if(empty($username)){						
		$errorMsg[]="Saisir un utilisateur";	//Erreur en cas de user vide
	} else if(empty($password_last)){
		$errorMsg[]="Saisir un mot de passe";	//Erreur en cas de MDP vide
	} else {
		try
		{
			$select_stmt=$conn->prepare("SELECT * FROM tbl_user WHERE username=:uname"); //Recupère le nombre de user égale au nom de mon utilisateur
			$select_stmt->execute(array(':uname'=>$username));	
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			if($select_stmt->rowCount() > 0)	//S'il en existe un continuer
			{
				if($username==$row["username"]) //Regarde si les comptes sont identiques (nom de compte), si oui continuer
				{
					if(password_verify($password_last, $row["password"])) // regarde si les MDP sont identiques (compare les hash des MDP)
					{
					


              $new_password1 = password_hash($password_new, PASSWORD_DEFAULT); // Hash le nouveau mdp
              
              $insert_stmt=$conn->prepare("UPDATE tbl_user SET password=:upassword WHERE username=:uname"); 		//met a jours le mdp de l'utilisateur
              if($insert_stmt->execute(array(	':uname'	=>$username, 
                              ':upassword'=>$new_password1 ))){
                                $loginMsg="Mot de passe modifié."; 
                              }
					} else {
						$errorMsg[]="Mot de passe incorrect."; // Mots de passe incorrect
					}
				}
			} else {
				$errorMsg[]="Utilisateur incorrect."; // User incorrect
			}
		} catch(PDOException $e) {
			$e->getMessage(); // En cas d'erreur SQL
		}		
	}
}



?>



<!--==================================    PARTIE HTML   ====================================================== -->

<!-- Importation des CSS et JS, reglage du site -->
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Compte</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="CSS/Accueil.css" media="screen">
    <script class="u-script" type="text/javascript" src="/include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="/include/JS/nicepage.js" defer=""></script>

    <!-- JQUERY -->
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/demo.css">
    <script type="text/javascript" src="../include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/color.css">
    <script type="text/javascript" src="../include/Jquery/jquery.easyui.min.js"></script>

    <script type="text/javascript">
      
      // Au chargement du site faire
      $(document).ready(function() {

        $("#setting").click(function () {
          document.location.href="/BDD/compte/tableau_setting.php"; 
        });
    
            // Une fonction qui alterne l'image et affiche le mdp (bouton pour afficher le mdp)
            $("#image_last").click(function () {
              var pass = document.getElementById('password_last'); 
              var src = ($(this).attr('src') === '../images/open-eye.png')
              ? '../images/closed-eye.png'
              : '../images/open-eye.png';
              $(this).attr('src', src);

              if (pass.type == 'password')
              {
                pass.type = 'text';
              }
              else {
                pass.type = 'password';
              }
            });

            // Une deuxième fonction pour le second bouton affiche mdp
            $("#image_new").click(function () {
              var pass = document.getElementById('password_new'); 
              var src = ($(this).attr('src') === '../images/open-eye.png')
              ? '../images/closed-eye.png'
              : '../images/open-eye.png';
              $(this).attr('src', src);

              if (pass.type == 'password')
              {
                pass.type = 'text';
              }
              else {
                pass.type = 'password';
              }
            });
      });


    </script>
  </head>


	<?php
		// En cas d'erreur, l'afficher
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger" style="position: absolute; top: 27%; z-index: 100; right: 21%; color: red;">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		// En cas de success afficher
		if(isset($loginMsg))
		{
		?>
			<div class="alert alert-success" style="position: absolute; top: 27%; z-index: 100; right: 21%; color: green;">
				<strong><?php echo $loginMsg; ?></strong>
			</div>
        <?php
		}
	?>  

  <body class="u-body">
    <!-- Importation du HEADER (bar du haut avec les menus et logo)-->
    <?php include 'include/header.html'; ?>

  
    <!-- Compte -->
    <div style="width: 48%; height: 30%; left: 1%; top: 10%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.30); box-sizing: border-box; position: absolute; background-color: #DDE2E3; ">
      <h2 style="text-align:center; margin-top:3%;">Compte</h2>
        <div style="text-align:center; margin-top:3%;">
          <?php  
          /// Récupération des infos du compte
            $getUser=$conn->prepare("SELECT * FROM tbl_user t WHERE t.user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
            $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
            $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete 
          ?>
          <h5>ID : <b><?php echo $rowUser["user_id"];?> </b></h5> 
          <h5>Nom du compte : <b><?php echo $rowUser["username"];?></b></h5>
          <h5>Site : <b><?php echo $rowUser["site"];?> </b></h5> 
          <h5>Permission : <b><?php echo $rowUser["permission"];?> </b></h5> 
        </div>
    </div> 

    <!-- Préférence -->
    <div style="width: 48%; height: 30%; left: 1%; top: 45%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.30); box-sizing: border-box; position: absolute; background-color: #DDE2E3;">
      <h2 style="text-align:center; margin-top:5%;">Préférence</h2>
        <div style="text-align:center; margin-top:8%;">
          
        <input type="checkbox" autocomplete="off" id="setting" onclick="setting_php();"

        <?php 
              // Si user = air-lh est admin afficher le panel pour gérer les comptes
              $getUser=$conn->prepare("SELECT tableau_setting FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
              $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
              $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

              if ($rowUser["tableau_setting"] == "on") 
              {
                echo " checked";
              }
              else
              {
                echo " unchecked";
              }
          ?>
    
        >
        <label for="setting"> Tableau avancé</label>
      </div>
    </div>

    <!-- Modifier MDP -->
    <div style="width: 48%; height: 50%; right: 1%; top: 10%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.30); box-sizing: border-box; position: absolute; border-right:1px, black; background-color: #DDE2E3;">
      <h2 style="text-align:center; margin-top:5%; ">Modifier son mot de passe</h2>
      <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="sec-e5c1">
            <div class="u-clearfix u-sheet u-sheet-1" style="  position: absolute; margin-top: 10%; width: 50%; left: 25%;">
              <div class="u-form u-login-control u-form-1"  >
                  
                <!-- Form de modif mdp -->
                <form method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-30 u-form-vertical u-inner-form" style="padding: 10px;">

                  <!-- input ancien mdp -->
                      <div class="u-form-group u-form-password">
                        <label for="password-22e3" class="u-form-control-hidden u-label"></label>
                        <input   type="password" autocomplete="off" placeholder="Saisir l'ancien mot de passe" id="password_last" name="password_last" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
                      </div>

                  <!-- input nouveau mdp -->
                      <div class="u-form-group u-form-password">
                        <label for="password-22e3" class="u-form-control-hidden u-label"></label>
                        <input   type="password" autocomplete="off" placeholder="Saisir le nouveau mot de passe" id="password_new" name="password_new" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
                      </div>

                  <!-- bouton valider -->
                      <div class="u-align-left u-form-group u-form-submit" style="margin-left:32%;">
                        <a name="btn_login" class="u-btn u-btn-round u-btn-submit u-button-style u-radius-50 u-btn-1">Confirmer<br></a>
                        <input name="btn_login" type="submit" value="submit" class="u-form-control-hidden">
                      </div>

                </form>
              </div>

              <!-- Bouton pour afficher l'ancien mdp -->
              <input type="image"  id="image_last" src="../images/closed-eye.png" style="bottom: 72%; padding: 10px; position: absolute; right: 5%; max-width: 12%;"></input>
                <!-- Bouton pour afficher le nouveau mdp -->
              <input type="image"  id="image_new"  src="../images/closed-eye.png" style="bottom: 36%; padding: 10px; position: absolute; right: 5%; max-width: 12%;"></input>
	        </div>
      </section>
    </div>

    <!-- Gérer compte -->
    <?php
      // Si user = air-lh est admin afficher le panel pour gérer les comptes
      $getUser=$conn->prepare("SELECT permission FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
      $getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
      $rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

      if ($rowUser["permission"] == "admin") 
      {
        // Afficher la section panel compte
      echo '<div style="width: 48%; height: 23%; right: 1%; top: 64%; bottom: 1%; box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.30); box-sizing: border-box; position: absolute; background-color: #DDE2E3;"><h2 style="text-align:center; margin-top:5%;">Gestion des comptes</h2><div style="text-align:center; margin-top:8%;"><!-- bouton accès --><div class="u-align-left u-form-group u-form-submit" style="top: 50%; position: absolute; left: 44%;"><a href="/compte/gestion-compte.php" class="u-btn u-btn-round u-btn-submit u-button-style u-radius-50 u-btn-1">Gérer<br></a><input  type="button"  class="u-form-control-hidden"></div></div></div>';
      }
    ?>


<footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" style="position: absolute; width: 100%; bottom: 0;"></footer>
    <section class="u-backlink u-clearfix u-grey-80" style="position: absolute; width: 100%; bottom: 0;">
      <a href="mailto:arthur.heude@laposte.net"><h8 style="color:white;"> <b>2022 </b>- Arthur HEUDE</h8></a>
    </section>

  </body>
</html>
