<?php

/**
 * Description of UsersDAO
 *
 * @author erasto
 */
class UsersDAO {
    
    public function getUserDAO($user)
    {
        $dbConnection = new DBConnection();

        $db = $dbConnection->getConnection();
        $stmt = $db->prepare("SELECT * FROM USERS WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        //$incidencia = $stmt->fetch(PDO::FETCH_OBJ);
        $dbConnection->disconnect();
        //return $incidencia;
    }
    
     public function addUserDAO($user)
    {
        $dbConnection = new DBConnection();

        $db = $dbConnection->getConnection();
        $stmt = $db->prepare("INSERT INTO USERS (pass,nombre) "
                           . "VALUES (:nombre,:pass)");
        $stmt->bindParam(":nombre", $user->nombre);
        $stmt->bindParam(":pass", $user->pass);
        $success = $stmt->execute();
        $dbConnection->disconnect();
        return $success;
    }
     public function updateUserDAO($user)
    {
        $dbConnection = new DBConnection();

        $db = $dbConnection->getConnection();
        $stmt = $db->prepare("SELECT * FROM USERS WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        //$incidencia = $stmt->fetch(PDO::FETCH_OBJ);
        $dbConnection->disconnect();
        //return $incidencia;
    }
     public function deleteUserDAO($user)
    {
        $dbConnection = new DBConnection();

        $db = $dbConnection->getConnection();
        $stmt = $db->prepare("SELECT * FROM USERS WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        //$incidencia = $stmt->fetch(PDO::FETCH_OBJ);
        $dbConnection->disconnect();
        //return $incidencia;
    }
}
