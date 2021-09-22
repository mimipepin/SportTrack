<!doctype html>
<html lang="fr">
      <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style.css" type="text/css">
      </head>
      <body>

		<?php
			session_start();
			if (isset($_SESSION['user'])){
				echo "Bienvenue, " . $_SESSION['name'] . "!";
			} else {
				echo "Veuillez vous connecter pour accéder à cette page";
			}
			?>
		<input type=button value="Creer un compte" onclick="window.location.href = 'http://m3104.iut-info-vannes.net/m3104_33/index.php?page=user_add_form'">
		<input type=button value="Se connecter" onclick="window.location.href = 'http://m3104.iut-info-vannes.net/m3104_33/index.php?page=user_connect_form'">
		
      </body>
      </html>
