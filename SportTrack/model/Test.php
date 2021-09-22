<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8">
		<title>Test</title>
	</head>

	<body>

		<?php
			require_once "CalculDistanceImpl.php";
			$c = new CalculDistanceImpl();
			#echo($c->calculDistance2PointsGPS(47.64479524,-2.776605,20.5,24));

			$json =
			'[{"time":"13:00:00","cardio_frequency":99,"latitude":47.644795,"longitude":-2.776605,"altitude":18},
			{"time":"13:00:05","cardio_frequency":100,"latitude":47.646870,"longitude":-2.778911,"altitude":18},
			{"time":"13:00:10","cardio_frequency":102,"latitude":47.646197,"longitude":-2.780220,"altitude":18},
			{"time":"13:00:15","cardio_frequency":100,"latitude":47.646992,"longitude":-2.781068,"altitude":17},
			{"time":"13:00:20","cardio_frequency":98,"latitude":47.647867,"longitude":-2.781744,"altitude":16},
			{"time":"13:00:25","cardio_frequency":103,"latitude":47.648510,"longitude":-2.780145,"altitude":16}]';
			$array=json_decode($json, true);
			#var_dump($array);


			echo $c->calculDistanceTrajet($array);

		?>

	</body>

</html>
