# Installation du projet

## Pré-requis
Nous avons utiliser le serveur dartagnan fournis par l'école. Voici la configuration de celui-ci :
* [PHP](http://php.net/) 5.6.40
* [MySQL](https://www.mysql.com/fr/) 5.7.29


## Etapes de déploiement

* Télécharger le projet sur le serveur web
* Créer une base de données MySQL
* Importer le fichier [`sql.sql`](https://github.com/tomcauf/labo-pluridisciplinaire-2023/blob/main/bdd/sql.sql) dans la base de données qui se trouve dans le dossier `bdd`
* Modifier le fichier [`DbConfig.inc.php`](https://github.com/tomcauf/labo-pluridisciplinaire-2023/blob/main/libs/repository/DbConfig.inc.php) avec les informations de la base de données qui se trouve dans le dossier `libs/repository`

## Fonctionnalités et bugs connus
```
[🟩] = Fonctionnalité implémentée
[🟨] = Fonctionnalité en cours d'implémentation (méthode ou interface déjà pris en compte mais pas complet)
[🟥] = Fonctionnalité non implémentée
```
* [🟨] Gestion Utilisateur
  * [🟩] Ajouter des utilisateurs
  * [🟨] La modification des utilisateurs
  * [🟨] Archivage des utilisateurs. Préserver l'utilisateur et ses données tout en le désactivant de l'application.
  * [🟩] Gestion des fonctions possibles pour les utilisateurs Un utilisateur présente les caractéristiques

* [🟩] Authentification
    * [🟩] L'authentification des utilisateurs
    * [🟩] La gestion des sessions
* [🟨] Catalogue des formations disponibles
  * [🟩] Ajouter des formations
  * [🟨] La modification de la formation
  * [🟨] L'archivage des formations
  * [🟩] La gestion des formations en relation avec les fonctions des utilisateurs
  * [🟩] Une formation présente les caractéristiques suivantes :
    * Nom (ou nom d'affichage)
    * Durée en heures
    * Formateur(s) désigné(s) (à partir de la liste des utilisateurs présents dans l'application ou formateur externe). 
    * Durée de validité
    * La ou les fonctions auxquelles la formation est destinée.
    * Si aucune fonction n'est définie, la formation s'adresse à tous.

* [🟨] Demande et approbation de formation complémentaire
   * [🟨] L'utilisateur doit pouvoir demander une formation disponible dans le catalogue des formations et correspondant à son rôle.
    * [🟨] La demande doit être approuvée par un responsable de formation ou son supérieur hiérarchique. 
    * [🟥] L'application doit garder une trace de l'approbation (qui et quand).
* [🟨] Confirmation de l'achèvement de la formation
   * [🟥] L'utilisateur doit pouvoir confirmer qu'il a suivi une formation qui lui a été attribuée et joindre un justificatif (diplôme, feuille de présence, certificat... en PDF ou en image scannée).
   * [🟩] Il sera donc comptabilisé dans son parcours personnel.
   * [🟥] Un responsable de formation ou un gestionnaire peut confirmer le suivi au nom d'un autre utilisateur.

* [🟩] Accréditation
  * [🟩] Une accréditation est un ensemble de formations à suivre pour être autorisé à effectuer une tâche spécifique.
  * [🟩] La demande doit donc prendre en compte
    * La gestion des accréditations
    * Le lien entre les formations et les accréditations qui en découlent
    * Obtenir l'accréditation une fois les conditions remplies (formation terminée/expirée)
* [🟨] Tableau de bord
  * [🟨] L'application doit comporter un tableau de bord permettant d'afficher les données suivantes :
    * Les cours de formation à réaliser, à planifier ou à achever (y compris les preuves documentaires)
    * Résumé des formations suivies (nombre de formations et nombre d'heures), par période, année, etc.
    * État d'avancement de la formation avec le temps restant à courir.
    * Accréditations éventuellement obtenues.
    * Cours de formation obtenus qui expireront bientôt.
    * ...
* [🟨] Parcours de formation
    * [🟩] Le parcours de formation est la liste des formations qu'un utilisateur doit suivre en fonction de sa (ses) fonction(s).
    * [🟩] L'utilisateur doit suivre chaque cours de formation dans un délai défini à partir de la date d'entrée de l'employé.
    * [🟨] Le système doit également tenir compte du fait que l'utilisateur peut changer de fonction au cours de son parcours de formation.
* [🟨] Directeur (rôle " N+1 ")
    * [🟨] Consiste à définir une personne comme étant le supérieur hiérarchique d'un utilisateur. Cette personne est autorisée à
        * Consulter les formations suivies par son N-1
        * Imposer une formation (donc pré-approuvée) du catalogue
        * Accepter ou rejeter une demande d'approbation
* [🟨] Expiration de la validité et récurrence de certaines formations
    * [🟩] Certaines formations ont une validité limitée dans le temps, l'application doit permettre de la définir pour chaque formation et de la rendre applicable.
    * [🟥] L'application doit également émettre des rappels lorsqu'une validité est sur le point d'expirer pour un utilisateur donné.
* [🟨] Système de notification
    * [🟨] Tenir l'utilisateur informé des actions en cours.
    * [🟨] Les moyens à mettre en œuvre sont laissés à la discrétion du développeur.
    * [🟩] Envoi de mail
    * [🟥] Notification sur le tableau de bord
* [🟩] Dépendance entre les formations/Concept de pré-requis
    * [🟩] Permettre au responsable de la formation de définir des dépendances entre les cours, par exemple "de base" et "avancés".
    * [🟩] Rendre cet élément définissable dans le catalogue de formation, et renforcer ces dépendances lors des demandes de formation afin d'éviter une demande de formation "avancée" avant d'avoir suivi la formation "de base".
* [🟩] Calendrier et planification de la formation
    * [🟩] L'application doit permettre au responsable de la formation de définir une session de formation sur la base du catalogue. Une session de formation doit comprendre
        *  Le nom du cours
        * Dates, heures et lieu
        * Une liste de participants
* [🟥] Gestion multi-langues
    * [🟥] L'interface de l'application doit pouvoir fonctionner en plusieurs langues. Proposez l'anglais comme langue de base et une deuxième langue de votre choix (il n'est pas nécessaire de tout traduire dans la deuxième langue).
* [🟥] Pistes d'audit
    * [🟥] Enregistrer toutes les actions de l'utilisateur avec au moins les informations suivantes :
        * Quand : date/heure
        * Qui : quel utilisateur
        * Quoi : quelle action
    * [🟥] Permettre l'affichage et la recherche par utilisateur, par date, etc.
* [🟩] Système générique d'application de la charte graphique de l'entreprise
    * [🟩] Permet de modifier et d'appliquer facilement une identité d'entreprise (logo, couleurs, polices...).
    * ⚠️ INFO:
        * Pour le logo : reprendre le même nom ou changer dans le [header](https://github.com/tomcauf/labo-pluridisciplinaire-2023/blob/main/html/inc/header.inc.php)
        * Pour les couleurs / polices : Tout peux être modifié dans le [style.css](https://github.com/tomcauf/labo-pluridisciplinaire-2023/blob/main/css/style.css)

## Test de la solution sur un environnement de production : 
### ⚠️ Accès VPN de l'HELMo (réseau de l'HELMo) nécessaire pour accéder à l'application ⚠️
* [Lien :  http://192.168.128.13/~q210104/pluri/labo-pluridisciplinaire-2023/index.php](http://192.168.128.13/~q210104/pluri/labo-pluridisciplinaire-2023/index.php)
* Compte : 
    * Email : alexis.alexis@gmail.com
    * Mot de passe : password
    
## Proposé par :
[Tom Caufrier](https://www.linkedin.com/in/tom-caufrier/)

[Valentin Lopez Lopez](https://www.linkedin.com/in/valentin-lopez-lopez-93333b236/)

[Alexis Vanden Broeck](https://www.linkedin.com/in/alexis-vanden-broeck-415889253/)

[Gillian Dechêne](https://www.linkedin.com/in/gillian-dech%C3%AAne-b72341236/)