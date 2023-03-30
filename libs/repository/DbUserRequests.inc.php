<?php
require_once "DbConnect.inc.php";

class DbUserRequests
{

    //TODO 2x disconnect dans els fonctions ?
    //TODO check fetch into avec les modes

    /**
     * //TODO mot_de_passe ? Renvoie qu'un seul user ?
     * a generic function to get all user from the database
     * @return user[]|string array of array with the data of users
     *                      or error message
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
     * @return user[]|string|false a table with the data of the user if the connection is ok
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
                return $result;
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
     * @param $email string that's the email of the user
     * @return mixed|string a table with the data of the user
     *                      or an error message
     */
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
     * @param $firstname string that's the firstname of the user
     * @param $name string that's the family name of the user
     * @param $email string that's the email of the user
     * @param $password string that's the password in plaintext of the user
     * @param $idManager integer that's the id of the manager of the user
     * @return string|void error message or nothing if everything is ok
     */
    static function storeNewUser($firstname, $name, $email, $password, $idManager)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = $link->prepare("INSERT INTO User(firstname, name, email, password, active, manager) 
                                            VALUES (:firstname, :name, :email, :password, 1, :manager)");
            $query->bindValue(':firstname', $firstname);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue('password', $hashPassword);
            $query->bindValue(':manager', $idManager);

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
     * @return string|user[] error message
     *                     or a table with the data of the user
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
            $result['id_user'] = $idUser;
            $result['firstname'] = $firstname;
            $result['name'] = $name;
            $result['email'] = $email;
            $result['manager'] = $manager;

            return $result;
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

    /**
     * @param $idUser integer that's the id of the user
     * @return array|false|string an array of the functions that the user has
     *                             or false if there isn't any
     *                              or an error string
     */
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
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    /**
     * @param $idUser integer that's the id of the concerned user
     * @param ...$idFunctions n integer variables of the functions that the user has
     * @return void|string void if everything is good
     *                      or an error string
     */
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
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    /**
     * @param $idUser integer of the concerned user
     * @return array|false|string associated array of the data of the user
     *                              or false if there isn't any corresponding data
     *                              or an error string
     */
    static function getUserLinksTraining($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_training FROM Training WHERE id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
            return (isset($results)) ? $results : "Something went wrong with the request";
        }
    }

    /**
     * @param $idUser integer of the concerned user
     * @param ...$idTrainings n integer variables of the associated trainings
     * @return void|string void if everything is good
     *                      or an error string
     */
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
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

}