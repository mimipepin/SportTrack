<?php
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	class Donnees {
		private $idDonnees;
		private $temps;
		private $latitude;
		private $longitude;
		private $altitude;
		private $freqCardiaque;
		private $uneActivite;
		
		/**
		 * Constructeur sans parametres
		 */
		public function __construct() {}
		
		public function init($id, $temps, $latitude, $longitude, $altitude,
		$freqCardiaque, $uneActivite){
			$this->idDonnees = $id;
			$this->temps = $temps;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
			$this->altitude = $altitude;
			$this->freqCardiaque = $freqCardiaque;
			$this->uneActivite = $uneActivite;
		}
		
		public function getIdDonnees(){ return $this->idDonnees;}
		public function getTemps(){ return $this->temps;}
		public function getLatitude(){ return $this->latitude;}
		public function getLongitude(){ return $this->longitude;}
		public function getAltitude(){ return $this->altitude;}
		public function getFreqCardiaque(){ return $this->freqCardiaque;}
		public function getUneActivite(){ return $this->uneActivite;}
		
		public function __toString(){ return $this->idActivite." ".
			 $this->temps." ".
			 $this->latitude." ".
			 $this->longitude." ".
			 $this->altitude." ".
			 $this->freqCardiaque." ".
			 $this->uneActivite;
		}
	}
?>
