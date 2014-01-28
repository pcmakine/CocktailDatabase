<?php
require_once "connection.php"; 

class user {
    
  private $username;
  private $password;
  private $accessrights;

  public function __construct($username, $password, $accessrights) {
    $this->username = $username;
    $this->password = $password;
    $this->accessrights = $accessrights;
  }
  
  public function getUsername(){
      return $this -> username;
  }
  
  public function getRights(){
      return $this -> accessrights;
  }
  
  public static function getUsers() {
  $sql = "SELECT username,password, accessrights from users";

  $query = connection::getConnection()->prepare($sql);
  $query->execute();
    
  $results = array();
  foreach($query->fetchAll(PDO::FETCH_OBJ) as $result) {
    $user = new user($result->username, $result->password, $result->accessrights); 
    //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
    //Se vastaa melko suoraan ArrayList:in add-metodia.
    $results[] = $user;
  }
  return $results;
}

public function getSingleUser($user, $userpsw){
    $sql = "SELECT username, password, from users";
}

}