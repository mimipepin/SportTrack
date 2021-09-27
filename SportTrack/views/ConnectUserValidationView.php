<!DOCTYPE html>
<html lang="fr">
<head>
      <meta charset="utf-8">
      <title>Connection validée !</title>
      <link rel="stylesheet" href="./views/style.css" type="text/css">
</head>
<body>
      <?php

      if (isset($_SESSION['user']) && $_SESSION['user'] == true) {
            echo "Bienvenue, " . $_SESSION['surname'] . "!";
            echo "<br />";
            echo "<input type=button value='Revenir à la page principale' onclick=\"window.location.href = 'index.php?page=/'\">";
            echo "<br />";
            echo "<input type=button value='Voir les activités' onclick=\"window.location.href = 'index.php?page=list_activities'\">";
      } else {
            echo "Veuillez vous connecter pour accéder à cette page";
      }
      ?>
</body>
</html>
