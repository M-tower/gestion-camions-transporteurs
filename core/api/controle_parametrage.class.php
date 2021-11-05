<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class controle_parametrage {
 private $_db;
 
 public function __construct($db) {
  $this->setDb($db);
 }
 public function setDb(connect $db){
  $this->_db = $db->connexion();
 }
 public function config_rapide_status(){
  /*
   * Retourne un nombre sur 100 correspondant au taux de configuration
   */
  $conf_val = 25;
  $query = "SELECT count(*) as numbre "
          . "from securedata "
          . "where key = 'crm_infos_entreprise__nomEntreprise'";
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $line = pg_fetch_array($retour, null, PGSQL_ASSOC);
  if($line['numbre'] > 0){
   $conf_val += 25;
  }
  $query = "SELECT count(*) as numbre "
          . "from tva; ";
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $line = pg_fetch_array($retour, null, PGSQL_ASSOC);
  if($line['numbre'] > 0){
   $conf_val += 25;
  }
  $query = "SELECT count(*) as numbre "
          . "from articles; ";
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $line = pg_fetch_array($retour, null, PGSQL_ASSOC);
  if($line['numbre'] > 0){
   $conf_val += 25;
  }
  return $conf_val;
 }
 
 public function do_parametrage(){
  /*
   * Retourne 1 si le parametrage est fait, 0 si non
   */
  $query = "SELECT count(*) as numbre "
          . "from securedata "
          . "where key = 'crm_do_parametrage'";
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $line = pg_fetch_array($retour, null, PGSQL_ASSOC);
  if($line['numbre'] > 0){
   return 1;
  }else{
   return 0;
  }
 }
 
 public function parametrage_ok(){
  /*
   * marque ok comme value pour crm_do_parametrage.
   * se déclanche qquand l'user sera redirigé vers le formulaire de paramtrage rapide
   * retourne 1 si tout se passe bien et une chaine si non
   */
  $is_first = $this->do_parametrage();
  $condition = "where key = 'crm_do_parametrage'";
  if($is_first == 0){
   $condition = "";
  }
  $query = "INSERT INTO securedata(key, value) "
          . "values('crm_do_parametrage', 'ok') "
          . $condition;
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $result = pg_result_error($retour);
  if($result != ''){
   return $result;
  }else{
   return 1;
  }
 }
}
