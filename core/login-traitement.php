<?php 
session_start(); 
require_once('functions.php');

// Contrôle sur le login de l'utilisateur
if(isset( $_POST['mail']) && isset( $_POST['pwd'])){
	$e = loginUser($_POST['mail'], $_POST['pwd']);
	//echo '-'.$e;
	if ($e==1) {
		echo 'ok';
	}else{
		echo $e;
	}
}elseif(isset( $_POST['mailLogout'])){ /* Déconnexion */
//	logInConsole('logout');
	echo 'logout';
	logoutUser();
}else{
	echo 'post:<br/>';
	print_r($_POST);
	echo '<br/>get:<br/>';
	print_r($_GET);
}
