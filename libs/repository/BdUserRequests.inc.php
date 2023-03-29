<?php
require_once "BdConnect.inc.php";
require_once "libs/models/User.php";

use models\User;

class BdUserRequest
{

    /**
     * a generic function to get all user from the database
     * @return User[]|string array of user or error message
     */
    static function getAllUser()
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            BdConnect::disconnect($link);
            $result = array_map(function ($user) {
                $user['mot_de_passe'] = null;
                return new User($user['id_user'],
                    $user['firstname'],
                    $user['name'],
                    $user['email'],
                    $user['active'],
                    $user['manager']);
            }, $result);
            BdConnect::disconnect($link);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }finally {
            BdConnect::disconnect($link);
        }

    }

    /**
     * get the data of the user and verify the password
     * @param $email string email of the user
     * @param $password string password of the user to verify
     * @return User|string|false an object with the data of the user if the coonection is ok
     *                           or error message
     *                           or false if the password is not correct
     */
    static function getUserDataAndVerifyPsw($email, $password)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User WHERE email = :email");
            $query->bindValue(':email', $email);

            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            BdConnect::disconnect($link);
            if ($result) {
                if (password_verify($password, $result['password'])) {
                    $result['password'] = null;
                    return new User($result['id_user'],
                        $result['firstname'],
                        $result['name'],
                        $result['email'],
                        $result['active'],
                        $result['manager']);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }

    }

    /**
     * get the user with the id
     * @param $id string email of the user
     * @return User|string|false an object with the data of the user if the coonection is ok
     *                           or error message
     *                           or false if the password is not correct
     */
    static function getUserWithId($id)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User WHERE id_user = :id_user");
            $query->bindValue(':id_user', $id);

            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            BdConnect::disconnect($link);
            if ($result) {
                return new User($result['id_user'],
                    $result['firstname'],
                    $result['name'],
                    $result['email'],
                    $result['active'],
                    $result['manager']);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }

    }


    /**
     * store a new user in the database
     * @param $user User user to store the manager id can be null
     * @param $password string password of the user that will be hashed
     * @return string|void error message or nothing if everything is ok
     */
    static function storeNewUser($user, $password)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = $link->prepare("INSERT INTO User(firstname, name, email, password, active, manager) 
                                            VALUES (:firstname, :name, :email, :password, 1, :manager)");
            $query->bindValue(':firstname', $user->getFirstName());
            $query->bindValue(':name', $user->getName());
            $query->bindValue(':email', $user->getEmail());
            $query->bindValue('password', $hashPassword);
            $query->bindValue(':manager', $user->getIdManager());

            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }
    }

    /**
     * update the user in the database with the new data
     * @param $idUser int id of the user to update
     * @param $firstname string firstname of the user
     * @param $name string name of the user
     * @param $email string email of the user
     * @param $manager int id of the manager
     * @return string|User error message
     *                     or an object with the data of the user
     */
    static function updateUser($idUser, $firstname, $name, $email, $manager)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("UPDATE User SET firstName= :firstname, name= :name, email = :email, manager= :manager 
                                        WHERE id_user = :idUser");
            $query->bindValue(':firstname', $firstname);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue(':manager', $manager);
            $query->bindValue(':idUser', $idUser);

            if (!$query->execute()) {
                return "error unable to update user";
            }
            BdConnect::disconnect($link);
            return new User($idUser, $firstname, $name, $email, 1, $manager);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }
    }

    /**
     * update the state of the user the active or not
     * @param $idUser int id of the user to activate
     * @param $active bool 1 to activate the user 0 to deactivate
     * @return string|void
     */
    static function activateUser($idUser, $active)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("UPDATE User SET active = :active WHERE id_user = :idUser");
            $query->bindValue(':active', $active);
            $query->bindValue(':idUser', $idUser);

            if (!$query->execute())
                return "error unable to update user";

            else {

            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }
    }

    /**
     * update the password of the user
     * TODO : maybe add a other parameter for the old password to make a check
     *        before the update to secure the update of the password
     *
     * @param $idUser int id of the user to update
     * @param $password string new password of the user
     * @return string|void error message
     *                     or nothing if everything is ok
     */
    static function updatePassword($idUser, $password)
    {
        try {
            $link = BdConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = $link->prepare("UPDATE User SET password = :password WHERE id_user = :idUser");
            $query->bindValue(':password', $hashPassword);
            $query->bindValue(':idUser', $idUser);

            if (!$query->execute())
                return "error unable to update user";

            else {

            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            BdConnect::disconnect($link);
        }
    }

}