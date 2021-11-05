<?php

class camions {
  private $_IMMA_CAMION;
  private $_ID_TRANSP;
  private $_CAPACITE;

  //getter
  public function IMMA_CAMION(){
  return $this->_IMMA_CAMION;
  }
  public function ID_TRANSP(){
  return $this->_ID_TRANSP;
  }
  public function CAPACITE(){
  return $this->_CAPACITE;
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
  public function setID_TRANSP($elt){
  $this->_ID_TRANSP = $elt;
  }
  public function setCAPACITE($elt){
  $this->_CAPACITE = $elt;
  }
}

class camionsManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }
  
  public function add(camions $camion){
    $query = "INSERT INTO camions (IMMA_CAMION,ID_TRANSP,CAPACITE)"
            . "VALUES ("
            . "'".addslashes($camion->IMMA_CAMION())."',"
            . $camion->ID_TRANSP().","
            . "'".addslashes($camion->CAPACITE())."'"
            . ");";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return 1;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function update(camions $camion){
    $query = "UPDATE camions "
            . "SET "
            . "CAPACITE = '".addslashes($camion->CAPACITE())."' "
            . "WHERE IMMA_CAMION = '".addslashes($camion->IMMA_CAMION())."';";
    $retour = $this->_db->query($query);
//    logInConsole($retour);
    if($retour){
     return 2;
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function delete($imma_camion){
    $query = "DELETE FROM camions "
            . "WHERE IMMA_CAMION = '".addslashes($imma_camion)."';";
    $retour = $this->_db->query($query);
//    logInConsole($retour);
    if($retour){
     return '';
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get($imma_camion){
    $query = "SELECT * FROM camions WHERE IMMA_CAMION = '". addslashes($imma_camion) ."';";
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    return $line;
  }
  
  public function getAll(){
    /*
    * Retourne un tableau
    */
   $query = "SELECT *, "
           . "(SELECT MAISON_TRANSP FROM transporteurs as t WHERE t.ID_TRANSP = c.ID_TRANSP) as MAISON_TRANSP "
           . "FROM camions as c ORDER BY MAISON_TRANSP;";
 //  logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }
   return $collect;
  }
  
  public function getAllOpe(){
    /*
    * Retourne les camions opérationnels
    */
   $query = "SELECT * FROM camions ORDER BY IMMA_CAMION DESC;";
 //  logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }
   return $collect;
  }
  
  public function getAllById_transp($id_transp){
    
   $query = "SELECT * FROM camions WHERE ID_TRANSP = ".$id_transp." ORDER BY IMMA_CAMION DESC;";
 //  logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }
   return $collect;
  }
  
  public function getRankTransp(){
    /*
     * Retourne un tableau des transporteurs (ID) ayant des camion, du plus gros Ttransporteur au plus petit
     */
    $query = "SELECT ID_TRANSP, COUNT(ID_TRANSP) AS NBR FROM camions GROUP BY ID_TRANSP ORDER BY NBR DESC;";
    $retour = $this->_db->query($query);
    $collect = array();
    while($line = $retour->fetch(PDO::FETCH_ASSOC)){
     array_push($collect, $line);
    }
    return $collect;
  }
  
  public function getAllByTransp(){
    /*
    * Retourne tous les camions selon le plus gros transporteur au plus petit
    */
    $c = $this->getRankTransp();
    $collect = array();
    for($i=0; $i<sizeof($c); $i++){
      $query = "SELECT *, (SELECT MAISON_TRANSP FROM transporteurs as t WHERE t.ID_TRANSP = ". $c[$i]['ID_TRANSP'] .") as MAISON_TRANSP, "
              . "(SELECT CONTACTS_TRANSP FROM transporteurs as t WHERE t.ID_TRANSP = ". $c[$i]['ID_TRANSP'] .") as CONTACTS_TRANSP "
              . "FROM camions WHERE ID_TRANSP = ". $c[$i]['ID_TRANSP'] ." ORDER BY IMMA_CAMION;";
    //  logInConsole($query);
      $retour = $this->_db->query($query);
      while($line = $retour->fetch(PDO::FETCH_ASSOC)){
       array_push($collect, $line);
      }
//      array_merge($collect, $this->getAllById_transp($c[$i]['ID_TRANSP']));
    }
   return $collect;
  }
//  
//  public function getNbrCamionsMaxiParTransp(){
//    $query = "SELECT count(ID_TRANSP) as NBR FROM camions GROUP BY ID_TRANSP ORDER BY NBR DESC LIMIT 1;";
//    $retour = $this->_db->query($query);
//    if($retour){
//      $line = $retour->fetch(PDO::FETCH_ASSOC);
//      return $line['NBR'];
//    }else{
//      return $this->_db->errorInfo();
//    }
//  }
  
}

