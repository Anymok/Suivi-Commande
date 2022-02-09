<?php
// Ouvre la session user
session_start();
// le redirge vers connexion
header("location:../connexion.php");
// Supprime sa session
session_destroy();

?>