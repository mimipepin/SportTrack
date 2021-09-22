<?php
require('Controller.php');
require('Compte.php')
require('CompteDAO.php')

class DisconnectUserController implements Controller {
      public function handle($request) {
            try {
				if (isset $_SESSION['user']){
					$_SESSION = array();//Ecrase tableau de session 
					session_unset(); //Detruit toutes les variables de la session en cours
					session_destroy();//Detruit la session en cours
					header("location:index.php"); // redirige l'utilisateur
				}
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

 ?>
