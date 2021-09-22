<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
  <title>Formulaire de connexion</title>
  <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>

    <h1> Création de compte SportTrack </h1>

	<form action="http://m3104.iut-info-vannes.net/m3104_33/index.php?page=user_add" method="POST">
	
    <p> Nom :
    <input type="text" id="name" name="name" required />
    </p>

    <p> Prénom :
    <input type="text" id="surname" name="surname" required />
    </p>

    <p> Date de naissance :
    <input type="date" id="birthdate" name="birthdate"  min="1900-01-01" max="2005-01-01" required />
    </p>

    <p> Sexe :
      <select type="select" id="sex" name="sex" required >
        <option>FEMME</option>
        <option>HOMME</option>
        <option>AUTRE</option>
      </select> 
    </p>

    <p> Taille (en centimètres) :
      <input type="number" id="height" name ="height" max="250" min ="100" required>
    </p>
    

    <p> Poids (en kilogrammes) :
      <input type="number" id="weight" name="weight" max="200" min="30" required>
    </p>

    <p> Veuillez entrer votre email ici : 
    <input type="email" id="email_addr" name="email_addr" required />
    </p>

    <p> Mot de passe :
      Le mot de passe doit contenir une majuscule, une minuscule, un chiffre, et un caractère spécial (&é@_) :
      <input type="pattern" id="password" name="password" pattern= "(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[&,é,@,_]).{8,15}">
    </p>

    <p> <input type=submit value="Confirmer la saisie et envoyer le formulaire"> </p>
	
	
	</form>	

  </body>
</html> 
