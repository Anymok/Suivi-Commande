<?php
	// Connexion à la BDD
	include '../conn.php';
	// Ouverture de la session
	session_start();
	// regarde si user est co
	if(isset($_SESSION["user_login"]))	
	{}
	else {
	  header("location: ../../connexion.php");
	}

////////////////////////////////////////////////////// VARIABLE Designation /////////////////////////////////////////////////
if (!empty($_POST['Designation']))
{
	$Designation = isset($_POST['Designation']) ? "%" . strval($_POST['Designation']) . "%"  : 'Designation'; // On recupère la valeur
	$Designation = "'" . $Designation . "'";
}
else {
	$Designation = 'Designation'; // si c'est vide var = var
}

////////////////////////////////////////////////////// VARIABLE Destinataire /////////////////////////////////////////////////
if (!empty($_POST['Destinataire']))
{
	$Destinataire =  isset($_POST['Destinataire']) ? "%" . strval($_POST['Destinataire']) . "%" : 'Destinataire' ; // On recupère la valeur
	$Destinataire = "'" . $Destinataire . "'";
}
else {
	$Destinataire = 'Destinataire'; // si c'est vide var = var
}


////////////////////////////////////////////////////// VARIABLE SITE /////////////////////////////////////////////////
if (!empty($_POST['site']))
{
	$site = isset($_POST['site']) ? strval($_POST['site']) : 'site'; // On recupère la valeur
	$site = "'" . $site . "'";
}
else {
	$site = 'site'; // si c'est vide var = var
}

////////////////////////////////////////////////////// VARIABLE ETAT LIVRAISON /////////////////////////////////////////////////
if (!empty($_POST['EtatLivraison']))
{
	
	$EtatLivraison ="'" . isset($_POST['EtatLivraison']) ? strval($_POST['EtatLivraison']) : 'EtatLivraison' . "'"; // On recupère la valeur
	$EtatLivraison = "'" . $EtatLivraison . "'"; 
} else {
	$EtatLivraison = 'EtatLivraison'; // si c'est vide var = var
}

////////////////////////////////////////////////////// VARIABLE SERVICE /////////////////////////////////////////////////
if (!empty($_POST['ServiceFait']))
{
	
	$ServiceFait ="'" . isset($_POST['ServiceFait']) ? strval($_POST['ServiceFait']) : 'ServiceFait' . "'"; // On recupère la valeur
	$ServiceFait = "'" . $ServiceFait . "'";
} else {
	$ServiceFait = 'ServiceFait'; // si c'est vide var = var
}




	$result = array(); // mise en place d'un tableau
		
					// Raccouris WHERE
					$where = " ServiceFait like ". $ServiceFait ." and site like ". $site ." and EtatLivraison like ". $EtatLivraison ." and Destinataire like ". $Destinataire ." and Designation like ". $Designation .""; 
				
					// COmpte le nombre de commandes
					$rs = $conn->query("select count(*) from commandes where" . $where);
					$row = $rs->fetch(PDO::FETCH_NUM);
					
					// Selectionne tous dans commandes
					$rs = $conn->query("select * from commandes where" . $where);
					
					// parcours le tableau
					$items = array();
					while($row = $rs->fetch()){
						array_push($items, $row);
					}
					$result["rows"] = $items;
					
					echo json_encode($result);// Encode le resultat en JSON, le datagrid pourra le lire
?>



