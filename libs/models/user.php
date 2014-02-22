<?php

require_once "connection.php";
require_once "database.php";

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

    public static function createNewOne($result) {
        $user = new user($result->username, $result->password, $result->accessrights);
        return $user;
    }

    public static function getUsers() {
        $sql = "SELECT username,password, accessrights::int from users order by username";
        $array = array();
        return database::getList($sql, $array, 'user');
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

    public function updateAccessRights($newRights) {
        $sql = "UPDATE users SET accessrights = ? WHERE username = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($newRights, $this->username));
    }

    public static function changePassword($password, $username) {
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($password, $username));
    }

    public function createUser() {
        $sql = "insert into users(username, password, accessrights) values(?, ?, ?)";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->username, $this->password, user::booleanToAccessbit($this->accessrights)));
    }

    public function userExists() {
        $sql = "SELECT count (username) from users where username = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->username));

        $result = $query->fetchColumn();
        return $result > 0;
    }

    public static function accessbitToBoolean($bit) {
        if ($bit == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function booleanToAccessbit($access) {
        if ($access) {
            return 1;
        } else {
            return 0;
        }
    }

}