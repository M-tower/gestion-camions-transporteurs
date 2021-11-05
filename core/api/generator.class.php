<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class generateur {
 
 public function hydrate (array $col){
  $attr = '';
  $getter = '//getter<br>';
  $setter = '//setter<br>';
  $hydrate = '//hydratation<br>'
    . 'public function hydrate(array $d){<br>'
    . 'foreach ($d as $key => $value){<br>'
    . '$methode = \'set\'.ucfirst($key);<br>'
    . 'if(method_exists($this, $methode)){<br>'
    . '$this->$methode($value);<br>'
   . '}<br>'
  . '}<br>'
 . '}<br>';
  
  foreach ($col as $c){
   $attr = $attr . 'private $_'.$c.';<br>';
   $getter = $getter . 'public function '.$c.'(){'
     .'<br>return $this->_'.$c.';<br>'
     .'}<br>';
   $setter = $setter . 'public function set'.ucfirst($c).'($elt){'
     .'<br>$this->_'.$c.' = $elt;<br>'
     .'}<br>';
  }
  
  return $attr . '<br>' . $getter . '<br>' . $hydrate . '<br>' . $setter;
 }
 
}

class listerAttr {
 /*
  * Liste les attributs des champs
  */
 public function hydrate (array $array, $var){
  $cont = '';
  foreach ($array as $a){
   $cont .= '$'.$a.' = $'.$var.'->'.$a.'();<br>'; 
  }
  return $cont;
 }
}