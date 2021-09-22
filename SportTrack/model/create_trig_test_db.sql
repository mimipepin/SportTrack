/*
Schéma relationnel
Compte (mail (1), nom (NN), prenom (NN), dateNaissance (NN), sexe (NN), poids (NN), taille (NN), mdp (NN))

Activite (idActivite (1), heureDebut (NN), heureFin (NN), date (NN), description, /duree, /distanceParcourue, /freqMin, /frqMax, /freqMoy, unCompte = @Compte.mail (NN))

Donnees (idDonnees (1), temps, latitude, longitude, altitude, frequCardiaque, uneActivite = @Activite.idActivite (NN))
*/


------------------------------------
-- Création de la base de données --
------------------------------------

DROP TABLE Donnees;
DROP TABLE Activite;
DROP TABLE Compte;


CREATE TABLE IF NOT EXISTS Compte (
	mail TEXT PRIMARY KEY
		CONSTRAINT ck_mail CHECK (mail LIKE '%_@__%._%')
		CONSTRAINT nn_mail NOT NULL,
	nom TEXT
		CONSTRAINT nn_nom NOT NULL
		CONSTRAINT ck_nom CHECK (nom LIKE '%_'),
	prenom TEXT
		CONSTRAINT nn_prenom NOT NULL
		CONSTRAINT ck_prenom CHECK (prenom LIKE '%_'),
	dateNaissance TEXT
		CONSTRAINT ck_dateNaissance CHECK (dateNaissance LIKE ('____-__-__')) -- Pour le moment on peut mettre une date qui est superieure à la date actuelle mais ce sera ajouté
		CONSTRAINT nn_dateNaissance NOT NULL,
	sexe TEXT
		CONSTRAINT ck_sexe CHECK (sexe = 'HOMME' OR sexe = 'FEMME' OR sexe = 'AUTRE')
		CONSTRAINT nn_sexe NOT NULL,
	poids INTEGER
		CONSTRAINT ck_poids CHECK (poids > 30 AND poids < 200)
		CONSTRAINT nn_poids NOT NULL,
	taille INTEGER
		CONSTRAINT ck_taille CHECK (taille > 100 AND taille < 250)
		CONSTRAINT nn_taille NOT NULL,
	mdp TEXT
		CONSTRAINT ck_mdp CHECK (mdp LIKE '%_')
		CONSTRAINT nn_mdp NOT NULL
);

CREATE TABLE IF NOT EXISTS Activite (
	idActivite INT PRIMARY KEY
		CONSTRAINT ck_idActivite CHECK (idActivite LIKE '%_')
		CONSTRAINT nn_idActivite NOT NULL,
	heureDebut TEXT
		CONSTRAINT nn_heureDebut NOT NULL
		CONSTRAINT ck_heureDebutFormat CHECK (heureDebut LIKE '__:__:__'),
	heureFin TEXT
		CONSTRAINT nn_heureFin NOT NULL
		CONSTRAINT ck_heureFinFormat CHECK (heureFin LIKE '__:__:__'),
	date TEXT
		CONSTRAINT nn_date NOT NULL
		CONSTRAINT ck_date CHECK (date LIKE ('____-__-__')),
	description TEXT
		CONSTRAINT ck_description CHECK (description LIKE ('%_')),
	duree TIME
		CONSTRAINT ck_duree CHECK (duree LIKE '__:__:__'),
	distanceParcourue REAL
		CONSTRAINT ck_distanceParcourue CHECK (distanceParcourue LIKE ('%_')),
	freqMin INTEGER
		CONSTRAINT ck_freqMin CHECK (freqMin < 230 AND freqMin > 60),
	freqMax INTEGER
		CONSTRAINT ck_freqMax CHECK (freqMax < 230 AND freqMax > 60),
	freqMoy INTEGER
		CONSTRAINT ck_freqMoy CHECK (freqMoy < 230 AND freqMoy > 60),
	unCompte TEXT
		CONSTRAINT fk_Activite_Compte REFERENCES Compte(mail)
);

CREATE TABLE IF NOT EXISTS Donnees (
	idDonnees INT PRIMARY KEY
		CONSTRAINT ck_idDonnees CHECK (idDonnees LIKE '%_')
		CONSTRAINT nn_idDonnees NOT NULL,
	temps TIME
		CONSTRAINT nn_temps NOT NULL
		CONSTRAINT ck_temps CHECK (temps LIKE ('__:__:__')),
	latitude REAL
		CONSTRAINT ck_latitude CHECK (latitude < 180 AND latitude > -180)
		CONSTRAINT nn_latitude NOT NULL,
	longitude REAL
		CONSTRAINT ck_longitude CHECK (longitude < 180 AND longitude > -180)
		CONSTRAINT nn_longitude NOT NULL,
	altitude INTEGER
		CONSTRAINT ck_altitude CHECK (altitude < 9000 AND altitude > -1000)
		CONSTRAINT nn_altitude NOT NULL,
	freqCardiaque INTEGER
		CONSTRAINT ck_freqCardiaque CHECK (freqCardiaque < 230 AND freqCardiaque > 60)
		CONSTRAINT nn_freqCardiaque NOT NULL,
	uneActivite INTEGER
		CONSTRAINT fk_Donnees_Activite REFERENCES Activite(idActivite)
		CONSTRAINT nn_uneActivite NOT NULL
		--CONSTRAINT uq_uneActivite UNIQUE
);


