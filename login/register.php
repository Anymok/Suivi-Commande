<?php
// Connexion à la BDD
require_once "../BDD/conn.php";

if(isset($_REQUEST['btn_register'])) //Attend l'interaction avec le bouton confirmer
{
	$username	= strip_tags($_REQUEST['username']);	// Prend la valeur du username
	$password	= strip_tags($_REQUEST['password']);  // Prend la valeur du MDP
	$site	= strip_tags($_REQUEST['site']);	 // Prend la valur du site (LH, Marseille, etc)

		
	if(empty($username)){
		$errorMsg[]="Saisir un user";	//Erreur si input username est vide
	}
	else if (empty($password)){
		$errorMsg[]="Saisir un MDP";	//Erreur si input mdp est vide
  } else {	
		try
		{	
			$select_stmt=$conn->prepare("SELECT username FROM tbl_user WHERE username=:uname"); // Regarde si user existe
			$select_stmt->execute(array(':uname'=>$username)); 
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	

			if($row["username"]==$username){
				$errorMsg[]="Nom déjà existant.";	//Si non existe déjà erreur
			}
			else if(!isset($errorMsg)) //Si aucune erreur continuer
			{
				$new_password = password_hash($password, PASSWORD_DEFAULT); //hahsh le mdp
				
				$insert_stmt=$conn->prepare("INSERT INTO tbl_user	(username,site,password,permission,tableau_setting) VALUES (:uname,:usite,:upassword,:upermission,:utableau_setting)"); 		//requête sql pour ajout user		
				
				if($insert_stmt->execute(array(	':uname'	=>$username, 
												':usite'	=>$site, 
												':upassword'=>$new_password,
                        ':upermission'	=>'user', 
                        ':utableau_setting'	=>'off'  ))){
													
					$registerMsg="Inscription terminer."; //Success
          header("location:../connexion.php"); // Redirection
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); // En cas d'erreur sql
		}
	}
}
// Paramétrage du site
?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Register</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <link rel="stylesheet" href="../CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="../CSS/Connexion.css" media="screen">
    <script class="u-script" type="text/javascript" src="../include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="../include/JS/nicepage.js" defer=""></script>
	
    <!-- JQUERY -->
	  <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../include/Jquery/demo.css">
    <script type="text/javascript" src="../include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/Jquery/themes/color.css">
    <script type="text/javascript" src="../include/Jquery/jquery.easyui.min.js"></script>
 
    <script type="text/javascript">
      // Quand la page est prête faire
      $(document).ready(function() {
        // Fonction pour alterner l'image et le type du input password afin d'afficher le MDP
        $("#image").click(function () {
          var pass = document.getElementById('password'); 
          var src = ($(this).attr('src') === '../images/open-eye.png')
          ? '../images/closed-eye.png'
          : '../images/open-eye.png';
          $(this).attr('src', src);

          if (pass.type == 'password')
          {
            pass.type = 'text';
          } else {
            pass.type = 'password';
          }
        });
      });
    </script>
  </head>

  <?php
    // Script PHP pour l'affichage de l'erreur
    // En cas d'erreur
      if(isset($errorMsg))
      {
        foreach($errorMsg as $error)
        {
        ?>
          <div class="alert alert-danger">
            <strong>WRONG ! <?php echo $error; ?></strong>
          </div>
              <?php
        }
      }
      // En cas de réussite
      if(isset($registerMsg))
      {
      ?>
        <div class="alert alert-success">
          <strong><?php echo $registerMsg; ?></strong>
        </div>
          <?php
      }
	?>   

  <body class="u-body u-image">
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="sec-e5c1">
      <div class="u-clearfix u-sheet u-sheet-1" style="position:absolute; margin-top:10%;">
        <div class="u-form u-login-control u-form-1">
         <!-- Form du register --> 
        <form method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-30 u-form-vertical u-inner-form" source="custom" name="form-4" style="padding: 10px;">

            <!-- Input du user -->
            <div class="u-form-group u-form-name">
              <label for="username-22e3" class="u-form-control-hidden u-label"></label>
              <input type="text" autocomplete="off" placeholder="Saisir l'utilisateur" id="username-22e3" name="username" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
            </div>

            <!-- Input du MDP-->
            <div class="u-form-group u-form-password">
              <label for="password-22e3" class="u-form-control-hidden u-label"></label>
              <input type="password" autocomplete="off" placeholder="Saisir le mots de passe" id="password" name="password" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
            </div>
			
            <!-- Liste déroulante du site -->
            <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3" style="margin: 10px auto; width: max-content; ">
              <label for="select-5ee0" class="u-label">Site concerné</label>
              <div class="u-form-select-wrapper">
                <select id="select-5ee0" name="site"  class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required="required">
                  <!-- requête sql pour aller chercher les sites existant-->
                  <?php $reponse = $conn->query('SELECT s.nom FROM site s '); while ($donnees = $reponse->fetch()) { echo '<option style="color:grey;">' . $donnees['nom'] . '</option>'; } ?>
                </select>
                <!-- Logo flèche vers le bas pour derouler la liste -->
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>

            <!-- Bouton de validation -->
            <div class="u-align-left u-form-group u-form-submit">
              <a  class="u-btn u-btn-round u-btn-submit u-button-style u-radius-50 u-btn-1">S'inscrire<br></a>
              <input name="btn_register" type="submit" value="submit" class="u-form-control-hidden">
            </div>
          </form>
        </div>

          <!-- Bouton pour changer le MDP -->
		      <input type="image"  id="image"  src="../images/closed-eye.png" style="bottom:53%;padding:10px; position:absolute; right: 27%; max-width: 6%;"></input>
          <!-- Bouton de redirection vers connexion -->
          <a href="../connexion.php" class="u-border-1 u-border-active-palette-2-base u-border-hover-palette-1-base u-btn u-button-style u-login-control u-login-forgot-password u-none u-text-body-alt-color u-btn-2">Connexion</a>
      </div>
    </section>
  </body>
</html>