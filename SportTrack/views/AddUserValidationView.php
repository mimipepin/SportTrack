<!DOCTYPE html>
<html lang="fr">
<head>
      <meta charset="utf-8">
      <title>Inscription validée !</title>
      <link rel="stylesheet" href="./views/style.css" type="text/css">
</head>
<body>
      <?php

      if (isset($_SESSION['user']) && $_SESSION['user'] == true) {
            echo "Bienvenue, " . $_SESSION['surname'] . "!";
      } else {
            echo "Veuillez vous connecter pour accéder à cette page";
      }
      ?>
</body>
</html>
