<?php
require('Controller.php');
require __DIR__."/../model/Compte.php";
require __DIR__."/../model/CompteDAO.php";

class DisconnectUserController implements Controller {
      public function handle($request) {

            try {
                  if (isset ($_SESSION['user'])){
                       session_destroy();//Detruit la session en cours
                       
                  }
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

?>
