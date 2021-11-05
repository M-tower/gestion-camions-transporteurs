<?php

require_once('../core/functions.php');

?>
<html>
  <?php
  $id_cycle = (isset($_POST['id_cycle']))? $_POST['id_cycle'] : 1;
  $num_jour= (isset($_POST['num_jour']))? $_POST['num_jour'] : 1;
  $with_name= (isset($_POST['with_name']))? $_POST['with_name'] : 0;
  $coll = array();
//  echo getIfElementExist('NUM_JOUR', 1, 'jours');
  $found = 0;
  for($i=0; $i<6; $i++){
    $j = intVal($num_jour) + $i;
    if(getIfElementExist('NUM_JOUR', $j, 'jours') == 1){
      $coll[$j] = getAllServiresByCycleJour($id_cycle, $j);
      $found = 1;
    }
  }
//  $tout = getAllServiresByCycleJour($id_cycle, $num_jour);
 // print_r($tout);
  $big_container ='
  <head>    
	<title>Liste du jour | SY.NA.TRA.C.T</title>
	<meta charset="utf-8"/>
  <style>
    .tableau{
      width: 100%;
      border: 1px solid #ebebeb;
      border-collapse: collapse;
      margin-bottom: 300px; /* POUR LES SAUTS DE PAGES */
    }
    .tableau th, .tableau td{
      border-collapse: collapse;
      border-spacing: 0;
      padding: 7px;
      border: 1px solid #ebebeb;
      text-align: left;
      font-size: 12px;
    }
    .odd{
      background-color: #e2e2e2;
    }
    .entete img{
      max-height: 200px;
    }
    body{
      font-family: "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif;
      padding-top: 200px;
    }
    header{
      position: fixed;
      top: -62px;
      heigth: 200px;
    }
  </style>
  </head>
  <body>
    <header class="entete">
      <img src="../img/entete.JPG" alt="Entete"/>
    </header><br>';
  if($found == 0){
    $big_container .='</table><br>
          <h3 style="text-align:center">Liste indisponible pour le moment. Veuillez reéssayer plus tard!</h3>
        </div>';
  }else{
    if($with_name === 0){
      foreach($coll as $k => $v){
        $big_container .='
        <h2 style="text-align:center">Liste des camions du jour N° '.$k.' du cycle N° '.$id_cycle.'</h2>
        <div class="contenu">
          <table class="tableau">
          <tr><th style="width:5%">N°</th>
          <th style="width:80%">Immatriculation</th>
          <!--th style="width:40%">Transporteur</th>
          <th style="width:20%">Contact</th-->
          <th>Etat</th></tr>';
        for($i=0; $i<sizeof($v); $i++){
          $fond = (($i % 2) == 0)? 'odd' : 'even';
          $big_container .='<tr class="' . $fond . '">'
                  . '<td>' . ($i+1) . '</td>'
                  . '<td>' . $v[$i]['IMMA_CAMION'] . '</td>'
                  . '<!--td>' . $v[$i]['MAISON_TRANSP'] . '</td>'
                  . '<td>' . $v[$i]['CONTACTS_TRANSP'] . '</td-->'
                  . '<td>' . $v[$i]['ETAT_SERV'] . '</td>'
                  . '</tr>';
        }
        $big_container .='</table>
          </div>';
      }
    }else{
      if (isset($_SESSION['header'])){
        foreach($coll as $k => $v){
          $big_container .='
          <h2 style="text-align:center">Liste des camions du jour N° '.$k.' du cycle N° '.$id_cycle.'</h2>
          <div class="contenu">
            <table class="tableau">
            <tr><th style="width:5%">N°</th>
            <th style="width:40%">Immatriculation</th>
            <th style="width:40%">Transporteur</th>
            <th>Etat</th></tr>';
          for($i=0; $i<sizeof($v); $i++){
            $fond = (($i % 2) == 0)? 'odd' : 'even';
            $big_container .='<tr class="' . $fond . '">'
                    . '<td>' . ($i+1) . '</td>'
                    . '<td>' . $v[$i]['IMMA_CAMION'] . '</td>'
                    . '<td>' . $v[$i]['MAISON_TRANSP'] . '</td>'
                    . '<td>' . $v[$i]['ETAT_SERV'] . '</td>'
                    . '</tr>';
          }
          $big_container .='</table>
            </div>';
        }
      }else{
        $big_container .='</table><br>
          <h3 style="text-align:center">Vous devez être connecté pour afficher cette liste</h3>
        </div>';
      }
    }
  }
  $big_container .= '</body>';
  echo $big_container;
  ?>
  </html>

