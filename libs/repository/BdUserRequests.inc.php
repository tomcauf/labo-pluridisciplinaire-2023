<?php
require_once 'BdConnect.inc.php';

class BdUserRequest
{

    /**
     * request to get all users on the database
     * @return array of all users
     */
    static function getAllUser()
    {
        $link = BdConnect::connect2db($base, $message);
        $sql = "SELECT * FROM Utilisateur";
        $result = $link->query($sql);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        BdConnect::disconnect($link);
        return $users;
    }

    static function storeNewUserWithoutManager($user, $password)
    {
        $link = BdConnect::connect2db();
        
        BdConnect::disconnect($link);
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