--------------------------------------------------
-- Triggers de calcul des données des activités --
--------------------------------------------------

--------------------------------------------------------------------------
-- freqMin correspond à la valeur de fréquence cardiaque la plus petite --
-- calculée parmi les Donnees associées à la table Activité             --
--------------------------------------------------------------------------

CREATE TRIGGER IF NOT EXISTS trig_freqMinMaxMoy AFTER INSERT ON Donnees
BEGIN
	UPDATE Activite SET freqMin = (SELECT MIN(freqCardiaque)
						FROM Donnees
						WHERE idActivite = uneActivite)
			WHERE idActivite = new.uneActivite;
	UPDATE Activite SET freqMax = (SELECT MAX(freqCardiaque)
						FROM Donnees
						WHERE idActivite = uneActivite)
			WHERE idActivite = new.uneActivite;
	UPDATE Activite SET freqMoy = (SELECT ROUND(AVG(freqCardiaque), 2) -- On arrondit la frequence moyenne
						FROM Donnees
						WHERE idActivite = uneActivite)
			WHERE idActivite = new.uneActivite;
END;
/
--Pas très optimal, lors de l'insertion du premier tuple pour l'activité choisi il y aura trois fois la même valeur qui sera insérée, mais ce n'est pas très grave cela reste fonctionnel

-----------------------------------------------
-- duree est calculé par heureFin-heureDebut --
-----------------------------------------------

CREATE TRIGGER IF NOT EXISTS trig_duree AFTER INSERT ON Donnees
BEGIN
	UPDATE Activite SET duree = (SELECT TIME(CAST((strftime('%s', MAX(temps)) - strftime('%s', MIN(temps))) AS TIME), 'unixepoch') FROM Donnees WHERE idActivite = uneActivite);

END;
/
-- De même ici, si une activité est effectuée la nuit le calcul de durée ne sera pas bon


--------------------------------------------------
-- Script de vérification de la base de données --
--------------------------------------------------

DELETE FROM Donnees;
DELETE FROM Activite;
DELETE FROM Compte;

-----------------------------
-- Test de la table Compte --
-----------------------------

-- Comportement normal ------
INSERT INTO Compte VALUES('bidule@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '165', 'superMdp');
-----------------------------

-- Addresse mail déjà existente --
INSERT INTO Compte VALUES('bidule@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '165', 'superMdp');

-- Mauvaise adresse mail --
INSERT INTO Compte VALUES('machinmail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '165', 'superMdp');

-- Mauvaise date de naissance --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-0-08', 'FEMME', '75', '165', 'superMdp');

-- Mauvais sexe --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEME', '75', '165', 'superMdp');

-- Poids trop faible --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '20', '165', 'superMdp');

-- Poids trop élevé --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '250', '165', 'superMdp');

-- Taille trop élevée --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '300', 'superMdp');

-- Taille trop faible --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '', 'superMdp');

---

-- Mail non renseigné --
INSERT INTO Compte VALUES(NULL, 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '165', 'superMdp');

-- Nom non renseigné --
INSERT INTO Compte VALUES('machin@mail.com', NULL, 'Prenom', '2021-09-08', 'FEMME', '75', '165', 'superMdp');

-- Prenom non renseigné --
INSERT INTO Compte VALUES('machin@mail.com', 'nom', NULL, '2021-09-08', 'FEMME', '75', '165', 'superMdp');

-- Date non renseignée --
INSERT INTO Compte VALUES('machin@mail.com', 'nom', 'Prenom', NULL, 'FEMME', '75', '165', 'superMdp');

-- Sexe non renseigné --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', NULL, '75', '165', 'superMdp');

-- Poids non renseigné --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', NULL, '165', 'superMdp');

-- Taille non renseignée --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', NULL, 'superMdp');

-- Mot de passe non renseigné --
INSERT INTO Compte VALUES('machin@mail.com', 'Nom', 'Prenom', '2021-09-08', 'FEMME', '75', '165', NULL);


-------------------------------
-- Test de la table Activite --
-------------------------------

-- Comportement normal --
INSERT INTO Activite VALUES('0', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'bidule@mail.com');
-------------------------

