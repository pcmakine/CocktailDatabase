<?php

require_once "connection.php";

class user {

    private $username;
    private $password;
    private $accessrights;

    public function __construct($username, $password, $accessrights) {
        $this->username = $username;
        $this->password = $password;
        $this->accessrights = user::accessbitToBoolean($accessrights);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRights() {
        return $this->accessrights;
    }

    public static function getUsers() {
        $sql = "SELECT username,password, accessrights::int from users";

        $query = connection::getConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $user = new user($result->username, $result->password, $result->accessrights);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $results[] = $user;
        }
        return $results;
    }

    public static function getSingleUser($user, $userpsw) {
        $sql = "SELECT username, password, accessrights::int from users where username = ? AND password = ? LIMIT 1";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($user, $userpsw));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $user = new user($result->username, $result->password, $result->accessrights);
            return $user;
        }
    }

    public static function getAccess($uname) {
        $sql = "SELECT accessrights from users where username = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($uname));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            return user::accessbitToBoolean($result->accessrights);
        }
    }

    public static function accessbitToBoolean($bit) {
        if ($bit == 1) {
            return true;
        } else {
            return false;
        }
    }

}