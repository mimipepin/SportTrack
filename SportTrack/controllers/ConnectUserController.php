<?php
require('Controller.php');
require('../model/Compte.php');
require('../model/CompteDAO.php');

class ConnectUserController implements Controller {
      public function handle($request) {
            try {
                 $_SESSION['user'] = CompteDAO::getInstance()->findUser($request['email_addr'], $request['password_addr']);
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

 ?>
