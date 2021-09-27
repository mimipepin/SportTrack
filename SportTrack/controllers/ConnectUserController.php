<?php
require('Controller.php');
require __DIR__."/../model/Compte.php";
require __DIR__."/../model/CompteDAO.php";

class ConnectUserController implements Controller {
      public function handle($request) {
            try {
				 
                 $_SESSION['user'] = CompteDAO::getInstance()->findUser($request['email_addr'], $request['password']);
                 
                 $_SESSION['email_addr'] = $_SESSION['user']->getMail();
                 $_SESSION['name'] = $_SESSION['user']->getNom();
                 $_SESSION['surname'] = $_SESSION['user']->getPrenom();
                 $_SESSION['birthdate'] = $_SESSION['user']->getDateNaissance();
                 $_SESSION['sex'] = $_SESSION['user']->getSexe();
                 $_SESSION['weight'] = $_SESSION['user']->getPoids();
                 $_SESSION['height'] = $_SESSION['user']->getTaille();
                 $_SESSION['password'] = $_SESSION['user']->getMdp();
                 
                 
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

 ?>
 
