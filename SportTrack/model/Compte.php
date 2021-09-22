<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
class Compte {
	private $mail;
	private $nom;
	private $prenom;
	private $dateNaissance;
	private $sexe;
	private $poids;
	private $taille;
	private $mdp;

	/**
	* Constructeur sans parametres
	*/
	public function __construct() {}

		/**
		* Constructeur avec parametres
		* @param nom
		* @param prenom
		* @param mail
		* @param dateNaissance
		* @param sexe
		* @param poids
		* @param taille
		* @param mdp
		*/
		public function init($mail, $nom, $prenom, $dateNaissance, $sexe,
		$poids, $taille, $mdp){
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->mail = $mail;
			$this->dateNaissance = $dateNaissance;
			$this->sexe = $sexe;
			$this->poids = $poids;
			$this->taille = $taille;
			$this->mdp = $mdp;
		}

		public function getNom(){ return $this->nom;}
		public function getPrenom(){ return $this->prenom;}
		public function getMail(){ return $this->mail;}
		public function getDateNaissance(){ return $this->dateNaissance;}
		public function getSexe(){ return $this->sexe;}
		public function getPoids(){ return $this->poids;}
		public function getTaille(){ return $this->taille;}
		public function getMdp(){ return $this->mdp;}

		public function __toString(){
			return $this->nom." ".
				$this->prenom." ".
				$this->mail." ".
				$this->dateNaissance." ".
				$this->sexe." ".
				$this->poids." ".
				$this->taille." ".
				$this->mdp;
		}
	}

	?>
