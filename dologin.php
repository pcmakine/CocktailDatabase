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

$username = $_POST["user"];

if (empty($_POST["password"])) {
    showLoginScreen("views/showlogin.php", array(
        'user' => $username,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}

$password = $_POST["password"];

$user = user::getSingleUser($username, $password);
if ($user != NULL) {
    signIn($user);
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showLoginScreen('views/showlogin.php', array(
        'user' => $username,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}