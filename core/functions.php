<?php

/* 
 * 
 */
include_once('global-data.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/modules/mailer/functions.php';
include_once('classe/class.phpmailer.php');
include_once('classe/PHPMailerAutoload.php');
include_once 'api/connect.class.php';
include_once 'api/generator.class.php';
include_once 'api/generale_fonction.class.php';
include_once 'api/controle_longueur_maxi.class.php';
include_once 'api/utilisateurs.class.php';
include_once 'api/transporteurs.class.php';
include_once 'api/camions.class.php';
include_once 'api/clients.class.php';
include_once 'api/cycles.class.php';
include_once 'api/jours.class.php';
include_once 'api/servire.class.php';

//CONNEXION
function connecteur(){
  $connect = new connect();
  return $connect;
}

//echo connecteur()->connexion();

//EN GENERAL 
function generateClass($array){ /*generer les contenu des class php */
  $generator = new generateur();
  return $generator->hydrate($array);
}

//HISTORIQUE ACTIONS 
function historisation($array){ 
  $file = '../historiques/hist_'.$_SESSION['user_mail'].'.txt';
  if(!file_exists($file)){
    $json_array = array(
              array(
                date("d-m-y H:i:s") => $array['action']
              )
          );
    file_put_contents($file, json_encode($json_array));
  }else{
    $cont = json_decode(file_get_contents($file), true);
    $json_array = array(
                    date("d-m-y H:i:s") => $array['action']
                  );
    array_push($cont,$json_array);
    file_put_contents($file, json_encode($cont));
  }
}
function getHistorique($mail_user){
  $file = '../historiques/hist_'.$mail_user.'.txt';
  if(file_exists($file)){
    return file_get_contents($file);
  }else{
    return '';
  }
}

//UTILISATEURS
function checkForLogin($mail, $pwd){
  /*
  * Retourne l'objet utilisateur si ok et 0 si non
  * Aide à la connexion des utilisateurs
  */
  $utilisateur = new utilisateurManager(connecteur());
  return $utilisateur->checkForLogin($mail, $pwd);
}
function getAllUsers(){
  $utilisateur = new utilisateurManager(connecteur());
  return $utilisateur->getAll();
}

//LOGIN
function loginUser($mail = null, $pwd = null) {
    $nolog = $mail != null && $pwd != null;
    if (!$mail)
        $mail = $_REQUEST['mail'];
    // echo $mail;
    if (!$pwd)
        $pwd = $_REQUEST['pwd'];
    $u = checkForLogin($mail, $pwd);
    if(!is_int($u) && $u->ID_UTIL() !== 0 && $u->ID_UTIL() > 0) {

        $_SESSION['user'] = $u;
        $_SESSION['header'] = array("Authorization" => "Basic ");
        //var_dump($u);
        $_SESSION['user_pseudo'] = $u->PSEUDO_UTIL();
        $_SESSION['user_mail'] = $u->MAIL_UTIL();
        $_SESSION['user_nom'] = $u->NOM_UTIL();
        $_SESSION['user_prenom'] = $u->PRENOM_UTIL();
        $_SESSION['user_type'] = $u->TYPE_UTIL();

        $_SESSION['id_user'] = $u->ID_UTIL();
        $_SESSION['actif'] = true;

        return 1;
    }
    return $u;
    //echo $param;
}

//LOGOUT
function logoutUser(){
  
  unset($_SESSION['user']);
  unset($_SESSION['header']);
  $_SESSION = array();
  session_destroy();
}

// GENERALE FONCTIONS
function getIfIdExist($idDesig, $idVal, $tableName){
 /* @Sammy
  * Retoune 1 si l'id de valeur $idVal est déjà présent dans la table $tableName
  * et 0 si non.
  * $idDesig = la désgnation de l'id dans la table (ex: Id, Ref, etc...)
  * $idVal = la valeur de l'id
  * $tableName = le nom de la table
  */
 $req = new generale_function(connecteur());
 return $req->ifIdExist($idDesig, $idVal, $tableName);
}
function getIfElementExist($colName, $val, $tableName){
 /* @Sammy
  * Retoune 1 si la colonne $colName contient $val dans la table $tableName
  * et 0 si non.
  */
 $req = new generale_function(connecteur());
 return $req->ifElementExist($colName, $val, $tableName);
}
function getIfElementsCombiExist($array, $tableName){
 /* @Sammy
  * Fait la même chose que getIfIdExist mais avec plusieur valeurs à vérifier
  */
 $req = new generale_function(connecteur());
 return $req->ifElementsCombiExist($array, $tableName);
}

//CONTROLE_LONGUEUR_MAXI
function getLimitChamps($table){
 /*
  * Retourne un tableau des colonnes avec leurs caractères maximal
  */
 $lim = new controle_longueur_maxi(connecteur());
 return $lim->getLimitChamps($table);
}
function setLimitColonne($table, $col, $lng, $ndb){
 /*
  * Redéfini la taille maximals sur $lng de $col dans $table
  */
 $lim = new controle_longueur_maxi(connecteurPrincipal($ndb));
 return $lim->setLimitColonne($table, $col, $lng);
}
function controleLimitChamp($array, $table){
 /* @Sammy
  * Fait un controle général sur chaque colonne présent dans $array
  * et retourn un string récapitulatif si infraction si non 
  * elle retourne string vide;
  */
 $limites = getLimitChamps($table);
// logInConsole('json='.getLimitChamps($table));
 $rapport = '';
 foreach($array as $key => $value){
  if($limites[$key] !== null && strlen($value) > $limites[$key]){
   $rapport .= $key . ' doit être limité à ' . $limites[$key] . ' caractères; ';
  }
 }
 return $rapport;
}

//TRANSPORTEURS
function editTransporteur() {
  
 $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
    $jsonArray = array();
    $jsonArray['ID_TRANSP'] = $donnees['id_transp'];
    $jsonArray['DIRIGEANT_TRANSP'] = $donnees['dirigeant_transp'];
    $jsonArray['MAISON_TRANSP'] = $donnees['maison_transp'];
    $jsonArray['ADRESSE_TRANSP'] = $donnees['adresse_transp'];
    $jsonArray['MAIL_TRANSP'] = $donnees['mail_transp'];
    $jsonArray['LAT_TRANSP'] = $donnees['lat_transp'];
    $jsonArray['LNG_TRANSP'] = $donnees['lng_transp'];
    $jsonArray['CONTACTS_TRANSP'] = $donnees['contacts_transp'];
    
    $control = controleLimitChamp($jsonArray, 'transporteurs');
    
    if($control != ''){
     return $control;
    }
    
    $is_exist = getIfElementExist('MAISON_TRANSP', $jsonArray['MAISON_TRANSP'], 'transporteurs');
    if($is_exist != 0){
      if($donnees['id_transp'] != -1){
        $conditions = array(
            'ID_TRANSP' => $donnees['id_transp'],
            'MAISON_TRANSP' => $donnees['maison_transp']
        );
        $ctl = getIfElementsCombiExist($conditions, 'transporteurs');
        if($ctl != 1){
          return 'Erreur doublon';
        }
      }else{
        return 'Erreur doublon';
      }
    }
    $transp = new transporteurs();
    $transp->hydrate($jsonArray);
    $req = new transporteursManager(connecteur());
    $ret = ($donnees['id_transp'] != -1)? $req->update($transp) : $req->add($transp);
    if (is_array($ret)) {
        return 'non ';
//        return json_encode($ret);
    } else {
        return 'oui';
    }
}

function getTransporteurById($id){
  $req = new transporteursManager(connecteur());
  return $req->get($id);
}

function getAllTransporteurs(){
  $req = new transporteursManager(connecteur());
  return $req->getAll();
}
function getAllTransporteursLimite($a){
  $req = new transporteursManager(connecteur());
  return $req->getAllLimite($a);
}

function deleteTransporteur(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $id = $donnees['id_transp'];
  $req = new transporteursManager(connecteur());
  return $req->delete($id);
}
function deleteGroupTransporteur(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $ids = explode(',', $donnees['ids']);
  $ret = '';
  $count = 0;
  for($i=0; $i< sizeof($ids);$i++){
    $req = new transporteursManager(connecteur());
    $r = $req->delete($ids[$i]);
    if($r != ''){
      echo $count.' élément(s) seulement supprimé(s). L\'opération n\'a pas pu aboutir!';
      return;
    }
    $ret .= $r;
    $count++;
  }
  return $ret;
}

//CLIENTS
function editClient() {
  
 $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
    $jsonArray = array();
    $jsonArray['ID_CLIENT'] = $donnees['id_client'];
    $jsonArray['RAISON_SOC_CLIENT'] = $donnees['raison_soc_client'];
    $jsonArray['ADRESSE_CLIENT'] = $donnees['adresse_client'];
    $jsonArray['CONTACTS_CLIENT'] = $donnees['contacts_client'];
    $jsonArray['PAYS_CLIENT'] = $donnees['pays_client'];
    
    $control = controleLimitChamp($jsonArray, 'clients');
    
    if($control != ''){
     return $control;
    }
    
    $is_exist = getIfElementExist('RAISON_SOC_CLIENT', $jsonArray['RAISON_SOC_CLIENT'], 'clients');
    if($is_exist != 0){
      if($donnees['id_client'] != -1){
        $conditions = array(
            'ID_CLIENT' => $donnees['id_client'],
            'RAISON_SOC_CLIENT' => $donnees['raison_soc_client']
        );
        $ctl = getIfElementsCombiExist($conditions, 'clients');
        if($ctl != 1){
          return 'Erreur doublon';
        }
      }else{
        return 'Erreur doublon';
      }
    }
    $client = new clients();
    $client->hydrate($jsonArray);
    $req = new clientsManager(connecteur());
    $ret = ($donnees['id_client'] != -1)? $req->update($client) : $req->add($client);
    if (is_array($ret)) {
        return 'non';
//        return json_encode($ret);
    } else {
        return 'oui';
    }
}

function getClientById($id){
  $req = new clientsManager(connecteur());
  return $req->get($id);
}

function getAllClients(){
  $req = new clientsManager(connecteur());
  return $req->getAll();
}
function getAllClientsLimite($a){
  $req = new clientsManager(connecteur());
  return $req->getAllLimite($a);
}

function deleteClient(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $id = $donnees['id_client'];
  $req = new clientsManager(connecteur());
  return $req->delete($id);
}
function deleteGroupClient(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $ids = explode(',', $donnees['ids']);
  $ret = '';
  $count = 0;
  for($i=0; $i< sizeof($ids);$i++){
    $req = new clientsManager(connecteur());
    $r = $req->delete($ids[$i]);
    if($r != ''){
      echo $count.' élément(s) seulement supprimé(s). L\'opération n\'a pas pu aboutir!';
      return;
    }
    $ret .= $r;
    $count++;
  }
  return $ret;
}
//AUTRES
function askChangeMDP($mail){
 /*
  * demande pour arriver au changement de mot de passe
  */
// logInConsole($mail .' +++ '.$ndb);
 $utilisateur = new utilisateurManager(connecteur()); /* ici la requête est faite pour avoir l'ancien mot de passe */
 $u = $utilisateur->getByMail($mail);
 if($u->ID_UTIL() == ''){ /* controle pour vérifier si l'user existe */
  return 'non';
 }
 $to = $u->MAIL_UTIL();
 $subject = 'Changement de mot de passe';
 $message = 'Hello '.$u->PRENOM_UTIL().', '
         . '<br>Vous recevez ce mail suite à votre demande de changement de mot de passe. '
   . '<br>Cliquez sur le lien suivant : '
         . '<br>' .$_SERVER['DOCUMENT_ROOT']. 'changer-mdp.php?mail='.$u->MAIL_UTIL().'&oldpass=' .$u->PASS_UTIL() .'<br> '
   . ' pour procéder au changement.';
  $exp = array(
      'nom' => 'SY.N.TRA.C.T. - Transport',
      'adresse' => 'Lomé',
      'tel' => '',
      'mail' => 'contact@syntract-transport.com'
  );
  $recep = array(
      'a' => $to,
      'cc' => '',
      'bcc' => ''
  );
//  logInConsole($to.',sammy.altech@gmail.com');
  $envoi = mailSender($exp, $recep, $subject, $message, false);
 if ($envoi === "ok"){
  return "Un mail contenant un lien de changement de mot de passe vient de vous être envoyé. <br>"
   . "Veuillez consulter vos mails SVP.";
 }else{
  return "Aie!! Un problème rencontré : ".$envoi;
 }
}

function changeMDP($pwd, $mail){
 /*
  * change directement le mot de passe
  */
 $utilisateur = new utilisateurManager(connecteur());
 if($utilisateur->changeMDP($pwd, $mail) == 0){
  return 'non';
 }else{
  $to = $mail;
  $subject = 'Nouveau mot de passe pour la gestion des transport SY.N.TRA.C.T. - Transport';
  $message = 'Hello , '
          . '<br>Ce mail vous est envoyé pour vous notifier que votre mot de passe a bien été changé. '
    . '<br>Si vous n\'être pas à l\'origine de cette action, merci de bien vouloir informer l\'administrateur des comptes ou notre service technique '
    . 'sur le +228 90046098';
  $exp = array(
      'nom' => 'L\'équipe technique SY.N.TRA.C.T. - Transport',
      'adresse' => 'Lomé',
      'tel' => '',
      'mail' => 'support@altechsoft.fr'
  );
  $recep = array(
      'a' => $to,
      'cc' => '',
      'bcc' => ''
  );
//  logInConsole($to.',sammy.altech@gmail.com');
  $envoi = mailSender($exp, $recep, $subject, $message, false);
//  $envoi = mail($to, $subject, $message, $headers);
  return 'ok';
 }
}

function logInConsole($s) {
    $s = str_replace('\n', '', $s);
    $s = addslashes($s);
    echo "<script>console.log('$s');</script>";
}

//CAMIONS
function camionIsExist(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $is_exist = getIfElementExist('IMMA_CAMION', $donnees['ref'], 'camions');
  return $is_exist;
}
function editCamion(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $jsonArray = array();
  $jsonArray['IMMA_CAMION'] = $donnees['imma_camion'];
  $jsonArray['ID_TRANSP'] = $donnees['id_transp'];
  $jsonArray['CAPACITE'] = $donnees['capacite'];
  $camion = new camions();
  $camion->hydrate($jsonArray);
  $req = new camionsManager(connecteur());
  $is_exist = getIfElementExist('IMMA_CAMION', $donnees['imma_camion'], 'camions');
  if($is_exist == 1){
    return $req->update($camion);
  }
  return $req->add($camion);
}
function getAllCamionsById_transp(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $req = new camionsManager(connecteur());
  return $req->getAllById_transp($donnees['id_transp']);
}
function getAllCamions(){
  $req = new camionsManager(connecteur());
  return $req->getAll();
}
function getAllCamionsOpe(){
  $req = new camionsManager(connecteur());
  return $req->getAllOpe();
}
function getCamionByImma_camion(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $req = new camionsManager(connecteur());
  return $req->get($donnees['imma_camion']);
}
function deleteCamion(){
  $donnees = nettoyeur(); /* IMPORTANT pour le traitement des données */
  $req = new camionsManager(connecteur());
  return $req->delete($donnees['imma_camion']);
}
function getRankTransp(){
  $req = new camionsManager(connecteur());
  return $req->getRankTransp();
}
function getAllCamionsTransp(){
  $req = new camionsManager(connecteur());
  return $req->getAllByTransp();
}

//TABLEAU
function remplirParDefaut($jr_ajoute){
  /*
   * se charge de remplir le tableau dans l'ordre fourni au contenu
   * transmis dans $camions puis réorganise les données en jours.
   */
  $camions = getAllCamionsTransp();
  $nb_jours = getRankTransp()[0]['NBR'] + $jr_ajoute;
  $all_camions = sizeof(getAllCamions());
//  logInConsole('jours = '.$nb_jours);
  $lignes = ceil($all_camions / $nb_jours);
//  logInConsole('lignes = '.$lignes);
  $jour = array();
  $c = 0;
  $l = 1;
  while($l < ($lignes+1)){
    for($i=1; $i<($nb_jours+1); $i++){
      if(isset($camions[$c])){
        $jour[$i][$l] = $camions[$c];
      }
      $c++; 
    }
    $l++;
  }
  return $jour;
}

function remplir($id_cycle, $jr_ajoute){
  /*
   * se charge de remplir le tableau dans l'ordre fourni au contenu
   * transmis dans $camions puis réorganise les données en jours.
   * 
   * n'est appelé qu'en cas d'existance du cycle en question!!!
   */
  $camions = getAllByCycleForTableau($id_cycle);
//  $nb_jours = getRankTransp()[0]['NBR'] + $jr_ajoute;
  $nb_jours = sizeof(getJoursByCycle($id_cycle)) + $jr_ajoute;
  $all_camions = sizeof(getAllCamions());
//  logInConsole('jours = '.$nb_jours);
  $lignes = ceil($all_camions / $nb_jours);
//  logInConsole('lignes = '.$lignes);
  $jour = array();
  $c = 0;
  $l = 1;
  while($l < ($lignes+1)){
    for($i=1; $i<($nb_jours+1); $i++){
      if(isset($camions[$c])){
        $jour[$i][$l] = $camions[$c];
      }
      $c++; 
    }
    $l++;
  }
  return $jour;
}
function remplirAccueil(){
  /*
   * se charge de remplir le tableau dans l'ordre fourni au contenu
   * transmis dans $camions puis réorganise les données en jours.
   */
  $id_cycle = (is_array(getActifCycle()) && sizeof(getActifCycle())>0)? getActifCycle()['ID_CYCLE'] : -1;
  if($id_cycle == -1){
    return remplirParDefaut(0);
  }
  $camions = getAllByCycleForTableau($id_cycle);
  $nb_jours = sizeof(getJoursByCycle($id_cycle));
  $all_camions = sizeof(getAllCamions());
  $lignes = ceil($all_camions / $nb_jours);
  $jour = array();
  $c = 0;
  $l = 1;
  while($l < ($lignes+1)){
    for($i=1; $i<($nb_jours+1); $i++){
      if(isset($camions[$c])){
        $jour[$i][$l] = $camions[$c];
      }
      $c++; 
    }
    $l++;
  }
  return $jour;
}

//CYCLES
function addCycle($array){
  $cycle = new cycles();
  $cycle->hydrate($array);
  $req = new cyclesManager(connecteur());
  return $req->add($cycle);
}
function disableCycle($id_cycle){
  $req = new cyclesManager(connecteur());
  return $req->disable($id_cycle);
}
function getActifCycle(){
  $req = new cyclesManager(connecteur());
  return $req->getActif();
}
function checkIfIsActiveCycle($id_cycle){
  $req = new cyclesManager(connecteur());
  return $req->checkIfIsActive($id_cycle);
}
function getAllInactifCycles(){
  $req = new cyclesManager(connecteur());
  return $req->getAllInactif();
}
function getLastIdCycle(){
  $req = new cyclesManager(connecteur());
  return $req->getLastId();
}
function deleteCycle($id_cycle){
  $req = new cyclesManager(connecteur());
  return $req->delete($id_cycle);
}
function desactiveCycle($id_cycle){
  $cycle = new cycles();
  $cycle->setID_CYCLE($id_cycle);
  $cycle->setACTIF_CYCLE(0);
  $req = new cyclesManager(connecteur());
  return $req->update($cycle);
}

//JOURS
function addJour($array){
  $jour = new jours();
  $jour->hydrate($array);
  $req = new joursManager(connecteur());
  return $req->add($jour);
}
function disableJour($num_jour){
  $req = new joursManager(connecteur());
  return $req->disable($num_jour);
}
function deleteJour($num_jour){
  $req = new joursManager(connecteur());
  return $req->delete($num_jour);
}
function getJoursByCycle($id_cycle){
  $req = new joursManager(connecteur());
  return $req->getAllByCycle($id_cycle);
}
function getActifsJoursByCycle($id_cycle){
  $req = new joursManager(connecteur());
  return $req->getActifByCycle($id_cycle);
}
function deleteJoursByCycle($id_cycle){
  $req = new joursManager(connecteur());
  return $req->deleteAllByCycle($id_cycle);
}

//SERVIRE
function addServire($array){
  $servire = new servire();
  $servire->hydrate($array);
  $req = new servireManager(connecteur());
  return $req->add($servire);
}
function deleteAllServiresByCycle($id_cycle){
  $req = new servireManager(connecteur());
  return $req->deleteAllByCycle($id_cycle);
}
function getAllServiresByCycleJour($id_cycle, $num_jour){
  $req = new servireManager(connecteur());
  return $req->getAllByCycleJour($id_cycle, $num_jour);
}
function getAllByCycleForTableau($id_cycle){
  $req = new servireManager(connecteur());
  return $req->getAllByCycleForTableau($id_cycle);
}