<?php
// Connexion à la BDD
try {
$conn = new PDO('mysql:host=localhost;dbname=appli-suivi-commande;charset=utf8','suivi-commande', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Met toutes les pages en UT8
$conn -> exec('SET NAMES utf8');
}
catch(PDOEXCEPTION $e)
{
	$e->getMessage();

}

?>
