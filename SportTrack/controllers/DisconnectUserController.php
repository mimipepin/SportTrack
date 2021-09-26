<?php
require('Controller.php');
require __DIR__."/../model/Compte.php";
require __DIR__."/../model/CompteDAO.php";

class DisconnectUserController implements Controller {
      public function handle($request) {

            try {
                  #if (isset ($_SESSION['user'])){
                        echo "saluuuut les boyzzz";
                        //$_SESSION = array();//Ecrase tableau de session
                        session_start();
                        session_unset(); //Detruit toutes les variables de la session en cours
                        session_destroy();//Detruit la session en cours
                        //header("location:index.php?page=/"); // redirige l'utilisateur
                  #}
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

?>
