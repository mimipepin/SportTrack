<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once ('controllers/ApplicationController.php');

$controller = ApplicationController::getInstance()->getController($_REQUEST);
if($controller != null){
      echo $controller
      include "controllers/$controller.php";
      (new $controller())->handle($_REQUEST);
}

$view = ApplicationController::getInstance()->getView($_REQUEST);
if($view != null){
      echo $view;
      include __DIR__."/views/$view.php";
}

?>
