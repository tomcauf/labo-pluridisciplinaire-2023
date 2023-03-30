<?php
require_once "DbConnect.inc.php";

class DbUserRequests
{

    //TODO 2x disconnect dans els fonctions ?
    //TODO check fetch into avec les modes

    /**
     * //TODO mot_de_passe ? Renvoie qu'un seul user ?
     * a generic function to get all user from the database
     * @return User[]|string array of user or error message
     */
    static function getAllUser()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            DbConnect::disconnect($link);
            $result = array_map(function ($user) {
                $user['mot_de_passe'] = null;
                return new User($user['id_user'],
                    $user['firstname'],
                    $user['name'],
                    $user['email'],
                    $user['active'],
                    $user['manager']);
            }, $result);
            DbConnect::disconnect($link);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }finally {
            DbConnect::disconnect($link);
        }

    }

    /**
     * get the data of the user and verify the password
     * @param $email string email of the user
     * @param $password string password of the user to verify
     * @return int|string|false an object with the data of the user if the coonection is ok
     *                           or error message
     *                           or false if the password is not correct
     */
    static function getUserDataAndVerifyPsw($email, $password)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User WHERE email = :email");
            $query->bindValue(':email', $email);

            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            DbConnect::disconnect($link);
            if ($result) {
                if (password_verify($password, $result['password'])) {
                    $result['password'] = null;
                    return intval($result['id_user']);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }

    }

    /**
     * get the user with the id
     * @param $id string email of the user
     * @return User|string|false an object with the data of the user if the coonection is ok
     *                           or error message
     *                           or false if the password is not correct
     */
    static function getUserById($id)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User WHERE id_user = :id_user");
            $query->bindValue(':id_user', $id);

            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            DbConnect::disconnect($link);
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
            DbConnect::disconnect($link);
        }

    }

    static function getUserByEmail($email)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->prepare("SELECT * FROM User WHERE email = :email");
            $query->bindValue(':email', $email);
            $query->execute();
            $result = $query->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
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
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = $link->prepare("INSERT INTO User(firstname, name, email, password, active, manager) 
                                            VALUES (:firstname, :name, :email, :password, 1, :manager)");
            $query->bindValue(':firstname', $user->firstName);
            $query->bindValue(':name', $user->name);
            $query->bindValue(':email', $user->email);
            $query->bindValue('password', $hashPassword);
            $query->bindValue(':manager', $user->idManager);

            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
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
            $link = DbConnect::connect2db($errorMessage);
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
            DbConnect::disconnect($link);
            return new User($idUser, $firstname, $name, $email, 1, $manager);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
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
            $link = DbConnect::connect2db($errorMessage);
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
            DbConnect::disconnect($link);
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
            $link = DbConnect::connect2db($errorMessage);
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
            DbConnect::disconnect($link);
        }
    }

    //TODO faire un join pour récup plus d'infos qu'une ID
    static function getUserLinksFunction($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_function FROM Have WHERE id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    static function addLinksToUserFunction($idUser, ...$idFunctions)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idFunctions as $idFunction) {
                $query = $link->prepare("INSERT INTO Have(id_user, id_function) VALUES (:idUser, :idFunction);");
                $query->bindValue(":idUser", $idUser);
                $query->bindValue(":idFunction", $idFunction);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getUserLinksTraining($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_training FROM Training WHERE id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            $results = $query->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    static function addLinksToUserTraining($idUser, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idTrainings as $idTraining) {
                $query = $link->prepare("INSERT INTO Training(id_user, id_training) VALUES (:idUser, :idTraining);");
                $query->bindValue(":idUser", $idUser);
                $query->bindValue(":idTraining", $idTraining);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

}