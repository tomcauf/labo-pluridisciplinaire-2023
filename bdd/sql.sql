CREATE TABLE `Utilisateur` (
  `id_utilisateur` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `prenom` varchar(150) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `manager` int(11),
  `actif` bool NOT NULL
);

CREATE TABLE `Fonction_Utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_fonction` int(11) NOT NULL
);

CREATE TABLE `Fonction` (
  `id_fonction` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL
);

CREATE TABLE `Formation` (
  `id_formation` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `duree` time NOT NULL,
  `date_limite` date NOT NULL,
  `confirmation` bool NOT NULL,
  `actif` bool NOT NULL,
  `date_certificat_limite` date NOT NULL,
  `id_requis` int(11)
);

CREATE TABLE `Formateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL
);

CREATE TABLE `Fonction_Formation` (
  `id_formation` int(11) NOT NULL,
  `id_fonction` int(11) NOT NULL
);

CREATE TABLE `Participe` (
  `id_participe` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `statut` SET("EN ATTENTE", "EN FORMATION","FORMATION TERMINEE","DEPOT FAIT", "VALIDEE") NOT NULL,
  `lien_fichier` varchar(500)
);

CREATE TABLE `Requete` (
  `id_requete` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `type_of_validation` SET("ACCES FORMATION", "VALIDATION FORMATION"),
  `id_valideur` int(11) NOT NULL,
  `date_of_validation` date NOT NULL
);

ALTER TABLE `Utilisateur` ADD FOREIGN KEY (`manager`) REFERENCES `Utilisateur` (`id_utilisateur`);

ALTER TABLE `Fonction_Utilisateur` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id_utilisateur`);

ALTER TABLE `Formateur` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id_utilisateur`);

ALTER TABLE `Fonction_Utilisateur` ADD FOREIGN KEY (`id_fonction`) REFERENCES `Fonction` (`id_fonction`);

ALTER TABLE `Fonction_Formation` ADD FOREIGN KEY (`id_fonction`) REFERENCES `Fonction` (`id_fonction`);

ALTER TABLE `Fonction_Formation` ADD FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

ALTER TABLE `Formateur` ADD FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

ALTER TABLE `Participe` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id_utilisateur`);

ALTER TABLE `Requete` ADD FOREIGN KEY (`id_valideur`) REFERENCES `Utilisateur` (`id_utilisateur`);

ALTER TABLE `Requete` ADD FOREIGN KEY (`id_requete`) REFERENCES `Participe` (`id_participe`);

ALTER TABLE `Formation` ADD FOREIGN KEY (`id_requis`) REFERENCES `Formation` (`id_formation`);

ALTER TABLE `Participe` ADD FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);
