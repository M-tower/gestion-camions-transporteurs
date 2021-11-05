<?php

/*
 * Cette classe regroupe toutes les fonctions à usage général
 * donc qui ne sont rattachées à aucune table en particulier
 */

class generale_function {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }
    public function setDb(connect $db){
        $this->_db = $db->connexion();
    }

    //Fonction qui retourne 1 si la table en question exists
    public static function tableExiste($table){
        $db_id = $_SESSION["ndb"];
        $res = connecteur($db_id)->connexion();
        //retourne si la table en question existe;
        if($res) {
            $requete = "SELECT tablename as nom FROM pg_catalog.pg_tables where tablename ='$table';";

            //die($requete);
            $retour = pg_query($requete) or die("Échec de la requête : $requete");

            if(pg_num_rows($retour)){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
    public function ifIdExist($idDesig, $idVal, $tableName){
        /*
         * Retourne 1 si l'id existe dand $tableName et 0 si non
         */
        $query = "SELECT * "
            . "FROM ". $tableName ." "
            . "WHERE ". $idDesig ." = ". $idVal .";";
        $retour = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
        //  $line = pg_fetch_array($retour, null, PGSQL_ASSOC);
        //  logInConsole('lignes = '.pg_num_rows($retour));
        if(pg_num_rows($retour) > 0){
            return 1;
        }
        return 0;
    }
    public function ifElementExist($colName, $value, $tableName){
        /*
         * Retourne 1 si ok et 0 si non
         */
        $query = "SELECT count(*) as nombre "
            . "FROM ". $tableName ." "
            . "WHERE lower(". $colName .") = lower('". addslashes($value) ."');";
        $retour = $this->_db->prepare($query);
        $retour->execute();
        $line = $retour->fetchAll(\PDO::FETCH_ASSOC);
        //  logInConsole('lignes = '.pg_num_rows($retour));
        if($line[0]['nombre'] > 0){
            return 1;
        }
        return 0;
    }
    public function ifElementsCombiExist($array, $tableName){
        /*
         * Retourne 1 si les conditions sont réunies dans $tableName et 0 si non
         */
        $conditions = "";
        $and = "";
        foreach($array as $key => $value){
            if($value != 'NULL'){
                $and = ($conditions != '')? " AND " : "";
                $val = (is_int($value) || (intval($value) != 0 && strlen($value) == strlen((string)intval($value)))) ? $value : "'".addslashes($value)."'";
                $conditions .= $and . $key . " = " .$val;
            }
        }
        $query = "SELECT count(*) as nombre "
            . "FROM ". $tableName ." "
            . "WHERE ". $conditions .";";
        $retour = $this->_db->prepare($query);
        $retour->execute();
        $line = $retour->fetchAll(\PDO::FETCH_ASSOC);
        //  logInConsole('lignes = '.pg_num_rows($retour));
        if($line[0]['nombre'] > 0){
            return 1;
        }
        return 0;
    }


    public static function creationTableDevis(){
        $script =
            "
            CREATE TABLE IF NOT EXISTS devis
            (
              id SERIAL ,
              date_devis date,
              id_client integer,
              id_comm integer,
              adresse character varying(150),
              modalite character varying(60),
              echeance date,
              remise integer,
              statut character varying,
              date_envoi_livraison date,
              montant_livraison numeric(10,2),
              numero_suivi character varying,
              agence_livraison character varying,
              CONSTRAINT devis_pkey PRIMARY KEY (id),
              CONSTRAINT devis_id_client_fkey FOREIGN KEY (id_client)
                  REFERENCES societes (id) MATCH SIMPLE
                  ON UPDATE CASCADE ON DELETE CASCADE,
              CONSTRAINT devis_id_comm_fkey FOREIGN KEY (id_comm)
                  REFERENCES commerciaux (id) MATCH SIMPLE
                  ON UPDATE CASCADE ON DELETE CASCADE
            )
            WITH (
              OIDS=FALSE
            );

            CREATE TABLE IF NOT EXISTS lignes_devis
            (
              id_devis integer NOT NULL,
              quantite integer NOT NULL DEFAULT 1,
              nom_article character varying(50) NOT NULL,
              ref_article character varying(30) NOT NULL,
              prix_ht numeric(12,2) NOT NULL DEFAULT 0,
              type_tva character varying(30),
              remise integer,
              description character varying(500),
              ordre integer,
              tva_inclus boolean DEFAULT true,
              CONSTRAINT lignes_devis_pkey PRIMARY KEY (id_devis, ref_article)
            )
            WITH (
              OIDS=FALSE
            );
            ";
        $db_id = $_SESSION["ndb"];

        $res = connecteur($db_id)->connexion();
        if($res){
            $retour = pg_query($script) or die(pg_last_error());

            return true;
        }else{
            return false;
        }
    }
}
