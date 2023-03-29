<?php
require_once "BdConnect.inc.php";
require_once "libs/models/User.php";

use models\User;

class BdUserRequest
{

    /**
     * request to get all users on the database
     * @return array of all users
     */
    static function getAllUser()
    {
        $errorMessage = "";
        $link = BdConnect::connect2db($errorMessage);
        $query = $link->prepare("SELECT * FROM Utilisateur");
        if($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            BdConnect::disconnect($link);
            $result = array_map(function($user) {
                $user['mot_de_passe'] = null;
                return new User($user['id_utilisateur'],
                    $user['prenom'],
                    $user['nom'],
                    $user['email'],
                    $user['actif'],
                    $user['manager']);
            }, $result);
            return $result;
        }
        else {
            return false;
        }

        BdConnect::disconnect($link);
        return $result;

    }

    static function storeNewUserWithoutManager($user, $password)
    {
        $errorMessage = "";
        $link = BdConnect::connect2db($errorMessage);
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $link->prepare("INSERT INTO Utilisateur(prenom, nom, email, mot_de_passe, actif) 
                                        VALUES (:firstname, :name, :email, :password, 1)");
        $query->bindValue(':firstname', $user->getFirstName());
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue('password', $hashPassword);

        if($query->execute()) {
            BdConnect::disconnect($link);
        }
        else {

        }
    }

    static function storeNewUserWithManager($user, $password)
    {
        $link = BdConnect::connect2db();
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $link->prepare("INSERT INTO Utilisateur(prenom, nom, email, mot_de_passe, actif, manager) 
                                        VALUES (:firstname, :name, :email, :password, 1, :manager)");
        $query->bindValue(':firstname', $user->getFirstName());
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue('password', $hashPassword);
        $query->bindValue(':manager', $user->getIdManager());

        if($query->execute()) {
            BdConnect::disconnect($link);
        }
        else {

        }
    }

    static function updateUser($idUser, $firstname, $name, $email, $password, $manager)
    {
        $link = BdConnect::connect2db();

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = $link->prepare("UPDATE Utilisateur SET prenom= :firstname, nom= :name, email = :email, mot_de_passe= :hash, manager= :manager 
                                        WHERE id_utilisateur = :idUtilisateur");
        $query->bindValue(':firstname', $firstname);
        $query->bindValue(':name', $name);
        $query->bindValue(':email', $email);
        $query->bindValue(':manager', $manager);
        $query->bindValue(':idUtilisateur', $idUser);

        if ($query->execute()) {
            BdConnect::disconnect($link);
        } else {

        }
    }

    static function activateUser($idUser)
    {
        $link = BdConnect::connect2db();

        $query = $link->prepare("UPDATE Utilisateur SET actif = 1 WHERE id_utilisateur = :idUtilisateur");
        $query->bindValue(':idUtilisateur', $idUser);

        if ($query->execute())
            BdConnect::disconnect($link);
        else {

        }
    }

    static function deactivateUser($idUser)
    {
        $link = BdConnect::connect2db();

        $query = $link->prepare("UPDATE Utilisateur SET actif = 0 WHERE id_utilisateur = :idUtilisateur");
        $query->bindValue(':idUtilisateur', $idUser);

        if ($query->execute())
            BdConnect::disconnect($link);
        else {

        }
    }

}