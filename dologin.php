<?php

require_once 'libs/common.php';
require_once 'libs/models/user.php';

if(isSignedIn()){
    header('Location: frontpage.php');
}

if (empty($_POST["user"])) {
    showLoginScreen("showlogin.php", array(
        'error' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}

$uname = $_POST["user"];

if (empty($_POST["password"])) {
    showLoginScreen("views/showlogin.php", array(
        'user' => $uname,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}

$password = $_POST["password"];

$user = user::getSingleUser($uname, $password);
if ($user != NULL) {
    signIn($uname);
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showLoginScreen('views/showlogin.php', array(
        'title' => 'login',
        'user' => $uname,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}