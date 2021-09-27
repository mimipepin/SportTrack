<?php
require('Controller.php');
require __DIR__."/../model/Compte.php";
require __DIR__."/../model/CompteDAO.php";

class AddUserController implements Controller {
      public function handle($request) {
            try {
                  //var_dump($request);

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
                  #if (null !== $DAO->findUser($request['email_addr'], $request['password'])){
                  if ($DAO->findUser($request['email_addr'], $request['password']) == null) {
                        $DAO->insert($compte);
                        $_SESSION['email_addr'] = $compte->getMail();
                        $_SESSION['user'] = $compte;
                        $_SESSION['name'] = $compte->getNom();
                        $_SESSION['surname'] = $compte->getPrenom();
                        $_SESSION['birthdate'] = $compte->getDateNaissance();
                        $_SESSION['sex'] = $compte->getSexe();
                        $_SESSION['weight'] = $compte->getPoids();
                        $_SESSION['height'] = $compte->getTaille();
                        $_SESSION['password'] = $compte->getMdp();
      		  } else {
      			 echo('L adresse email est deja utilisee, veuillez en utiliser une nouvelle');
      		  }

				  #$DAO->insert($compte);
            }
            catch(Exception $e){
                  print_r($e);
            }


      }
}

 ?>
