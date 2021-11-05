<?php 
//session_start(); 
//$_SESSION['adeheader']=array();
require_once('../../core/functions.php');


if(isset( $_POST['mail']) && isset( $_POST['pwd'])){
	
	$e=loginUser($_POST['mail'], $_POST['pwd']);
	//echo '-'.$e;
	if ($e==1) {
		echo 'ok';
	}else{
		echo $e;
	}
}elseif(isset( $_POST['mailLogout'])){ /* Déconnexion */
//	logInConsole('adeLogout');
	echo 'Logout';
	logoutUser();
	echo '<meta http-equiv="refresh" content="0;URL=/connexion.php">';
}else{
	echo 'post:<br/>';
	print_r($_POST);
	echo '<br/>get:<br/>';
	print_r($_GET);
}
