<?php

class jours {
  private $_NUM_JOUR;
  private $_ID_CYCLE;
  private $_ACTIF_JOUR;

  //getter
  public function NUM_JOUR(){
  return $this->_NUM_JOUR;
  }
  public function ID_CYCLE(){
  return $this->_ID_CYCLE;
  }
  public function ACTIF_JOUR(){
  return $this->_ACTIF_JOUR;
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
  public function setNUM_JOUR($elt){
  $this->_NUM_JOUR = $elt;
  }
  public function setID_CYCLE($elt){
  $this->_ID_CYCLE = $elt;
  }
  public function setACTIF_JOUR($elt){
  $this->_ACTIF_JOUR = $elt;
  }
}

class joursManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }
  
  public function add(jours $jour){
    $query = "INSERT INTO jours (NUM_JOUR, ID_CYCLE, ACTIF_JOUR)"
            . "VALUES ("
            . $jour->NUM_JOUR() . ","
            . $jour->ID_CYCLE() . ","
            . $jour->ACTIF_JOUR()
            . ");";
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
  
  public function disable($num_jour){
    $query = "UPDATE jours "
            . "SET "
            . "ACTIF_JOUR = 0 "
            . "WHERE NUM_JOUR = ". $num_jour .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function delete($num_jour){
    $query = "DELETE FROM jours "
            . "WHERE NUM_JOUR = ". $num_jour .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  public function deleteAllByCycle($id_cycle){
    $query = "DELETE FROM jours "
            . "WHERE ID_CYCLE = ". $id_cycle .";";
    $retour = $this->_db->query($query);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get($num_jour){
    $query = "SELECT * FROM jours WHERE NUM_JOUR = ". $num_jour .";";
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line;
  }
  
  public function getAllByCycle($id_cycle){
    $query = "SELECT * FROM jours WHERE ID_CYCLE = ". $id_cycle ." ORDER BY NUM_JOUR;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
  
  public function getActifByCycle($id_cycle){
    $query = "SELECT * FROM jours WHERE ID_CYCLE = ". $id_cycle ." AND ACTIF_JOUR = 1 ORDER BY NUM_JOUR;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
}
