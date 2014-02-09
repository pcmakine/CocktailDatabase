<?php
require_once 'libs/models/user.php';
session_start();

function showLoginScreen($page, $data = array()) {
    $data = (object) $data;
    require 'views/loginbase.php';
    die();
}

function showView($page, $data = array()) {
    $data = (object) $data;
    require 'views/nav.php';
    die();
}

function signIn($uname) {
    $_SESSION['signedin'] = $uname;
    header('Location: frontpage.php');
}

function isSignedIn() {
    return isset($_SESSION['signedin']);
}

function signout() {
    //Poistetaan istunnosta merkintä kirjautuneesta käyttäjästä -> Kirjaudutaan ulos
    unset($_SESSION["signedin"]);

    //Yleensä kannattaa ulkos kirjautumisen jälkeen ohjata käyttäjä kirjautumissivulle
    header('Location: dologin.php');
}

function getUserAccessRights(){
    $user= $_SESSION['signedin'];
    
    return User::getAccess($user);
}

?>
