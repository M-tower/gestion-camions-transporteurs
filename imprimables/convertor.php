<?php

require ('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
/*$files = glob("dompdf/include/*.php");
foreach($files as $file) include_once($file);*/
$dompdf = new Dompdf(array('isRemoteEnabled' => true));
$filename = 'modele1.html';
//$filecontent = file_POST_contents($filename);
$jr=$_POST['num_jour'];
$cycle = $_POST['id_cycle'];
$with_name = (isset($_GET['with_name']))? $_GET['with_name'] : 0;

include_once('liste-du-jour.php');
            
$big_container .='<style>'
        . 'body{'
        . 'margin: -62px 0 62px 0;}'
        . '</style>';
$dompdf->loadHtml($big_container);
$dompdf->render();
$pdf = $dompdf->output();
$f = ($with_name === 0)? file_put_contents('fichiers-pdf/liste_jour_'.$jr.'_cycle_'.$cycle.'.pdf', $pdf) : file_put_contents('fichiers-pdf/liste_jour_'.$jr.'_cycle_'.$cycle.'_avecNoms.pdf', $pdf);

echo $f;
?>


