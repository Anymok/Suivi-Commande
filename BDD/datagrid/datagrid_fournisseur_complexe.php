<?php
	// Connexion à la BDD
	include '../conn.php';
	// Ouverture de la session
	session_start();
	// Regarde si user est co
	if(isset($_SESSION["user_login"]))	
	{}
	else {
	  header("location: ../../connexion.php");
	}

// si la variable POST entreprise n'est pas vide
if (!empty($_POST['Entreprise'])) 
{
	$Entreprise =  isset($_POST['Entreprise']) ? "%" . strval($_POST['Entreprise']) . "%" : 'Entreprise' ;  // recupère la variable entreprise avec des % autour 
	$Entreprise = "'" . $Entreprise . "'";
}
else {
	$Entreprise = 'Entreprise'; // si elle est vide la renommée entreprise
}

// De cette façons si la variable est vide ce sera variable = variable sinon variable sera égale à %variable% (les % veulent dire qui comprend, par exemple toutes variable qui contienne "var"  )

	$result = array();
					$where = " Entreprise like ". $Entreprise ; // raccourcis du WHERE
				
					$rs = $conn->query("select count(*) from fournisseur where" . $where); // On compte le nombre de fournisseur
					$row = $rs->fetch(PDO::FETCH_NUM);
					
					
					$rs = $conn->query("select * from fournisseur where" . $where); // on selectionne les fournisseurs
					
					$items = array(); // on met tous dans un tableau
					while($row = $rs->fetch()){  // que l'on parcours
						array_push($items, $row); 
					}
					$result["rows"] = $items; // on recupère les données
				
					echo json_encode($result); // puis on les écris sous format json, de l'autre coter mon datagrid pourra les lire et assimiler.
?>



