<?php
require('Controller.php');
require('./model/Compte.php');
require('./model/CompteDAO.php');

class AddUserController implements Controller {
      public function handle($request) {
            try {

                  $compte = new Compte();
                  $compte->init(
                  $request['email_addr'],
                  $request['name'],
                  $request['surname'],
                  $request['birthdate'],
                  $request['sex'],
                  $request['weight'],
                  $request['height'],
                  $request['password']);
                  $DAO = CompteDAO::getInstance();
                  if (null !== $DAO->findUser($request['email_addr'], $request['password'])){
					  echo('L adresse email est deja utilisee, veuillez en utiliser une nouvelle');
				  } else {
					  $DAO->insert($compte);
					  session_start();
					  $_SESSION['user'] = $compte;
				  }

				  $DAO->insert($compte);
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

 ?>
