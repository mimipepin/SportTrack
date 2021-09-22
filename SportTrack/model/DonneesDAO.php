<?php
require_once('SqliteConnection.php');
require_once('Activite.php');

class DonneesDAO {
    private static $dao;

    private function __construct() {
    }

    public final static function getInstance() {
        if (!isset(self::$dao)) {
            self::$dao = new DonneesDAO();
        }
        return self::$dao;
    }


    /**
     * Lists all the Donnees that exists
     * return : $results, an array containing every Donnees that exists
     */
    public final function findAll() {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "select * from Donnees order by idDonnees";
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Donnees');
        return $results;
    }

    public final function insert($cp) {
        if ($cp instanceof Donnees) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "insert into Donnees(idDonnees, temps, latitude,
         longitude, altitude, freqCardiaque, uneActivite) values
         (:id, :tp, :lat, :lon, :alt, :fC, :uA)";
            $stmt = $dbc->prepare($query);

            // bind the paramaters
            $stmt->bindValue(':id', $cp->getIdDonnees(), PDO::PARAM_INT);
            $stmt->bindValue(':tp', $cp->getTemps(), PDO::PARAM_STR);
            $stmt->bindValue(':lat', $cp->getLatitude(), PDO::PARAM_INT);
            $stmt->bindValue(':lon', $cp->getLongitude(), PDO::PARAM_INT);
            $stmt->bindValue(':alt', $cp->getAltitude(), PDO::PARAM_INT);
            $stmt->bindValue(':fC', $cp->getFreqCardiaque(), PDO::PARAM_INT);
            $stmt->bindValue(':uA', $cp->getUneActivite(), PDO::PARAM_INT);


            // execute the prepared statement
            $stmt->execute();
        }
    }

    public function delete($obj) {
        if ($obj instanceof Donnees) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            $query = "delete from Donnees where idDonnees = :id";
            $stmt = $dbc->prepare($query);

            $stmt->bindValue(':id', $obj->getIdDonnees(), PDO::PARAM_INT);

            $stmt->execute();
        }
    }

    public function update($cp) {
        if ($cp instanceof Donnees) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "update Donnees set idDonnees = :id, temps = :tp, latitude = :lat,
             longitude = :lon, altitude = :alt, freqCardiaque = :fC, uneActivite = :uA where idDonnees = :id";
            $stmt = $dbc->prepare($query);

            // bind the paramaters
            $stmt->bindValue(':id', $cp->getIdDonnees(), PDO::PARAM_INT);
            $stmt->bindValue(':tp', $cp->getTemps(), PDO::PARAM_STR);
            $stmt->bindValue(':lat', $cp->getLatitude(), PDO::PARAM_INT);
            $stmt->bindValue(':lon', $cp->getLongitude(), PDO::PARAM_INT);
            $stmt->bindValue(':alt', $cp->getAltitude(), PDO::PARAM_INT);
            $stmt->bindValue(':fC', $cp->getFreqCardiaque(), PDO::PARAM_INT);
            $stmt->bindValue(':uA', $cp->getUneActivite(), PDO::PARAM_INT);


            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Returns all the datas of a specified activity
     * param  : $activity an object of type Activite
     * return : an array containing every data of the activity
     */
    public function findDonnees($activity){
          if($activity instanceof Activite){
                $dbc = SqliteConnection::getInstance()->getConnection();

                //On récupère ici toutes les Activités liées au compte
                //identifié par son mail
                $query = "select * from Donnees where uneActivite = :idActivite";
                $stmt = $dbc->prepare($query);
                //On récupère ici le mail de $user
                $stmt->bindValue(':idActivite',$activity->getIdActivite());
                $stmt->execute();
                //On met dans un tableau tous les objets de type Donnees
                //stockés dans $stmt
                $tab = $stmt->fetchALL(PDO::FETCH_CLASS, "Donnees");

                return $tab;
          }
    }
}

?>
