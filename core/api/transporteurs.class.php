<?php

class transporteurs {
  private $_ID_TRANSP;
  private $_DIRIGEANT_TRANSP;
  private $_MAISON_TRANSP;
  private $_ADRESSE_TRANSP;
  private $_MAIL_TRANSP;
  private $_LAT_TRANSP;
  private $_LNG_TRANSP;
  private $_CONTACTS_TRANSP;

  //getter
  public function ID_TRANSP(){
  return $this->_ID_TRANSP;
  }
  public function DIRIGEANT_TRANSP(){
  return $this->_DIRIGEANT_TRANSP;
  }
  public function MAISON_TRANSP(){
  return $this->_MAISON_TRANSP;
  }
  public function ADRESSE_TRANSP(){
  return $this->_ADRESSE_TRANSP;
  }
  public function MAIL_TRANSP(){
  return $this->_MAIL_TRANSP;
  }
  public function LAT_TRANSP(){
  return $this->_LAT_TRANSP;
  }
  public function LNG_TRANSP(){
  return $this->_LNG_TRANSP;
  }
  public function CONTACTS_TRANSP(){
  return $this->_CONTACTS_TRANSP;
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
  public function setID_TRANSP($elt){
  $this->_ID_TRANSP = $elt;
  }
  public function setDIRIGEANT_TRANSP($elt){
  $this->_DIRIGEANT_TRANSP = $elt;
  }
  public function setMAISON_TRANSP($elt){
  $this->_MAISON_TRANSP = $elt;
  }
  public function setADRESSE_TRANSP($elt){
  $this->_ADRESSE_TRANSP = $elt;
  }
  public function setMAIL_TRANSP($elt){
  $this->_MAIL_TRANSP = $elt;
  }
  public function setLAT_TRANSP($elt){
  $this->_LAT_TRANSP = $elt;
  }
  public function setLNG_TRANSP($elt){
  $this->_LNG_TRANSP = $elt;
  }
  public function setCONTACTS_TRANSP($elt){
  $this->_CONTACTS_TRANSP = $elt;
  }
}

class transporteursManager {
  private $_db;
 
  public function __construct($db) {
   $this->setDb($db);
  }

  public function setDb($db){ 
   $this->_db = $db->connexion();
  }

  public function add(transporteurs $transporteur){
    $lat = (trim($transporteur->LAT_TRANSP()) == '')? 'NULL' : trim($transporteur->LAT_TRANSP());
    $lng = (trim($transporteur->LNG_TRANSP()) == '')? 'NULL' : trim($transporteur->LNG_TRANSP());
    $query = "INSERT INTO transporteurs (DIRIGEANT_TRANSP,MAISON_TRANSP,ADRESSE_TRANSP,"
            . "MAIL_TRANSP,LAT_TRANSP,LNG_TRANSP, CONTACTS_TRANSP)"
            . "VALUES ("
            . "'".addslashes($transporteur->DIRIGEANT_TRANSP())."',"
            . "'".addslashes($transporteur->MAISON_TRANSP())."',"
            . "'".addslashes($transporteur->ADRESSE_TRANSP())."',"
            . "'".addslashes($transporteur->MAIL_TRANSP())."',"
            . $lat.","
            . $lng.","
            . "'".addslashes($transporteur->CONTACTS_TRANSP())."'"
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
    $query = "DELETE FROM transporteurs WHERE ID_TRANSP = ".$id.";"
            . "DELETE FROM camions WHERE ID_TRANSP = ".$id.";";
    $retour = $this->_db->query($query);
    if($retour){
      return '';
    }else{
      return $this->_db->errorInfo();
    }
  }
  public function update(transporteurs $transporteur){
    $lat = (trim($transporteur->LAT_TRANSP()) == '')? 'NULL' : trim($transporteur->LAT_TRANSP());
    $lng = (trim($transporteur->LNG_TRANSP()) == '')? 'NULL' : trim($transporteur->LNG_TRANSP());
    $query = "UPDATE transporteurs SET "
            . "DIRIGEANT_TRANSP='".addslashes($transporteur->DIRIGEANT_TRANSP())."',"
            . "MAISON_TRANSP='".addslashes($transporteur->MAISON_TRANSP())."',"
            . "ADRESSE_TRANSP='".addslashes($transporteur->ADRESSE_TRANSP())."',"
            . "MAIL_TRANSP='".addslashes($transporteur->MAIL_TRANSP())."',"
            . "LAT_TRANSP=".$lat.","
            . "LNG_TRANSP=".$lng.","
            . "CONTACTS_TRANSP='".addslashes($transporteur->CONTACTS_TRANSP())."'"
            . " WHERE ID_TRANSP = ".$transporteur->ID_TRANSP().";";
    $retour = $this->_db->query($query);
  //  logInConsole($retour);
    if($retour){
     return $transporteur->ID_TRANSP();
    }else{
     return $this->_db->errorInfo();
//     return $query;
    }
  }
  
  public function get($id){
   /*
    * Retourner un user par id
    */
    $query = "SELECT * FROM transporteurs WHERE ID_TRANSP = ".intval($id);
 //  logInConsole($query);
    $retour = $this->_db->query($query);
    $line = $retour->fetch(PDO::FETCH_ASSOC);
    if(is_array($line)){
      $transporteur = new transporteurs();
      $transporteur->hydrate($line);

      return $transporteur;
    }else{
      return $line;
    }
  }

  public function getAll(){
    /*
    * Retourne une collection d'objets de type transporteurs
    */
   $query = "SELECT *, (SELECT COUNT(*) FROM camions as c WHERE c.ID_TRANSP = t.ID_TRANSP) as NB_CAMIONS "
           . "FROM transporteurs as t ORDER BY ID_TRANSP DESC;";
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
    * Retourne une collection d'objets de type transporteurs
    */
   $query = "SELECT * FROM transporteurs ORDER BY ID_TRANSP DESC LIMIT ".$a." ;";
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
  $query = "SELECT ID_TRANSP "
   . "FROM transporteurs ORDER BY ID_TRANSP DESC LIMIT 1;";
//   logInConsole($query);
  $retour = $this->_db->query($query);
  $line = $retour->fetch(PDO::FETCH_ASSOC);
  return $line['ID_TRANSP'];
 }

}

