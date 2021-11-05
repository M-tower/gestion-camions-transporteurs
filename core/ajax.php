<?php

session_start();

require_once('functions.php');
require_once('fonctions-traitement.php');

/*
 * INDICATIONS :
 * Toute valeur que doit prendre le variable $action doit être déclaré dans le
 * tableau $ajaxAction[] qui se trouve dans le fichier global-data.php
 */

if (!isset($_POST) || !isset($_POST['action'])) {
  echo 'aucun retour pout ce poste !';
  die();
}


$action = filter_input(INPUT_POST, 'action');
$donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */

switch ($action) {
  case $ajaxAction[0]:
    $mail = $_POST['mail'];
    echo askChangeMDP($mail);
    break;
  case $ajaxAction[1] :
    $mail = $_POST['mail'];
    $pwd = $_POST['pwd'];
    echo changeMDP($pwd, $mail);
    break;
  case $ajaxAction[2] :
    echo editTransporteur();
    $array = array(
        "action" => "Edition d'un transporteur"
    );
    historisation($array);
    break;
  case $ajaxAction[3] :
    echo json_encode(getAllTransporteurs());
    break;
  case $ajaxAction[4] :
    echo deleteTransporteur();
    $array = array(
        "action" => "Suppression d'un transporteur"
    );
    historisation($array);
    break;
  case $ajaxAction[5] :
    echo deleteGroupTransporteur();
    $array = array(
        "action" => "Suppression groupée de transporteur(s)"
    );
    historisation($array);
    break;
  case $ajaxAction[6] :
    echo camionIsExist();
    break;
  case $ajaxAction[7] :
    echo editCamion();
    $array = array(
        "action" => "Edition d'un camion"
    );
    historisation($array);
    break;
  case $ajaxAction[8] :
    echo json_encode(getAllCamionsById_transp());
    break;
  case $ajaxAction[9] :
    echo json_encode(getCamionByImma_camion());
    break;
  case $ajaxAction[10] :
    echo deleteCamion();
    $array = array(
        "action" => "Suppression d'un camion"
    );
    historisation($array);
    break;
  case $ajaxAction[11] :
    echo json_encode(getAllTransporteursLimite($donnees['limite']));
    break;
  case $ajaxAction[12] :
    echo editClient();
    $array = array(
        "action" => "Edition d'un client"
    );
    historisation($array);
    break;
  case $ajaxAction[13] :
    echo json_encode(getAllClients());
    break;
  case $ajaxAction[14] :
    echo deleteClient();
    $array = array(
        "action" => "Suppression d'un client"
    );
    historisation($array);
    break;
  case $ajaxAction[15] :
    echo deleteGroupClient();
    $array = array(
        "action" => "Suppression groupée de client(s)"
    );
    historisation($array);
    break;
  case $ajaxAction[16] :
    echo json_encode(getAllClientsLimite($donnees['limite']));
    break;
  case $ajaxAction[17] :
    echo json_encode(getRankTransp());
    break;
  case $ajaxAction[18] :
    echo json_encode(getAllCamionsTransp());
    break;
  case $ajaxAction[19] :
    echo json_encode(remplirParDefaut($donnees['jr_ajoute']));
    break;
  case $ajaxAction[20] :
    $jsonArray = array();
    $jsonArray['IMMA_CAMION'] = $donnees['imma_camion'];
    $jsonArray['ID_CLIENT'] = $donnees['id_client'];
    $jsonArray['NUM_JOUR'] = $donnees['num_jour'];
    $jsonArray['ID_CYCLE'] = $donnees['id_cycle'];
    $jsonArray['ETAT_SERV'] = $donnees['etat_serv'];
    $jsonArray['COMMENTAIRE_SERV'] = $donnees['commentaire_serv'];
    $jsonArray['LIGNE_SERV'] = $donnees['ligne_serv'];
    $jsonArray['MAISON_TRANSP'] = $donnees['maison_transp'];
    $jsonArray['CONTACTS_TRANSP'] = $donnees['contacts_transp'];
    $jsonArray['RAISON_SOC_CLIENT'] = getClientById($donnees['id_client'])->RAISON_SOC_CLIENT();
    $req = addServire($jsonArray);
    echo (is_array($req))? json_encode($req) : '';
    break;
  case $ajaxAction[21] :
    $n_jour = $donnees['nb_jour'];
    $jour_actif = $donnees['jour_actif'];
    $new_cycle = array(
        "ACTIF_CYCLE" => 1
    );
    $id_cycle = addCycle($new_cycle);
    $back = '';
    for($i=0; $i<$n_jour; $i++){
      $is_actif = (($i+1)< $jour_actif)? 0 : 1;
      $le_jour = array(
        "NUM_JOUR" => $i+1,
        "ID_CYCLE" => $id_cycle,
        "ACTIF_JOUR" => $is_actif
      );
      $back .= addJour($le_jour);
    }
    echo ($back == '')? $id_cycle : $back;
    $array = array(
        "action" => "Enregistrement d'un nouveau cycle : N.".$id_cycle
    );
    historisation($array);
    break;
  case $ajaxAction[22] :
    echo deleteAllServiresByCycle($donnees['id_cycle']);
    break;
  case $ajaxAction[23] :
    echo json_encode(remplir($donnees['id_cycle'], $donnees['jr_ajoute']));
    break;
  case $ajaxAction[24] :
    echo json_encode(remplirAccueil());
    break;
  case $ajaxAction[25] :
    $n_jour = $donnees['nb_jour'];
    $jour_actif = $donnees['jour_actif'];
    $id_cycle = $donnees['id_cycle'];
    $is_ok = is_array(checkIfIsActiveCycle($id_cycle));
    if(!$is_ok){
      echo 'erreur';
    }
    $back = deleteJoursByCycle($id_cycle);
    if($back == 1){
      $back = '';
      for($i=0; $i<$n_jour; $i++){
        $is_actif = (($i+1)< $jour_actif)? 0 : 1;
        $le_jour = array(
          "NUM_JOUR" => $i+1,
          "ID_CYCLE" => $id_cycle,
          "ACTIF_JOUR" => $is_actif
        );
        $back .= addJour($le_jour);
      }
      echo ($back == '')? $id_cycle : $back;
      $array = array(
          "action" => "Mise a jour du cycle : N.".$id_cycle
      );
      historisation($array);
    }else{
      echo 'erreur';
    }
    break;
  case $ajaxAction[26] :
    echo desactiveCycle($donnees['id_cycle']);
    $array = array(
        "action" => "Passage au cycle suivant"
    );
    historisation($array);
    break;
  case $ajaxAction[27] :
    echo getHistorique($donnees['mail_user']);
    break;
  case $ajaxAction[28] :
//    logInConsole($_POST['coll']);
    $coll = json_decode($_POST['coll']);
    $req = '';
    foreach($coll as $c){
      $jsonArray = array();
      $jsonArray['IMMA_CAMION'] = $c->imma_camion;
      $jsonArray['ID_CLIENT'] = $c->id_client;
      $jsonArray['NUM_JOUR'] = $c->num_jour;
      $jsonArray['ID_CYCLE'] = $c->id_cycle;
      $jsonArray['ETAT_SERV'] = $c->etat_serv;
      $jsonArray['COMMENTAIRE_SERV'] = $c->commentaire_serv;
      $jsonArray['LIGNE_SERV'] = $c->ligne_serv;
      $jsonArray['MAISON_TRANSP'] = $c->maison_transp;
      $jsonArray['CONTACTS_TRANSP'] = $c->contacts_transp;
      $jsonArray['RAISON_SOC_CLIENT'] = getClientById($c->id_client)->RAISON_SOC_CLIENT();
      $req .= addServire($jsonArray);
      
    }
    echo (is_array($req))? json_encode($req) : '';
    break;
  case $ajaxAction[29] :
    echo json_encode(getAllCamions());
    break;
  default:
    echo "undefined action '$action' for this post !";

}
die();
