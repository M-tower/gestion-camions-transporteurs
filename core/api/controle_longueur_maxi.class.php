<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class controle_longueur_maxi {
 private $_db;
 
 public function __construct($db) {
  $this->setDb($db);
 }
 public function setDb(connect $db){
  $this->_db = $db->connexion();
 }
 public function getLimitChamps($table){
  /*
   * Retourne un tableau des colonnes avec leurs caractères maximal
   */
  $query = "SELECT column_name as colonne,character_maximum_length as taille "
          . "from INFORMATION_SCHEMA.COLUMNS "
          . "where table_name = '".$table."'";
  $retour = $this->_db->prepare($query);
  $retour->execute();
  $result = array();
  $line = $retour->fetchAll(\PDO::FETCH_ASSOC);
  for($i=0; $i<sizeof($line); $i++){
   $result[$line[$i]['colonne']] = $line[$i]['taille'];
  }
  return $result;
 }
 public function setLimitColonne($table, $col, $lng){
  /*
   * Redéfini la taille maximals sur $lng de $col dans $table
   */
  $query = "update pg_attribute set atttypmod = " . $lng . "+4"
          ."where attrelid = '".$table."'::regclass "
          . "and attname = '".$col."';";
  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
  $result = array();
  while($line = pg_fetch_array($retour, null, PGSQL_ASSOC)){
   $result[$line['colonne']] = $line['taille'];
  }
  return $result;
 }
}
