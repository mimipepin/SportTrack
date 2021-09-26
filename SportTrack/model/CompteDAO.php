<?php
require_once('SqliteConnection.php');
class CompteDAO {
      private static $dao;

      private function __construct() {}

            public final static function getInstance() {
                  if(!isset(self::$dao)) {
                        self::$dao= new CompteDAO();
                  }
                  return self::$dao;
            }

            public final function findAll(){
                  $dbc = SqliteConnection::getInstance()->getConnection();
                  $query = "select * from Compte order by nom,prenom";
                  $stmt = $dbc->query($query);
                  $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Compte');
                  return $results;
            }

            public final function insert($cp){
                  if($cp instanceof Compte){
                        $dbc = SqliteConnection::getInstance()->getConnection();
                        // prepare the SQL statement
                        $query = "insert into Compte(mail, nom, prenom, dateNaissance,
                        sexe, poids, taille, mdp) values (:m, :n, :p, :d, :s, :po, :t,
                        :mdp)";
                        $stmt = $dbc->prepare($query);

                        // bind the paramaters
                        $stmt->bindValue(':m',$cp->getMail(),PDO::PARAM_STR);
                        $stmt->bindValue(':n',$cp->getNom(),PDO::PARAM_STR);
                        $stmt->bindValue(':p',$cp->getPrenom(),PDO::PARAM_STR);
                        $stmt->bindValue(':d',$cp->getDateNaissance(),PDO::PARAM_STR);
                        $stmt->bindValue(':s',$cp->getSexe(),PDO::PARAM_STR);
                        $stmt->bindValue(':po',$cp->getPoids(),PDO::PARAM_INT);
                        $stmt->bindValue(':t',$cp->getTaille(),PDO::PARAM_INT);
                        $stmt->bindValue(':mdp',$cp->getMdp(),PDO::PARAM_STR);


                        // execute the prepared statement
                        $stmt->execute();
                  }
            }

            public function delete($obj){
                  if($obj instanceof Compte){
                        $dbc = SqliteConnection::getInstance()->getConnection();
                        $query = "delete from Compte where mail = :m";
                        $stmt = $dbc->prepare($query);

                        $stmt->bindValue(':m',$obj->getMail(),PDO::PARAM_STR);

                        $stmt->execute();
                  }
            }

            public function update($obj){
                  if($obj instanceof Compte){
                        $dbc = SqliteConnection::getInstance()->getConnection();
                        // prepare the SQL statement
                        $query = "update Compte set nom = :n, prenom = :p, dateNaissance = :d, sexe = :s, poids = :po, taille = :t, mdp = :mdp where mail = :m";
                        $stmt = $dbc->prepare($query);

                        // bind the paramaters
                        $stmt->bindValue(':m',$obj->getMail(),PDO::PARAM_STR);
                        $stmt->bindValue(':n',$obj->getNom(),PDO::PARAM_STR);
                        $stmt->bindValue(':p',$obj->getPrenom(),PDO::PARAM_STR);
                        $stmt->bindValue(':d',$obj->getDateNaissance(),PDO::PARAM_STR);
                        $stmt->bindValue(':s',$obj->getSexe(),PDO::PARAM_STR);
                        $stmt->bindValue(':po',$obj->getPoids(),PDO::PARAM_INT);
                        $stmt->bindValue(':t',$obj->getTaille(),PDO::PARAM_INT);
                        $stmt->bindValue(':mdp',$obj->getMdp(),PDO::PARAM_STR);


                        // execute the prepared statement
                        $stmt->execute();
                  }
            }

            /**
      	 * Returns all the user from a specified email and password
      	 * param  : $email the email of the user
             * param : $password the password of the user
      	 * return : the selected user
      	 */
      	/*public function findUser($email, $password){
			$dbc = SqliteConnection::getInstance()->getConnection();

			//On récupère ici toutes les Activités liées au compte
			//identifié par son mail
			$query = "select * from Compte where mail = :mail and mdp = :password";
			$stmt = $dbc->prepare($query);
                  $stmt->bindValue(':mail', $email);
                  $stmt->bindValue(':password', $password);
			$stmt->execute();
			//On met dans un tableau tous les objets de type Activite
			//stockés dans $stmt
			$ret = $stmt->fetchALL(PDO::FETCH_CLASS, "Compte");

			return $ret;
      	}*/
            public function findUser($email, $password){
			$dbc = SqliteConnection::getInstance()->getConnection();

			//On récupère ici toutes les Activités liées au compte
			//identifié par son mail
			$query = "select * from Compte where mail = :mail and mdp = :password";
			$stmt = $dbc->prepare($query);
                  $stmt->bindValue(':mail', $email);
                  $stmt->bindValue(':password', $password);
			$stmt->execute();
			//On met dans un tableau tous les objets de type Activite
			//stockés dans $stmt
			$ret = $stmt->fetchObject('Compte');

			return $ret;
            }

      }
      ?>
