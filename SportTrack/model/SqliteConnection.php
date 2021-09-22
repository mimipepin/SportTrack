<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
class SqliteConnection {
      private static $instance;


      private function __construct() {
      }

      public final static function getInstance() {
            if(!isset(self::$instance)) {
                  self::$instance= new SqliteConnection();
            }
            return self::$instance;
      }

      /**
      * Get the connection
      */
      public function getConnection(){
            try {
                  $connection = new PDO ("sqlite:".dirname(__FILE__)."/SportTrack.db");
                  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  return $connection;


                  // #$connection = null;
            } catch (PDOException $e) {
                  print "Erreur !: " . $e->getMessage() . "<br/>";
                  die();
            }
      }
}

?>
