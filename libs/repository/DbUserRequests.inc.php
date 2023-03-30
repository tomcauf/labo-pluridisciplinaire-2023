<?php
require_once "DbConnect.inc.php";
if (basename($_SERVER['PHP_SELF']) == 'index.php') {
    require_once "libs/email/EmailSender.inc.php";
} else {
    require_once "../libs/email/EmailSender.inc.php";
}

class DbUserRequests
{

    /**
     * a generic function to get all user from the database
     * @return user[]|false array of array with the data of users
     *                      or message|false if error
     *                      or false if empty
     */
    static function getAllUser()
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;
            $query = $link->query("SELECT * FROM User");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
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
            return ($result && password_verify($password, $result['password'])) ? intval($result['id_user']) : false;
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getAllParticipantTraining($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("SELECT t.id_training as id, t.name as name, t.location as location, t.deadline as deadline, p.status as status
                                            FROM User u
                                            join Participate p on p.id_user = u.id_user
                                            join Training t on t.id_training = p.id_training
                                            WHERE u.id_user = :idUser and p.status IN('DONE','IN PROGRESS')");
            $query->bindValue(':idUser', $idUser);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
    static function getAllParticipantTrainingValide($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("SELECT t.id_training as id, t.name as name, t.location as location, t.deadline as deadline
                                            FROM User u
                                            join Participate p on p.id_user = u.id_user
                                            join Training t on t.id_training = p.id_training
                                            WHERE u.id_user = :idUser and p.status = 'VALIDATED'");
            $query->bindValue(':idUser', $idUser);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC);
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
            return $result;
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

            $results = $query->fetch();
            return $results;
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }


    /**
     * @param $firstname string that's the firstname of the user
     * @param $name string that's the family name of the user
     * @param $email string that's the email of the user
     * @param $idManager integer that's the id of the manager of the user
     * @return string|void error message or nothing if everything is ok
     */
    static function storeNewUser($firstname, $name, $email, $idManager)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;


            $hashPassword = self::generatePassword($email);

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

    static function storeNewUserWithPassword($firstname, $name, $email, $idManager, $password)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;


            $hashPassword = password_hash($password, PASSWORD_DEFAULT);;

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

    private static function generatePassword($email)
    {
        $password = rand(0, 9999);
        EmailSender::sendNewAccount($email, $password);
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * update the user in the database with the new data
     * @param $idUser int id of the user to update
     * @param $firstname string firstname of the user
     * @param $name string name of the user
     * @param $email string email of the user
     * @param $manager int id of the manager
     * @return string|user[]| false error message
     *                       or a table with the data of the user
     */
    static function updateUser($idUser, $firstname, $name, $email, $manager, $active)
    {
        if (!$active)
            return false;

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

            $query->execute();
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

    //TODO faire safe delete de toutes les autres foreign key
    static function removeUser($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("delete from User where id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
        } catch (PDOException $exception) {
            return $exception->getMessage();
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
    static function activateUser($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("UPDATE User SET active = 1 WHERE id_user = :idUser");
            $query->bindValue(':idUser', $idUser);
            $query->execute();

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
            $query->execute();
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
    static function getUserLinksFunction($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("SELECT f.id_function, f.name, f.role_level
                                            FROM Function f
                                            JOIN Have h ON h.id_function = f.id_function
                                            WHERE h.id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
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
            if (!$link)
                return $errorMessage;

            foreach ($idFunctions as $idFunction) {
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
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("SELECT tg.id_training, tg.name, tg.description, tg.location, 
                                                    tg.duration, tg.deadline, tg.active, tg.certificate_deadline
                                            FROM Training tg
                                            JOIN Trainers tr AS tr.id_training = tg.id_training
                                            WHERE tr.id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
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
            if (!$link)
                return $errorMessage;

            foreach ($idTrainings as $idTraining) {
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


    static function getUserLinksParticipation($idUser)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            if (!$link)
                return $errorMessage;

            $query = $link->prepare("SELECT CONCAT(p.status, ' File : ', p.file_link) as ParticipationInfo, t.name, t.description, t.location
                                            FROM Participate p
                                            JOIN Request r AS r.id_request = p.id_participation
                                            JOIN Training t AS p.id_training = p.id_training
                                            WHERE p.id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

}