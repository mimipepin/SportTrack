<!doctype html>
<html lang="fr">
<head>
      <meta charset="utf-8">
      <title>Connexion</title>
</head>
<body>
      <?php

      require_once "SqliteConnection.php";
      require_once "Compte.php";
      require_once "CompteDAO.php";
      require_once "Activite.php";
      require_once "ActiviteDAO.php";
      require_once "Donnees.php";
      require_once "DonneesDAO.php";
      $SqlCon = SqliteConnection::getInstance();
      $connection = $SqlCon->getConnection();

      //On supprime tout
      $suppr = "delete from Compte";
      $stmt = $connection->prepare($suppr);
      $stmt->execute();
      $suppr = "delete from Activite";
      $stmt = $connection->prepare($suppr);
      $stmt->execute();
      $suppr = "delete from Donnees";
      $stmt = $connection->prepare($suppr);
      $stmt->execute();

      echo "\n********************************\ntest de Compte et CompteDAO\n********************************\n\n";
      $compteDao = CompteDAO::getInstance();

      $JeanMi = new Compte();
      $JeanMi->init("JeanMi@kaz.bzh","Jean-Michel", "Aphatie", "1958-09-08", "HOMME", 80, 150, "mdp");

      $Alois = new Compte();
      $Alois->init("AloeVera@kaz.bzh","Aloe", "Vera", "2000-12-25", "FEMME", 60, 130, "mdp");
      #echo $compte->__toString();
      $compteDao->insert($JeanMi);
      $compteDao->insert($Alois);

      $query = $connection->query('SELECT * from Compte');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On change le mot de passe de Jean-Michel\n";
      $JeanMi->init("JeanMi@kaz.bzh","Jean-Michel", "Aphatie", "1958-09-08", "HOMME", 80, 150, "mdpSuperGenial");
      $compteDao->update($JeanMi);

      //$ret = $compteDao->findAll();
      //var_dump($ret);

      $query = $connection->query('SELECT * from Compte');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On supprime Jeam-Michel :(\n";
      $compteDao->delete($JeanMi);

      $query = $connection->query('SELECT * from Compte');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      var_dump($compteDao->findUser("AloeVera@kaz.bzh", "mdp"));

      echo "\n********************************\ntest de Activite et ActiviteDAO\n********************************\n\n";
      $activiteDao = ActiviteDAO::getInstance();

      $marche = new Activite();
      $marche->init(0, "15:35:02", "17:20:15", "2021-09-18", "Balade au parc", NULL, NULL, NULL, NULL, NULL, "JeanMi@kaz.bzh");

      $velo = new Activite();
      $velo->init(1, "08:05:58", "10:25:10", "2021-07-08", "Velo dans la street", NULL, NULL, NULL, NULL, NULL, "JeanMi@kaz.bzh");

      $activiteDao->insert($marche);
      $activiteDao->insert($velo);

      $query = $connection->query('SELECT * from Activite');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On change la description\n";
      $marche->init(0, "15:35:02", "17:20:15", "2021-09-18", "Sieste au parc", NULL, NULL, NULL, NULL, NULL, "JeanMi@kaz.bzh");
      $activiteDao->update($marche);

      $query = $connection->query('SELECT * from Activite');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On supprime l'activité de Jean-Michel\n";
      $activiteDao->delete($marche);


      $query = $connection->query('SELECT * from Activite');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);

      }


      var_dump($activiteDao->findActivities($Alois)); //erreur de typage ??


      echo "\n********************************\ntest de Donnees et DonneesDAO\n********************************\n\n";
      $donneesDao = DonneesDAO::getInstance();

      $marcheD1 = new Donnees();
      $marcheD1->init(0, "15:35:02", 100, -80, 1000, 80, 1);
      $donneesDao->insert($marcheD1);
      $marcheD2 = new Donnees();
      $marcheD2->init(1, "16:25:40", 101, -61, 1200, 86, 1);
      $donneesDao->insert($marcheD2);
      $marcheD3 = new Donnees();
      $marcheD3->init(2, "17:13:20", 110, -20, 1250, 100, 1);
      $donneesDao->insert($marcheD3);

      $query = $connection->query('SELECT * from Donnees');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "Les données sont bien ajoutées à l'activité grâce aux triggers\n";
      $query = $connection->query('SELECT * from Activite');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On change l'altitude de la première donnée\n";

      $marcheD1->init(0, "15:35:02", 100, -80, 2000, 80, 1);
      $donneesDao->update($marcheD1);

      $query = $connection->query('SELECT * from Donnees');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      echo "On supprime la deuxième donnée\n";
      $donneesDao->delete($marcheD2);

      $query = $connection->query('SELECT * from Donnees');
      while ($row = $query->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
      }

      var_dump($donneesDao->findDonnees($velo));





      //test pour le controller d'ajout d'utilisateur


      $user = $compteDao->findUser("AloeVera@kaz.bzh", "mdp");
      var_dump($user);
      echo isset($user);


      //echo isset($compteDao->findUser("AloeVera@kaz.bzh", "mdpxec"));

      /*
      $users = $compteDao->findAll();
      $trouve = 0;
      $i = 0;
      while (trouve == 0 && $i < count($users)) {
            if ($trouve[$i]['mail'] == "AloeVera@kaz.bzh") {
                  $trouve = 1;
            }
            else {
                  $i++;
            }
      }

      echo $trouve;
      */

      ?>
</body>
</html>
