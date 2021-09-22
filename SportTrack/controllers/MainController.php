<?php
require('Controller.php');

class MainController implements Controller{

    public function handle($request){
		if (isset($_SESSION['user'])){
			$email = $request['email_addr'];
			$password = $request['password'];
			$user = CompteDAO::getInstance()->findUser($email, $password);
			if (isset($user)){
				$_SESSION['user'] = $user;
				$_SESSION['name'] = $user->getPrenom();
			}
		}	
	}
 }
?>
