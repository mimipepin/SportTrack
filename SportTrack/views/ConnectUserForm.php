<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="./views/style.css" type="text/css">
</head>
<body>
	<h1>Page de connexion</h1>
	<form action="index.php?page=user_connect" method="POST">
		<p>
		<label for="email">Email</label>
		<input type="email" id="email_addr" name="email_addr" required> </br>
		</p>
		
		<p>
		<label for="password">Mot de passe</label>
		<input type="password" id="password" name="password" required> </br>
		</p>
		
		<input type=submit value="Connexion">
	</form>
</body>
</html>
