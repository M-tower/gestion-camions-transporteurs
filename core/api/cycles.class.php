<?php
class cycles {
  private $_ID_CYCLE;
  private $_ACTIF_CYCLE;

  //getter
  public function ID_CYCLE(){
  return $this->_ID_CYCLE;
  }
  public function ACTIF_CYCLE(){
  return $this->_ACTIF_CYCLE;
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
  public function setID_CYCLE($elt){
  $this->_ID_CYCLE = $elt;
  }
  public function setACTIF_CYCLE($elt){
  $this->_ACTIF_CYCLE = $elt;
  }
}

class cyclesManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }
  
  public function add(cycles $cycle){
    $query = "INSERT INTO cycles (ACTIF_CYCLE)"
            . "VALUES ("
            . $cycle->ACTIF_CYCLE()
            . ");";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return $this->getLastId();
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function getLastId(){
    $query = "SELECT ID_CYCLE FROM cycles ORDER BY ID_CYCLE DESC LIMIT 1;";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line['ID_CYCLE'];
  }
  public function update(cycles $cycle){
    $query = "UPDATE cycles "
            . "SET "
            . "ACTIF_CYCLE = ". $cycle->ACTIF_CYCLE() ." "
            . "WHERE ID_CYCLE = ". $cycle->ID_CYCLE() .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function disable($id_cycle){
    $query = "UPDATE cycles "
            . "SET "
            . "ACTIF_CYCLE = 0 "
            . "WHERE ID_CYCLE = ". $id_cycle .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function delete($id_cycle){
    $query .= "DELETE FROM cycles WHERE ID_CYCLE = ". $id_cycle .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get($id_cycle){
    $query = "SELECT * FROM cycles WHERE ID_CYCLE = ". $id_cycle .";";
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line;
  }
  
  public function checkIfIsActive($id_cycle){
    $query = "SELECT * FROM cycles WHERE ID_CYCLE = ". $id_cycle ." AND ACTIF_CYCLE = 1;";
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line;
  }
  
  public function getAll(){
    $query = "SELECT * FROM cycles ORDER BY ID_CYCLE;";
    $retour = $this->_db->query($query);
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
  
  public function getActif(){
    $query = "SELECT * FROM cycles WHERE ACTIF_CYCLE = 1 LIMIT 1;";
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line;
  }
  
  public function getAllInactif(){
    $query = "SELECT * FROM cycles WHERE ACTIF_CYCLE = 0;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
}