-- Clef primaire déjà existente --
INSERT INTO Activite VALUES('0', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'bidule@mail.com');

-- Mauvaise heure de début --
INSERT INTO Activite VALUES('1', '15:0:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Mauvaise heure de fin --
INSERT INTO Activite VALUES('1', '15:02:00', '16:3', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Mauvaise date --
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-0', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Description vide --
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', '', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Mauvaise durée --
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '0:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Frequence cardiaque minimale trop élevée
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 250, 61, 61, 'machin@mail.com');

-- Frequence cardiaque minimale trop basse
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 20, 61, 61, 'machin@mail.com');

-- Frequence cardiaque maximale trop élevée
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 250, 61, 'machin@mail.com');

-- Frequence cardiaque maximale trop basse
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 20, 61, 'machin@mail.com');

-- Frequence cardiaque moyenne trop élevée
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 250, 'machin@mail.com');

-- Frequence cardiaque moyenne trop basse
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 20, 'machin@mail.com');

---

-- Clef primaire non renseignée
INSERT INTO Activite VALUES(NULL, '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Heure de début non renseignée
INSERT INTO Activite VALUES('1', NULL, '16:30:00', '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Heure de fin non renseignée
INSERT INTO Activite VALUES('1', '15:02:00', NULL, '2021-07-03', 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Date non renseignée
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', NULL, 'Balade au parc', '00:00:00', 14, 61, 61, 61, 'machin@mail.com');

-- Durée non renseignée
INSERT INTO Activite VALUES('1', '15:02:00', '16:30:00', '2021-07-03', 'Balade au parc', NULL, 14, 61, 61, 61, 'machin@mail.com');


-------------------------------
-- Test de la table Activite --
-------------------------------

-- Comportement normal --
INSERT INTO Donnees VALUES (0, '05:00:00', 47.1222, -2.25512, 18, 100, 0);
-------------------------

-- Clef primaire déjà existente --
INSERT INTO Donnees VALUES (0, '05:00:00', 47.1222, -2.25512, 18, 100, 0);

-- Mauvais temps --
INSERT INTO Donnees VALUES (1, '05:00:0', 47.1222, -2.25512, 18, 100, 0);

-- Latitude trop élevée --
INSERT INTO Donnees VALUES (1, '05:00:00', 200, -2.25512, 18, 100, 0);

-- Latitude trop faible --
INSERT INTO Donnees VALUES (1, '05:00:00', -200, -2.25512, 18, 100, 0);

-- Longitude trop élevée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, 200, 18, 100, 0);

-- Longitude trop faible --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -200, 18, 100, 0);

-- Altitude trop élevée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, 10000, 100, 0);

-- Altitude trop faible --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, -2000, 100, 0);

-- Frequence cardiaque trop élevée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, 18, 400, 0);

-- Frequence cardiaque trop faible --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, 18, 30, 0);

--

-- Clef primaire non renseignée --
INSERT INTO Donnees VALUES (NULL, '05:00:00', 47.1222, -2.25512, 18, 100, 1);

-- Temps non renseignée --
INSERT INTO Donnees VALUES (1, NULL, 47.1222, -2.25512, 18, 100, 0);

-- Latitude non renseignée --
INSERT INTO Donnees VALUES (1, '05:00:00', NULL, -2.25512, 18, 100, 0);

-- Latitude non renseignée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, NULL, 18, 100, 0);

-- Altitude non renseignée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, NULL, 100, 0);

-- Frequence cardiaque non renseignée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, 18, NULL, 0);

-- Clef étrangère non renseignée --
INSERT INTO Donnees VALUES (1, '05:00:00', 47.1222, -2.25512, 18, 100, NULL);


-----------------------------
-- valeurs bien insérées ? --
-----------------------------

--Compte
SELECT mail, nom, dateNaissance, sexe, poids, taille, mdp
FROM Compte
;

--Activite
SELECT idActivite, duree, distanceParcourue, freqMin, freqMax, freqMoy, unCompte
FROM Activite
;

--Données
SELECT idDonnees, temps, latitude, longitude, altitude,freqCardiaque, uneActivite
FROM Donnees
;


-------------------------------
-- Verification des triggers --
-------------------------------

INSERT INTO Donnees VALUES (1, '08:30:00', 90.33, -35.22, 40, 115, 0);
INSERT INTO Donnees VALUES (2, '10:00:00', 104.33, -50.22, 50, 120, 0);
--On verifie que duree = 05:00:00, distanceParcourue = ..., freqMin = 100, freqMax = 120 et freqmoy = 110

--Données
SELECT idDonnees, temps, latitude, longitude, altitude, freqCardiaque, uneActivite
FROM Donnees
WHERE idDonnees != 0
;

--Activite
SELECT idActivite, duree, distanceParcourue, freqMin, freqMax, freqMoy, unCompte
FROM Activite
;
