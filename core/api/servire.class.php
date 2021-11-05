<?php

class servire {
  private $_IMMA_CAMION;
  private $_ID_CLIENT;
  private $_NUM_JOUR;
  private $_ID_CYCLE;
  private $_ETAT_SERV;
  private $_COMMENTAIRE_SERV;
  private $_LIGNE_SERV;
  private $_MAISON_TRANSP;
  private $_CONTACTS_TRANSP;
  private $_RAISON_SOC_CLIENT;

  //getter
  public function IMMA_CAMION(){
  return $this->_IMMA_CAMION;
  }
  public function ID_CLIENT(){
  return $this->_ID_CLIENT;
  }
  public function NUM_JOUR(){
  return $this->_NUM_JOUR;
  }
  public function ID_CYCLE(){
  return $this->_ID_CYCLE;
  }
  public function ETAT_SERV(){
  return $this->_ETAT_SERV;
  }
  public function COMMENTAIRE_SERV(){
  return $this->_COMMENTAIRE_SERV;
  }
  public function LIGNE_SERV(){
  return $this->_LIGNE_SERV;
  }
  public function MAISON_TRANSP(){
  return $this->_MAISON_TRANSP;
  }
  public function CONTACTS_TRANSP(){
  return $this->_CONTACTS_TRANSP;
  }
  public function RAISON_SOC_CLIENT(){
  return $this->_RAISON_SOC_CLIENT;
  }

  //hydratation
  public function hydrate(array $d){
  foreach ($d as $key => $value){
  $methode = 'set'.ucfirst($key);
  if(method_exists($this, $methode)){
  $this->$methode($value);
  }
  }
  }

  //setter
  public function setIMMA_CAMION($elt){
  $this->_IMMA_CAMION = $elt;
  }
  public function setID_CLIENT($elt){
  $this->_ID_CLIENT = $elt;
  }
  public function setNUM_JOUR($elt){
  $this->_NUM_JOUR = $elt;
  }
  public function setID_CYCLE($elt){
  $this->_ID_CYCLE = $elt;
  }
  public function setETAT_SERV($elt){
  $this->_ETAT_SERV = $elt;
  }
  public function setCOMMENTAIRE_SERV($elt){
  $this->_COMMENTAIRE_SERV = $elt;
  }
  public function setLIGNE_SERV($elt){
  $this->_LIGNE_SERV = $elt;
  }
  public function setMAISON_TRANSP($elt){
  $this->_MAISON_TRANSP = $elt;
  }
  public function setCONTACTS_TRANSP($elt){
  $this->_CONTACTS_TRANSP = $elt;
  }
  public function setRAISON_SOC_CLIENT($elt){
  $this->_RAISON_SOC_CLIENT = $elt;
  }
}

class servireManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }
  
  public function add(servire $servire){
    $query = "INSERT INTO servire (IMMA_CAMION, ID_CLIENT, NUM_JOUR, ID_CYCLE, ETAT_SERV, COMMENTAIRE_SERV, LIGNE_SERV, "
            . "MAISON_TRANSP, CONTACTS_TRANSP, RAISON_SOC_CLIENT) "
            . "VALUES ("
            . "'" . addslashes($servire->IMMA_CAMION()) . "',"
            . $servire->ID_CLIENT() . ","
            . $servire->NUM_JOUR() . ","
            . $servire->ID_CYCLE() . ","
            . "'" . addslashes($servire->ETAT_SERV()) . "',"
            . "'" . addslashes($servire->COMMENTAIRE_SERV()) . "',"
            . $servire->LIGNE_SERV() . ","
            . "'" . addslashes($servire->MAISON_TRANSP()) . "',"
            . "'" . addslashes($servire->CONTACTS_TRANSP()) . "',"
            . "'" . addslashes($servire->RAISON_SOC_CLIENT()) . "'"
            . ");";
    $etat_camion = (addslashes($servire->ETAT_SERV()) == 'Opérationnel')? 1 : 0;
    $query .= "UPDATE camions "
            . "SET "
            . "ETAT_CAMION = " . $etat_camion . " "
            . "WHERE IMMA_CAMION = '".addslashes($servire->IMMA_CAMION())."';";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return '';
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  public function update(jours $jour){
    
  }
  
  public function deleteAllByCycle($id_cycle){
    $query = "DELETE FROM servire "
            . "WHERE ID_CYCLE = ". $id_cycle .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get(){
    
  }
  
  public function getAllByCycleJour($id_cycle, $num_jour){
    $query = "SELECT * FROM servire "
            . "WHERE ID_CYCLE = ". $id_cycle ." AND NUM_JOUR = ". $num_jour ." ORDER BY LIGNE_SERV;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
  
  public function getAllByCycleForTableau($id_cycle){
    $query = "SELECT * FROM servire "
            . "WHERE ID_CYCLE = ". $id_cycle ." ORDER BY LIGNE_SERV, NUM_JOUR;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
  
}

