<?php

/**
 * Description of connect
 * @author Sammy
 */
class connect {
 
// public $HOST = '127.0.0.1:3306';
 public $HOST = 'syntractnxsynadm.mysql.db';
 
 public $USER = 'syntractnxsynadm';
 
// public $PORT = '5432';
 
// public $PASSWORD = '1@mth3d@t@b0ss13';
 public $PASSWORD = 'Intersyderal2027';
 
 public $BDD = 'syntractnxsynadm';
 
// public $NDB = '907';
 
 public function setUSER($n){
  $this->USER = $n;
 }
 
 public function setPASSWORD($n){
  $this->PASSWORD = $n;
 }
 
// public function setNDB($n){
//  $this->NDB = $n;
// }
 
 public function __construct() {
  return $this;
 }
 
 public function connexion(){
   $options = [
//    PDO::ATTR_TIMEOUT => 120
];
  try{
    $dbconn = new PDO('mysql:host='.$this->HOST.';dbname='.$this->BDD.';charset=utf8', $this->USER, $this->PASSWORD 
    );
//    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//    die(json_encode(array('outcome' => true)));
  }
  catch(PDOException $ex){
      die(json_encode(array('outcome' => false, 'message' => 'Unable to connect : '.$ex->getMessage())));
  }
  return $dbconn;
//  $statement = $dbconn->query("SELECT 'Bonjour, cher utilisateur de MySQL !' AS _message FROM DUAL");
//  $row = $statement->fetch(PDO::FETCH_ASSOC);
//  echo htmlentities($row['_message']);
 }
 
 
}


