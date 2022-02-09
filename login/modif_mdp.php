
<?php
// Connexion à la BDD
require_once '../BDD/conn.php';





if(isset($_REQUEST['btn_login']))	// Lors du clique sur le bouton
{
	$username	=strip_tags($_REQUEST["username"]);	//prendre la valeur du input username
	$password	=strip_tags($_REQUEST["password"]);			//prendre la valeur du input password
  $new_password	=strip_tags($_REQUEST["new_password"]);
		
	if(empty($username)){						
		$errorMsg[]="Saisir un utilisateur";	//Si le username est vide envoyer une alert
	}
	else if(empty($password)){
		$errorMsg[]="Saisir un mots de passe";	//Si le mots de passe est vide envoyer une alert
	}
	else
	{
		try
		{
			$select_stmt=$conn->prepare("SELECT * FROM tbl_user WHERE username=:uname"); //Savoir si notre user existe 
			$select_stmt->execute(array(':uname'=>$username));	
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			if($select_stmt->rowCount() > 0)	//Si un utilisateur existe continuer
			{
				if($username==$row["username"])  // Verifier que les user corresponde bien
				{
					if(password_verify($password, $row["password"]))  // vérifie que les mots de passe son les même
					{
            $new_password1 = password_hash($new_password, PASSWORD_DEFAULT); // Hash le nouveau mdp
            
            $insert_stmt=$conn->prepare("UPDATE tbl_user SET password=:upassword WHERE username=:uname"); 		//met a jours le mdp de l'utilisateur
            if($insert_stmt->execute(array(	':uname'	=>$username, 
                            ':upassword'=>$new_password1 ))){
                              
              $registerMsg="Mots de passe changer."; 
              header("location: ../connexion.php");	// Renvoie vers connexion
            }
					}
					else
					{
						$errorMsg[]="Mots de passe incorrect"; // Erreur si le mdp ne correspond pas au user
					}
				}
			}
			else
			{
				$errorMsg[]="Utilisateur incorrect";// Erreur si le user n'existe pas
			}
		}
		catch(PDOException $e)
		{
			$e->getMessage(); // En cas d'erreur sql
		}		
	}
}
?>
<!-- parametre et importation de la config de la page -->
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <title>Modif MDP</title>
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
  </head>
  <script type="text/javascript">
    // Au chargement du site faire
    $(document).ready(function() {

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

  <?php
        // Script PHP pour l'affichage de l'erreur
        // En cas d'erreur
        if(isset($errorMsg))
        {
          foreach($errorMsg as $error)
          {
          ?>
            <div class="alert alert-danger">
              <strong><?php echo $error; ?></strong>
            </div>
                <?php
          }
        }
        // En cas de réussite
        if(isset($loginMsg))
        {
        ?>
          <div class="alert alert-success">
            <strong><?php echo $loginMsg; ?></strong>
          </div>
            <?php
        }
  ?>   
  
  <body class="u-body u-image">
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="sec-e5c1">
      <div class="u-clearfix u-sheet u-sheet-1" style="position:absolute; margin-top:10%;">
        <div class="u-form u-login-control u-form-1">
            
          <!-- Form de modif mdp -->
          <form method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-30 u-form-vertical u-inner-form" source="custom" name="form-4" style="padding: 10px;">

            <!-- input utilisateur -->
                <div class="u-form-group u-form-name">
                  <label for="username-22e3" class="u-form-control-hidden u-label"></label>
                  <input type="text" autocomplete="off" placeholder="Saisir votre utilisateur" id="username-22e3" name="username" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
                </div>

            <!-- input ancien mdp -->
                <div class="u-form-group u-form-password">
                  <label for="password-22e3" class="u-form-control-hidden u-label"></label>
                  <input type="password" autocomplete="off" placeholder="Saisir l'ancien mots de passe" id="password_last" name="password" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
                </div>

            <!-- input nouveau mdp -->
                <div class="u-form-group u-form-password">
                  <label for="password-22e3" class="u-form-control-hidden u-label"></label>
                  <input type="password" autocomplete="off" placeholder="Saisir le nouveau mots de passe" id="password_new" name="new_password" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
                </div>

            <!-- bouton valider -->
                <div class="u-align-left u-form-group u-form-submit">
                  <a name="btn_login" class="u-btn u-btn-round u-btn-submit u-button-style u-radius-50 u-btn-1">Confirmer<br></a>
                  <input name="btn_login" type="submit" value="submit" class="u-form-control-hidden">
                </div>

          </form>
        </div>

        <!-- Bouton pour afficher l'ancien mdp -->
        <input type="image"  id="image_last" src="../images/closed-eye.png" style="bottom:53%;padding:10px; position:absolute; right: 27%; max-width: 6%;"></input>
          <!-- Bouton pour afficher le nouveau mdp -->
        <input type="image"  id="image_new"  src="../images/closed-eye.png" style="bottom:41%;padding:10px; position:absolute; right: 27%; max-width: 6%;"></input>
        <!-- Bouton de redirection vers connexion -->
		    <a href="../connexion.php" class="u-border-1 u-border-active-palette-2-base u-border-hover-palette-1-base u-btn u-button-style u-login-control u-login-forgot-password u-none u-text-body-alt-color u-btn-2">Connexion</a>
 
	    </div>
    </section>
  </body>
</html>