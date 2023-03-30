<?php
require_once "DbConnect.inc.php";
class DbFunctionsRequests
{
    static function addFunction($name)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("INSERT INTO Function(name) values(:name)");
            $query->bindValue(":name", $name);
            $query->execute();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function removeFunction($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("DELETE FROM Function WHERE id_function = :idFunction");
            $query->bindValue(":idFunction", $idFunction);
            $query->execute();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function getFunctionLinksUser($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT u.id_user, u.firstname, u.name, u.email, u.active
                                            FROM User u
                                            JOIN Have h AS u.id_user = h.id_user
                                            WHERE h.id_function = :idFunction");
            $query->bindValue(":idFunction", $idFunction);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function addLinksToFunctionUser($idFunction, ...$idUsers)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idUsers as $idUser) {
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

    static function getFunctionLinksTraining($idFunction)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT t.id_training, t.name, t.location, t.duration, t.deadline, t.active, t.certificate_deadline
                                            FROM Training t 
                                            JOIN Operate o AS o.id_training = t.id_training
                                            WHERE o.id_function = :idFunction");
            $query->bindValue(":idFunction", $idFunction);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    static function addLinksToFunctionTraining($idFunction, ...$idTrainings)
    {
        try {
            $link = DbConnect::connect2db($errorMessage);

            foreach($idTrainings as $idTraining) {
                $query = $link->prepare("INSERT INTO Operate(id_training, id_function) VALUES (:idTraining, :idFunction);");
                $query->bindValue(":idTraining", $idTraining);
                $query->bindValue(":idFunction", $idFunction);
                $query->execute();
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }

    //TODO: Vérifier que c'est juste parce que fait par Gillian
    static function getRoleLevel($idUser){
        try {
            $link = DbConnect::connect2db($errorMessage);
            $query = $link->prepare("SELECT id_function
                                          FROM Have
                                          WHERE id_user = :idUser");
            $query->bindValue(":idUser", $idUser);
            if($query->execute()){
                $id_functions = $query->fetchAll(PDO::FETCH_COLUMN, PDO::FETCH_UNIQUE);
                $query2 = $link->prepare("SELECT MAX(role_level)
                                                FROM Function
                                                WHERE id_function IN :idFunctions");
                $query2->bindValue(":idFunctions", $id_functions);
                if($query2->execute()){
                    return $query2->fetch();
                } else {
                    throw new PDOException("Problème lors de l'exécution de la seconde requête!");
                }
            } else{
                throw new PDOException("Problème lors de l'exécution de la première requête!");
            }

        } catch(PDOException $exception) {
                return $exception->getMessage();
        } finally {
            DbConnect::disconnect($link);
        }
    }
}