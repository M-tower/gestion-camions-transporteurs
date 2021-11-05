<?php

/*
 * NETTOYAGE DES DONNEES ENTRANTES
 */
function valideEntreeDB($entree){
 /*
  * Retourne $entree formaté s'il n'est pas vide et un string vide si non
  * $entree (string) = l'élément à tester
  */
 $retour = '';
 if(trim($entree) != ''){
  $retour = preg_replace(array('/\\\\/', '/</', '/>/'), '', $entree);
  $retour = preg_replace('/\"/', '*', $retour);
  $retour = preg_replace('/[\n\r]/', '<br>', $retour);
 }
 return trim(urldecode($retour));
}
function nettoyeur(){
 /*
  * Récupère tous les POST ou presque pour les nettoyer
  * fonction 'valideEntreeDB' surtout pour les strings
  * 
  * Lors du traitement, les variables seront plutôt appelés depuis le tableau retourné par cette
  * fonction plutôt que les $_POST.
  * Première exemple dans la fonction 'inscriptionSociete()'.
  */
 $options = array(
      'dirigeant_transp' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'maison_transp' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'adresse_transp' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'contacts_transp' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'mail_transp' => FILTER_SANITIZE_EMAIL,
      'mail_user' => FILTER_SANITIZE_EMAIL,
      'url' => FILTER_SANITIZE_URL,
      'prenom' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'ids' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'ref' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'imma_camion' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'capacite' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'raison_soc_client' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'adresse_client' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'contacts_client' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'pays_client' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'commentaire_serv' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'etat_serv' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valideEntreeDB'
      ),
      'id_transp' => FILTER_SANITIZE_NUMBER_INT,
      'id_client' => FILTER_SANITIZE_NUMBER_INT,
      'num_jour' => FILTER_SANITIZE_NUMBER_INT,
      'id_cycle' => FILTER_SANITIZE_NUMBER_INT,
      'ligne_serv' => FILTER_SANITIZE_NUMBER_INT,
      'limite' => FILTER_SANITIZE_NUMBER_INT,
      'nb_jour' => FILTER_SANITIZE_NUMBER_INT,
      'jour_actif' => FILTER_SANITIZE_NUMBER_INT,
      'jr_ajoute' => FILTER_SANITIZE_NUMBER_INT,
      'lat_transp' => FILTER_SANITIZE_NUMBER_FLOAT,
      'lng_transp' => FILTER_SANITIZE_NUMBER_FLOAT

  );
 $donnees = filter_input_array(INPUT_POST, $options);
 return $donnees;
}
