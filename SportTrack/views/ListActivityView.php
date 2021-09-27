<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Vos informations</title>
  <link rel="stylesheet" href="./views/style.css" type="text/css">
  <!--
  <script src="script.js"></script> -->
</head>
<body>
	
		
		<?php
			
			if (isset($_SESSION['user'])&& $_SESSION['user'] == true) {
			echo"<h1>Vos informations</h1>
	<table>
		<tr>
			<td>Description</td>
			<td>'description'</td>
		</tr>
		<tr>
			<td>Heure de début</td>
			<td>'Heure debut activite'</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>'Date'</td>
		</tr>
		<tr>
			<td>Durée</td>
			<td>'Durée'</td>
		</tr>
		<tr>
			<td>Distance</td>
			<td>'Distance'</td>
		</tr>
		<tr>
			<td>Frequence moyenne</td>
			<td>'freq moyenne'</td>
		</tr>
		<tr>
			<td>Frequence minimale</td>
			<td>'freq minimale'</td>
		</tr>
		<tr>
			<td>Frequence maximale</td>
			<td>'freq maximale'</td>
		</tr>
	</table> ";
			echo "<input type=button value='Revenir à la page principale' onclick=\"window.location.href = 'index.php?page=/'\">";
			echo "<input type=button value='Ajouter des activités' onclick=\"window.location.href = 'index.php?page=list_activities'\">";
			} else {
				echo "Veuillez vous connecter pour accéder à cette page";
			}
		?>
		
	<!-- Go plutot mettre ça dans l'autre sens -->
</body>
</html>
