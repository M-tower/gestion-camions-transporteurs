<?php

class clients {
  private $_ID_CLIENT;
  private $_RAISON_SOC_CLIENT;
  private $_ADRESSE_CLIENT;
  private $_CONTACTS_CLIENT;
  private $_PAYS_CLIENT;
  private $_NBRE_LIVRE;

  //getter
  public function ID_CLIENT(){
  return $this->_ID_CLIENT;
  }
  public function RAISON_SOC_CLIENT(){
  return $this->_RAISON_SOC_CLIENT;
  }
  public function ADRESSE_CLIENT(){
  return $this->_ADRESSE_CLIENT;
  }
  public function CONTACTS_CLIENT(){
  return $this->_CONTACTS_CLIENT;
  }
  public function PAYS_CLIENT(){
  return $this->_PAYS_CLIENT;
  }
  public function NBRE_LIVRE(){
  return $this->_NBRE_LIVRE;
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
  public function setID_CLIENT($elt){
  $this->_ID_CLIENT = $elt;
  }
  public function setRAISON_SOC_CLIENT($elt){
  $this->_RAISON_SOC_CLIENT = $elt;
  }
  public function setADRESSE_CLIENT($elt){
  $this->_ADRESSE_CLIENT = $elt;
  }
  public function setCONTACTS_CLIENT($elt){
  $this->_CONTACTS_CLIENT = $elt;
  }
  public function setPAYS_CLIENT($elt){
  $this->_PAYS_CLIENT = $elt;
  } 
  public function setNBRE_LIVRE($elt){
  $this->_NBRE_LIVRE = $elt;
  } 
}

class clientsManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }

  public function add(clients $client){
    
    $query = "INSERT INTO clients (RAISON_SOC_CLIENT,ADRESSE_CLIENT,CONTACTS_CLIENT,PAYS_CLIENT)"
            . "VALUES ("
            . "'".addslashes($client->RAISON_SOC_CLIENT())."',"
            . "'".addslashes($client->ADRESSE_CLIENT())."',"
            . "'".addslashes($client->CONTACTS_CLIENT())."',"
            . "'".addslashes($client->PAYS_CLIENT())."'"
            . ");";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return $this->getIdAuto();
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }

  public function delete($id){
    $query = "DELETE FROM clients WHERE ID_CLIENT = ".$id.";";
    $retour = $this->_db->query($query);
    if($retour){
      return '';
    }else{
      return $this->_db->errorInfo();
    }
  }
  public function update(clients $client){
    $query = "UPDATE clients SET "
            . "RAISON_SOC_CLIENT='".addslashes($client->RAISON_SOC_CLIENT())."',"
            . "ADRESSE_CLIENT='".addslashes($client->ADRESSE_CLIENT())."',"
            . "CONTACTS_CLIENT='".addslashes($client->CONTACTS_CLIENT())."',"
            . "PAYS_CLIENT='".addslashes($client->PAYS_CLIENT())."'"
            . " WHERE ID_CLIENT = ".$client->ID_CLIENT().";";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return $client->ID_CLIENT();
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get($id){
   /*
    * Retourner un user par id
    */
    $query = "SELECT *, "
            . "(SELECT COUNT(*) FROM servire WHERE ID_CLIENT = ".$id.") AS NBRE_LIVRE"
            . " FROM clients WHERE ID_CLIENT = ".intval($id);
 //  logInConsole($query);
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    if(is_array($line)){
      $client = new clients();
      $client->hydrate($line);

      return $client;
    }else{
      return $line;
    }
  }

  public function getAll(){
    /*
    * Retourne un tableau de clients
    */
   $query = "SELECT * FROM clients ORDER BY ID_CLIENT DESC;";
 //  logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }

   return $collect;
  }

  public function getAllLimite($a){
    /*
    * Retourne une collection d'objets de type clients
    */
   $query = "SELECT * FROM clients ORDER BY ID_CLIENT DESC LIMIT ".$a." ;";
//   logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }

   return $collect;
  }

  public function getIdAuto(){
  /*
  * Retourne le dernier id de la table societes
  */
  $query = "SELECT ID_CLIENT "
   . "FROM clients ORDER BY ID_CLIENT DESC LIMIT 1;";
//   logInConsole($query);
  $retour = $this->_db->query($query);
  $line = $retour->fetch(PDO::FETCH_ASSOC);
  return $line['ID_CLIENT'];
 }
}

