<!doctype html>
<html lang="fr">
      <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="./views/style.css" type="text/css">
      </head>
      <body>

		<?php
                  
			if (isset($_SESSION['user'])){
				echo "Bienvenue, " . $_SESSION['surname'] . "!";
				echo "<br />";
                echo "<input type=button value='Se déconnecter' onclick=\"window.location.href = 'index.php?page=user_disconnect'\">";
                
			} else {
				echo "Veuillez vous connecter pour accéder à cette page";
				echo "<br />";
				echo "<input type=button value='Se connecter' onclick=\"window.location.href = 'index.php?page=user_connect_form'\">";
				echo "<br />";
				echo "<input type=button value='Créer un compte' onclick=\"window.location.href = 'index.php?page=user_add_form'\">";
                        
                        
			}
			?>
	      <!--<input type=button value="Creer un compte" onclick="window.location.href = 'http://m3104.iut-info-vannes.net/m3104_33/index.php?page=user_add_form'">
		<input type=button value="Se connecter" onclick="window.location.href = 'http://m3104.iut-info-vannes.net/m3104_33/index.php?page=user_connect_form'">
            <input type=button value="Creer un compte" onclick="window.location.href = ".dirname(__FILE__). "/../index.php?page=user_add_form"> -->


      </body>
      </html>
