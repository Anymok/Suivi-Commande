<?php
// Connexion à la BDD
require_once 'BDD/conn.php';

// Ouverture de la session
session_start();

if(isset($_SESSION["user_login"]))	//Si user est déjà connecter
{
	header("location: accueil.php"); // rediriger vers accueil
}

if(isset($_REQUEST['btn_login']))	//Sur l'action du clique connexion
{
	$username	=strip_tags($_REQUEST["username"]);	//prendre la valeur user
	$password	=strip_tags($_REQUEST["password"]); //prendre la valeur MDP
		
	if(empty($username)){						
		$errorMsg[]="Saisir un identifiant.";	//Erreur en cas de user vide
	} else if(empty($password)){
		$errorMsg[]="Saisir un mot de passe.";	//Erreur en cas de MDP vide
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
					if(password_verify($password, $row["password"])) // regarde si les MDP sont identiques (compare les hash des MDP)
					{
						$_SESSION["user_login"] = $row["user_id"];	//la session est égale à l'ID de l'utilisateur

            			header("location: accueil.php"); // redirige vers accueil		
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
// Parametrage du site
?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
  	<title>Connexion</title>
  	<link rel="icon" type="image/png" sizes="16x16" href="../images/icon.png">
    <meta charset="utf-8">

    <link rel="stylesheet" href="CSS/nicepage.css" media="screen">
    <link rel="stylesheet" href="CSS/Connexion.css" media="screen">
    <script class="u-script" type="text/javascript" src="/include/JS/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="/include/JS/nicepage.js" defer=""></script>

    <!-- JQUERY -->
	<link rel="stylesheet" type="text/css" href="/include/Jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/include/Jquery/demo.css">
    <script type="text/javascript" src="/include/Jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/include/Jquery/themes/color.css">
    <script type="text/javascript" src="/include/Jquery/jquery.easyui.min.js"></script>
 
  	<script type="text/javascript">
		// Faire ceci quand le site est prêt
		$(document).ready(function() {
			// Fonction pour alterner l'image et le type du input password afin d'afficher le MDP
			$("#image").click(function () {
				var pass = document.getElementById('password'); 
				var src = ($(this).attr('src') === 'images/open-eye.png')
				? 'images/closed-eye.png'
				: 'images/open-eye.png';
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
		// En cas d'erreur, l'afficher
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger"  style="position: absolute; top: 34%; z-index: 100; color: red; left: 20%;">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		// En cas de success afficher
		if(isset($loginMsg))
		{
		?>
			<div class="alert alert-success"  style="position: absolute; top: 34%; z-index: 100; color: green; left: 20%;">
				<strong><?php echo $loginMsg; ?></strong>
			</div>
        <?php
		}
	?>   
		
  <body class="u-body u-image" style=" background-image: linear-gradient(0deg, rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('/images/background.jpg');
  background-position: 50% 50%;" >



    <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="sec-e5c1" style="margin-left: -96px;">
      <div class="u-clearfix u-sheet u-sheet-1" style="position:absolute; margin-top:10%;">
        <div class="u-form u-login-control u-form-1">
          
			<!-- Form de la connexion -->
			<form method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-30 u-form-vertical u-inner-form" source="custom" name="form-4" style="padding: 10px;">
				<!-- input username -->
				<div class="u-form-group u-form-name">
				<label for="username-22e3" class="u-form-control-hidden u-label"></label>
				<input type="text" autocomplete="off" placeholder="Saisir votre utilisateur" id="username-22e3" name="username" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
				</div>
				<!-- input mdp -->
				<div class="u-form-group u-form-password">
				<label for="password-22e3" class="u-form-control-hidden u-label"></label>
				<input type="password" autocomplete="off" placeholder="Saisir votre mot de passe" id="password" name="password" class="u-border-1 u-border-white u-input u-input-rectangle u-radius-50 u-white" required="">
				</div>
				<!-- button login -->
				<div class="u-align-left u-form-group u-form-submit">
				<a name="btn_login" class="u-btn u-btn-round u-btn-submit u-button-style u-radius-50 u-btn-1">Connexion<br>
				</a>
				<input name="btn_login" type="submit" value="submit" class="u-form-control-hidden">
				</div>
			</form>
        </div>
			<!-- Image pour afficher le mdp -->
			<input type="image"  id="image"  src="images/closed-eye.png" style="bottom:53%;padding:10px; position:absolute; right: 27%; max-width: 6%;"></input>
			<!-- Bouton Support -->
			<a href="mailto:cyrille.dufresnes@supmaritime.fr" class="u-border-1 u-border-active-palette-2-base u-border-hover-palette-1-base u-btn u-button-style u-login-control u-login-forgot-password u-none u-text-body-alt-color u-btn-2">Support</a>
			
		</div>
	</section>
	<div style="position:absolute; right:0; bottom:0;">
		<a href="https://www.google.fr/logos/2010/pacman10-i.html" target="_BLANK">Documentation</a>
	</div>
  </body>
</html>