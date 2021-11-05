<?php

class utilisateurs {
  private $_ID_UTIL;
  private $_NOM_UTIL;
  private $_PRENOM_UTIL;
  private $_PSEUDO_UTIL;
  private $_MAIL_UTIL;
  private $_PASS_UTIL;
  private $_TYPE_UTIL;
  private $_ETAT_UTIL;

  //getter
  public function ID_UTIL(){
  return $this->_ID_UTIL;
  }
  public function NOM_UTIL(){
  return $this->_NOM_UTIL;
  }
  public function PRENOM_UTIL(){
  return $this->_PRENOM_UTIL;
  }
  public function PSEUDO_UTIL(){
  return $this->_PSEUDO_UTIL;
  }
  public function MAIL_UTIL(){
  return $this->_MAIL_UTIL;
  }
  public function PASS_UTIL(){
  return $this->_PASS_UTIL;
  }
  public function TYPE_UTIL(){
  return $this->_TYPE_UTIL;
  }
  public function ETAT_UTIL(){
  return $this->_ETAT_UTIL;
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
  public function setID_UTIL($elt){
  $this->_ID_UTIL = $elt;
  }
  public function setNOM_UTIL($elt){
  $this->_NOM_UTIL = $elt;
  }
  public function setPRENOM_UTIL($elt){
  $this->_PRENOM_UTIL = $elt;
  }
  public function setPSEUDO_UTIL($elt){
  $this->_PSEUDO_UTIL = $elt;
  }
  public function setMAIL_UTIL($elt){
  $this->_MAIL_UTIL = $elt;
  }
  public function setPASS_UTIL($elt){
  $this->_PASS_UTIL = $elt;
  }
  public function setTYPE_UTIL($elt){
  $this->_TYPE_UTIL = $elt;
  }
  public function setETAT_UTIL($elt){
  $this->_ETAT_UTIL = $elt;
  }
}

class utilisateurManager {
  private $_db;
 
 public function __construct($db) {
  $this->setDb($db);
 }
 
 public function add(utilisateur $utilisateur){
  
 }
 
 public function delete($id){
//  $query = "DELETE FROM utilisateurs "
//    . "WHERE id = ".$id.";";
//  $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
//  return pg_result_error($retour);
 }
 public function update(utilisateur $utilisateur){
  
 }
 
 public function changeMDP($pass, $mail){
  $query = "UPDATE utilisateurs "
    . "SET "
    . "PASS_UTIL = '".addslashes($pass)."' "
    . "WHERE MAIL_UTIL = '".addslashes($mail)."';";
  $result = $this->_db->prepare($query); 
  $result->execute();
  return $result->rowCount();
//  logInConsole('la requete = '.$query);
 }
 public function get($id){
  /*
   * Retourner un user par id
   */
  $query = "SELECT * FROM utilisateurs WHERE ID_UTIL = ".intval($id);
//  logInConsole($query);
  $retour = $this->query($query);
  $line = $retour->fetch(PDO::FETCH_ASSOC);
  $utilisateur = new utilisateur();
  $utilisateur->hydrate($line);

  return $utilisateur;
 }
 
 public function getAll(){
  /*
    * Retourne un tableau
    */
   $query = "SELECT * FROM utilisateurs ORDER BY MAIL_UTIL;";
 //  logInConsole($query);
   $retour = $this->_db->query($query);
//   $line = $retour->fetch(PDO::FETCH_ASSOC);
   $collect = array();
   while($line = $retour->fetch(PDO::FETCH_ASSOC)){
    array_push($collect, $line);
   }
   return $collect;
 }
 
 public function getByMail($mail){
   
  $query = "SELECT * FROM utilisateurs WHERE MAIL_UTIL = '".$mail."';";
  $retour = $this->_db->query($query);
  $line = $retour->fetch();
//  print_r($line);
  $utilisateur = new utilisateurs();
  $utilisateur->hydrate($line);
  return $utilisateur;
 }
 
 public function checkForLogin($mail, $pwd){
  /*
   * Retourne l'objet utilisateur si ok et 0 si non
   */
  $query = "SELECT * FROM utilisateurs WHERE (MAIL_UTIL = '".$mail."' OR PSEUDO_UTIL = '".$mail."') "
          . "AND PASS_UTIL = '".addslashes($pwd)."';";
  $retour = $this->_db->query($query);
  $line = $retour->fetch(PDO::FETCH_ASSOC);
  $utilisateur = new utilisateurs();
  $result = $this->_db->prepare("SELECT FOUND_ROWS()"); 
  $result->execute();
  if($result->fetchColumn() > 0){
   $utilisateur->hydrate($line);
   return $utilisateur;
  }else{
   return 0;
  }
 }
 
 public function setDb($db){ /* $db peut être du type connect ou connectP */
  $this->_db = $db->connexion();
 }
}