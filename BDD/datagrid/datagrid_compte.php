<?php
	// Connexion à la BDD
	include '../conn.php';
// Ouvertur de la session de l'utilisateur
session_start();

// Si user = air-lh est admin afficher le panel pour gérer les comptes
$getUser=$conn->prepare("SELECT permission FROM tbl_user WHERE user_id=:uuser_id"); //on obtient la liste des comptes admin avec l'id du user de la session
$getUser->execute(array(':uuser_id'=>$_SESSION["user_login"]));	// on execute la requete
$rowUser=$getUser->fetch(PDO::FETCH_ASSOC); // lecture de la requete

// Verif qu'il soit connecter; si non envoie vers page de connexion
if ($rowUser["permission"] == "admin")	
{

// si la variable POST user_id n'est pas vide
if (!empty($_POST['user_id'])) 
{
	$user_id =  isset($_POST['user_id']) ? "%" . strval($_POST['user_id']) . "%" : 'user_id' ;  // recupère la variable user_id avec des % autour 
	$user_id = "'" . $user_id . "'";
}
else {
	$user_id = 'user_id'; // si elle est vide la renommée user_id
}

// si la variable POST username n'est pas vide
if (!empty($_POST['username'])) 
{
	$username =  isset($_POST['username']) ? "%" . strval($_POST['username']) . "%" : 'username' ;  // recupère la variable username avec des % autour 
	$username = "'" . $username . "'";
}
else {
	$username = 'username'; // si elle est vide la renommée username
}

// site
if (!empty($_POST['site']))
{
	$site = isset($_POST['site']) ? strval($_POST['site']) : 'site'; // On recupère la valeur
	$site = "'" . $site . "'";
}
else {
	$site = 'site'; // si c'est vide var = var
}

// permission
if (!empty($_POST['permission']))
{
	$permission = isset($_POST['permission']) ? strval($_POST['permission']) : 'permission'; // On recupère la valeur
	$permission = "'" . $permission . "'";
}
else {
	$permission = 'permission'; // si c'est vide var = var
}

// préférence
if (!empty($_POST['tableau_setting']))
{
	$tableau_setting = isset($_POST['tableau_setting']) ? strval($_POST['tableau_setting']) : 'tableau_setting'; // On recupère la valeur
	$tableau_setting = "'" . $tableau_setting . "'";
}
else {
	$tableau_setting = 'tableau_setting'; // si c'est vide var = var
}

// De cette façons si la variable est vide ce sera variable = variable sinon variable sera égale à %variable% (les % veulent dire qui comprend, par exemple toutes variable qui contienne "var"  )

	$result = array();
					// raccourcis du WHERE
					$where = " user_id like ". $user_id ." and username like ". $username ." and site like ". $site ." and permission like ". $permission ." and tableau_setting like ". $tableau_setting .""; 

					$rs = $conn->query("select count(*) from tbl_user where" . $where); // On compte le nombre de tbl_user
					$row = $rs->fetch(PDO::FETCH_NUM);
					
					
					$rs = $conn->query("select * from tbl_user where" . $where); // on selectionne les tbl_users
					
					$items = array(); // on met tous dans un tableau
					while($row = $rs->fetch()){  // que l'on parcours
						array_push($items, $row); 
					}
					$result["rows"] = $items; // on recupère les données
				
					echo json_encode($result); // puis on les écris sous format json, de l'autre coter mon datagrid pourra les lire et assimiler.

}
else {
  //header("location: ../../connexion.php");
}


?>



