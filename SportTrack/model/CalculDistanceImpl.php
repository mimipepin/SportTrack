<?php
require_once "CalculDistance.php";
class CalculDistanceImpl implements CalculDistance {
	/**
	* Retourne la distance en mètres entre 2 points GPS exprimés en degrés.
	* @param float $lat1 Latitude du premier point GPS
	* @param float $long1 Longitude du premier point GPS
	* @param float $lat2 Latitude du second point GPS
	* @param float $long2 Longitude du second point GPS
	* @return float La distance entre les deux points GPS
	*/
	public function calculDistance2PointsGPS($lat1, $long1, $lat2, $long2) {

		#$d=6378137*acos(sin(pi()*$lat2/180)*sin(pi()*$lat1/180)+cos(pi()*$lat2/180)*cos(pi()*$lat1/180)*cos((pi()*$long2/180)-(pi()*$long1/180)));
		$r = 6378137;
        	$lat1 = deg2rad($lat1);
        	$lat2 = deg2rad($lat2);
        	$long1 = deg2rad($long1);
        	$long2 = deg2rad($long2);

        	return $r * acos(sin($lat2)*sin($lat1)+cos($lat2)*cos($lat1)*cos($long2-$long1));
	}

	/**
	* Retourne la distance en metres du parcours passé en paramètres. Le parcours est
	* défini par un tableau ordonné de points GPS.
	* @param Array $parcours Le tableau contenant les points GPS
	* @return float La distance du parcours
	*/
	public function calculDistanceTrajet(Array $parcours){

		$distanceTotale=0;
		for ($i = 1; $i < sizeof($parcours); $i++){
			$distanceTotale = $distanceTotale + $this->calculDistance2PointsGPS($parcours[$i-1]["latitude"],$parcours[$i-1]["longitude"], $parcours[$i]["latitude"], $parcours[$i]["longitude"]);
		}
		return $distanceTotale;
	}

	/**
	* Extrait la longitude et la latitude d'un tableau Json décodé
	* @param array le tableau du Json
	* @return array le tableau extrait avec la longitude et la latitude
	*/
	public function arrayDistance($array){
		$arrayDist = [];
		for ($i = 0; $i < sizeof($array); $i++){
			$arrayDist += array($i => array("latitude" => $array[$i]["latitude"], "longitude" => $array[$i]["longitude"]));
		}

		return $arrayDist;
	}



}
?>
