<?php
/// Regarde si l'utilisateur est connecter
if(isset($_SESSION["user_login"]))	
{
  // Si oui le redirige vers l'accueil
	header("location: accueil.php");
}
else {
  // Sinon l'envoie vers la page de connexion
  header("location: connexion.php");
}


?>