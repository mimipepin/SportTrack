<?php
require('Controller.php');
require __DIR__."/../model/Compte.php";
require __DIR__."/../model/CompteDAO.php";

class MainController implements Controller{

    public function handle($request){
            
            
		if (isset($_SESSION['user'])){
                  /*
			$email = $_SESSION['email_addr'];
			$password = $_SESSION['password'];
			$user = CompteDAO::getInstance()->findUser($email, $password);
                  #var_dump($user);
                  /*
			if ($user != null){
				$_SESSION['user'] = $user;
				$_SESSION['name'] = $user->getPrenom();
			}*/
		}
            else {
                  echo "pas d'utilisateur enregistré pour cette session";
            }
	}
 }
?>
