<?php

/* 
 * Fonctions relatives à l'utilisation de la librairie phpMailer
 */

function mailSender($exp, $dest, $sujet, $message, $piece_jointe){
 /*
  * $exp (array(nom, adresse, tel, mail)) = les infos de l'expéditeur
  * $recep (array(a, cc, bcc)) = les types mails récepteurs (chacune pouvant contenir 
  *                              plusieurs mails séparés par des virgules)
  * $sujet (string) = sujet du mail
  * $message (string) = le contenu, peut être au format HTML
  * $piece_jointe (array(type,contenu)) = la pièce jointe
  * retourne "ok" si ok et un texte d'erreur si non.
  * NB: Cette fonction est générale pour envoyer toutes les mails mais pas pour l'envoie des factures
  */
// require 'PHPMailerAutoload.php';
 $mail = new PHPMailer();
 //configuration
// $mail->isSMTP();
// **************
// $mail->Username = 'AKIAWLLINXORVVHR2LTN';
// $mail->Password = 'BLzGIYhkadGcBWhpO1AtO0vs2euDYKy4Aq1Gcr6Iu4Za';
// $mail->Host = 'email-smtp.eu-west-1.amazonaws.com';
// $mail->SMTPAuth = true;
 
// Encodage -- default
// $mail->SMTPSecure = 'tls';
// $mail->Port =587;
// $mail->CharSet = 'UTF-8';
// $mail->isHTML(true);
 $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );
 // $mail->SMTPDebug = 2;     
 $mail->IsSMTP();
 $mail->Mailer = 'smtp';
 $mail->SMTPAuth = true;
 $mail->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
 $mail->Port = 587;
 $mail->SMTPSecure = 'tls';
 $mail->CharSet = 'UTF-8';
 
 $mail->Username = "messamix@gmail.com";
 $mail->Password = "chevrolet2014";

 $mail->IsHTML(true);

 $pied_page = ''
         . 'Cordialement<br><br><br>'
         . $exp['nom'].'<br>'
         . $exp['adresse'].'<br>'
         . $exp['tel'].'<br>';
 $contenu_html = ''
         . '<center class="fond" style="padding:27px;background-color: #e3efe6;">'
         . '<div class="feuille" style="border-radius: 7px;width: 50%;padding:40px 27px;background-color: #fff;box-shadow: 2px 2px 7px #d3bde8; text-align:left">'
         . $message
         . '<br><br>'
         . $pied_page
         . '</div>'
         . '</center>'
         . '<style>'
         . '.fond{background-color: #e3efe6; padding: 27px; text-align:center}'
         . '.feuille{background-color: #fff; padding: 40px 27px; text-align:left}'
         . '</style>';
 $body = $contenu_html;

// Expediteur, adresse de retour et destinataire :
 $mail->SetFrom('messamix@gmail.com', $exp['nom']);
 $mail->AddReplyTo($exp['mail'], $exp['nom']);
 if(trim($dest['a']) != ''){
  if(strpos($dest['a'],',') !== false){
   $brique = explode(',',$dest['a']);
   foreach($brique as $b){
    $mail->AddAddress($b);
   }
  }else{
   $mail->AddAddress($dest['a']);
  }
 }
 if(trim($dest['cc']) != ''){
  if(strpos($dest['cc'],',') !== false){
   $brique = explode(',',$dest['cc']);
   foreach($brique as $b){
    $mail->addCC($b);
   }
  }else{
   $mail->addCC($dest['cc']);
  }
 }
 if(trim($dest['bcc']) != ''){
  if(strpos($dest['bcc'],',') !== false){
   $brique = explode(',',$dest['bcc']);
   foreach($brique as $b){
    $mail->addBCC($b);
   }
  }else{
   $mail->addBCC($dest['bcc']);
  }
 }
 /* ajout du mail du compte principale en BCC */
 if(isset($_SESSION['mail_principal']) && $_SESSION['mail_principal'] != ''){
  $mail->addBCC($_SESSION['mail_principal']);
 }
// Sujet du mail
 $mail->Subject = $sujet;
// Le message
 $mail->MsgHTML($body);
// Pièce jointe
// if($piece_jointe){
//  $p_type = $piece_jointe['type'];
//  $p_contenu = $piece_jointe['contenu'];
//  if($p_type == 'facture'){
//   $lien_fac = "FACTURE_N°:".$p_contenu."_".$_SESSION['ndb'].".pdf";
//   $mail->AddAttachment($lien_fac,"FACTURE_N ".$p_contenu." de ".$exp['nom'].".pdf");
//  }
// }
// $lien_fac = "FACTURE_N°:".$num_fac."_".$_SESSION['ndb'].".pdf";
// $mail->AddAttachment($lien_fac,"FACTURE_N ".$num_fac." de ".$nom_exp.".pdf");

// Envoi de l'email
 if (!$mail->Send()) {
     return "Echec de l'envoi du mail, Erreur: " . $mail->ErrorInfo;
 } else {
     return "ok";
 }
 unset($mail);
}
