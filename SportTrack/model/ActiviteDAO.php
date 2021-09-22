<?php
require_once('SqliteConnection.php');
require_once('Compte.php');
class ActiviteDAO {
    private static $dao;

    private function __construct() {}

    public final static function getInstance() {
       if(!isset(self::$dao)) {
           self::$dao= new ActiviteDAO();
       }
       return self::$dao;
    }

    public final function findAll(){
       $dbc = SqliteConnection::getInstance()->getConnection();
       $query = "select * from Activite order by idActivite";
       $stmt = $dbc->query($query);
       $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Activite');
       return $results;
    }

   public final function insert($cp){
      if($cp instanceof Activite){
         $dbc = SqliteConnection::getInstance()->getConnection();
         // prepare the SQL statement
         $query = "insert into Activite(idActivite, heureDebut, heureFin, date, description, duree, distanceParcourue,
         freqMin, freqMax, freqMoy,unCompte)
         values (:id, :hD, :hF, :da, :de, :du, :dP, :fMi, :fMa,:fMo, :uC)";
         $stmt = $dbc->prepare($query);

         // bind the paramaters
         $stmt->bindValue(':id',$cp->getIdActivite(),PDO::PARAM_INT);
         $stmt->bindValue(':hD',$cp->getHeureDebut(),PDO::PARAM_STR);
         $stmt->bindValue(':hF',$cp->getHeureFin(),PDO::PARAM_STR);
         $stmt->bindValue(':da',$cp->getDate(),PDO::PARAM_STR);
         $stmt->bindValue(':de',$cp->getDescription(),PDO::PARAM_STR);
         $stmt->bindValue(':du',$cp->getDuree(),PDO::PARAM_STR);
         $stmt->bindValue(':dP',$cp->getDistanceParcourue(),PDO::PARAM_INT);
         $stmt->bindValue(':fMi',$cp->getFreqMin(),PDO::PARAM_INT);
         $stmt->bindValue(':fMa',$cp->getFreqMax(),PDO::PARAM_INT);
         $stmt->bindValue(':fMo',$cp->getFreqMoy(),PDO::PARAM_INT);
         $stmt->bindValue(':uC',$cp->getUnCompte(),PDO::PARAM_STR);


         // execute the prepared statement
         $stmt->execute();
     }
  }

  public function delete($obj){
	  if($obj instanceof Activite){
		  $dbc = SqliteConnection::getInstance()->getConnection();
		  $query = "delete from Activite where idActivite = :id";
          $stmt = $dbc->prepare($query);

          $stmt->bindValue(':id',$obj->getIdActivite(),PDO::PARAM_INT);

          $stmt->execute();
	  }
	}

  public function update($obj){
		if($obj instanceof Activite){
         $dbc = SqliteConnection::getInstance()->getConnection();
         // prepare the SQL statement
         $query = "update Activite set heureDebut = :hD, heureFin = :hF, date = :da, description = :de,
         duree = :du, distanceParcourue = :dP, freqMin = :fMi, freqMax = :fMa, freqMoy = :fMo,
         unCompte = :uC
         where idActivite = :id";
         $stmt = $dbc->prepare($query);

         // bind the paramaters
         $stmt->bindValue(':id',$obj->getIdActivite(),PDO::PARAM_INT);
         $stmt->bindValue(':hD',$obj->getHeureDebut(),PDO::PARAM_STR);
         $stmt->bindValue(':hF',$obj->getHeureFin(),PDO::PARAM_STR);
         $stmt->bindValue(':da',$obj->getDate(),PDO::PARAM_STR);
         $stmt->bindValue(':de',$obj->getDescription(),PDO::PARAM_STR);
         $stmt->bindValue(':du',$obj->getDuree(),PDO::PARAM_STR);
         $stmt->bindValue(':dP',$obj->getDistanceParcourue(),PDO::PARAM_INT);
         $stmt->bindValue(':fMi',$obj->getFreqMin(),PDO::PARAM_INT);
         $stmt->bindValue(':fMa',$obj->getFreqMax(),PDO::PARAM_INT);
         $stmt->bindValue(':fMo',$obj->getFreqMoy(),PDO::PARAM_INT);
         $stmt->bindValue(':uC',$obj->getUnCompte(),PDO::PARAM_STR);


         // execute the prepared statement
         $stmt->execute();
     }
	}

	/**
	 * Returns all the activities of a specified user
	 * param  : $user an object of type Compte
	 * return : an array containing every activities of the user
	 */
	public function findActivities($user){
		if($user instanceof Compte){
			$dbc = SqliteConnection::getInstance()->getConnection();

			//On récupère ici toutes les Activités liées au compte
			//identifié par son mail
			$query = "select * from Activite where unCompte = :mail";
			$stmt = $dbc->prepare($query);
			//On récupère ici le mail de $user
			$stmt->bindValue(':mail',$user->getMail());
			$stmt->execute();
			//On met dans un tableau tous les objets de type Activite
			//stockés dans $stmt
			$tab = $stmt->fetchALL(PDO::FETCH_CLASS, "Activite");

			return $tab;
		}
	}

}
?>
