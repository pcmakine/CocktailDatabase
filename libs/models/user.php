<?php

require_once "connection.php";
require_once "database.php";

/**
 * User taulun malli joka tarjoaa palveluita käyttäjien lisäämiseen ja muokkaamiseen.
 */
class user {

    private $username;
    private $password;
    private $accessrights;

    /**
     * Luo uuden user olion
     * @param type $username    käyttäjänimi
     * @param type $password    salasana
     * @param type $accessrights    onko käyttäjä ylläpitäjä vai ei
     */
    public function __construct($username, $password, $accessrights) {
        $this->username = $username;
        $this->password = $password;
        $this->accessrights = user::accessbitToBoolean($accessrights);
    }

    /**
     * Palauttaa listan kaikista käyttäjistä
     * @return type lista käyttäjistä
     */
    public static function getUsers() {
        $sql = "SELECT username,password, accessrights::int from users order by username";
        $array = array();
        return database::getList($sql, $array, 'user');
    }

    /**
     * Palauttaa yhden käyttäjän
     * @param type $user    käyttäjänimi
     * @param type $userpsw     salasana
     * @return type             user olio
     */
    public static function getSingleUser($user, $userpsw) {
        $sql = "SELECT username, password, accessrights::int from users where username = ? AND password = ? LIMIT 1";
        $array = array($user, $userpsw);
        return database::getSingle($sql, $array, 'user');
    }

    /**
     * Palauttaa true tai false sen mukaan onko käyttäjä ylläpitäjä vai ei
     * @param type $uname   käyttäjänimi
     * @return null     true jos käyttäjä on ylläpitäjä muuten false
     */
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

    /**
     * Päivittää käyttäjän ylläpito-oikeudet parametrin mukaisesti
     * @param type $newRights   uudet ylläpito-oikeudet. 1 tarkoittaa että käyttäjällä on ylläpito-oikeudet ja 0 vastaavasti että ei ole.
     */
    public function updateAccessRights($newRights) {
        $sql = "UPDATE users SET accessrights = ? WHERE username = ?";
        $array = array($newRights, $this->username);
        database::nonReturningExecution($sql, $array);
    }

    /**
     * Vaihtaa käyttäjän salasanan  
     * @param type $password    uusi salasana
     * @param type $username    käyttäjänimi
     */
    public static function changePassword($password, $username) {
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        $array = array($password, $username);
        database::nonReturningExecution($sql, $array);
    }

    /**
     * Luo uuden käyttäjän
     */
    public function createUser() {
        $sql = "insert into users(username, password, accessrights) values(?, ?, ?)";
        $array = array($this->username, $this->password, user::booleanToAccessbit($this->accessrights));
        database::nonReturningExecution($sql, $array);
    }

    /**
     * Palauttaa true tai false sen mukaan löytyykö kannasta tätä user oliota vastaavaa käyttäjää
     * @return type     true jos käyttäjä löytyy, muuten false
     */
    public function userExists() {
        $sql = "SELECT count (username) from users where username = ?";
        $array = array($this->username);

        return database::getCount($sql, $array) > 0;
    }

    /**
     * Luo uuden käyttäjäolion
     * @param type $result  tietokannasta saatu olio jonka perusteella käyttäjä voidaan luoda
     * @return \user    palautettava user olio
     */
    public static function createNewOne($result) {
        $user = new user($result->username, $result->password, $result->accessrights);
        return $user;
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

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRights() {
        return $this->accessrights;
    }

}