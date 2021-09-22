<?php
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	class Activite {
		private $idActivite;
		private $heureDebut;
		private $heureFin;
		private $date;
		private $description;
		private $duree;
		private $distanceParcourue;
		private $freqMin;
		private $freqMax;
		private $freqMoy;
		private $unCompte;

		public function __construct() {}

		public function init($id, $hD,$hF,$date,$description,$duree,$dP,
		$freqMin, $freqMax, $freqMoy, $unCompte){
			$this->idActivite= $id;
			$this->heureDebut = $hD;
			$this->heureFin = $hF;
			$this->date = $date;
			$this->description = $description;
			$this->duree = $duree;
			$this->distanceParcourue = $dP;
			$this->freqMin = $freqMin;
			$this->freqMax = $freqMax;
			$this->freqMoy = $freqMoy;
			$this->unCompte = $unCompte;
		}

		public function getIdActivite(){ return $this->idActivite;}
		public function getHeureDebut(){ return $this->heureDebut;}
		public function getHeureFin(){ return $this->heureFin;}
		public function getDate(){ return $this->date;}
		public function getDescription(){ return $this->description;}
		public function getDuree(){ return $this->duree;}
		public function getDistanceParcourue(){ return $this->distanceParcourue;}
		public function getFreqMin(){ return $this->freqMin;}
		public function getFreqMax(){ return $this->freqMax;}
		public function getFreqMoy(){ return $this->freqMoy;}
		public function getUnCompte(){ return $this->unCompte;}

		public function __toString(){ return $this->idActivite." ".
			 $this->heureDebut." ".
			 $this->heureFin." ".
			 $this->date." ".
			 $this->description." ".
			 $this->duree." ".
			 $this->distanceParcourue." ".
			 $this->freqMin." ".
			 $this->freqMax." ".
			 $this->freqMoy." ".
			 $this->unCompte." ";
		}
	}
?>
