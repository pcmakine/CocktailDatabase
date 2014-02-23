<?php

require_once 'libs/common.php';
require_once 'libs/models/user.php';

if(isSignedIn()){
    header('Location: frontpage.php');
}

if(isset($_POST['registerbutton'])){
    header('Location: registration.php');
}

if(!isset($_POST['submitbutton'])){     //show normal login screen if the user hasn't yet pressed the login button
    showLoginScreen('views/dologinview.php', array(
        'title' => 'login'));
}

if (empty($_POST["user"]) && isset($_POST['submitbutton'])) {
    showLoginScreen("dologinview.php", array(
        'error' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}

$uname = htmlspecialchars($_POST["user"]);

if (empty($_POST["password"]) && isset($_POST['submitbutton'])) {
    showLoginScreen("views/dologinview.php", array(
        'user' => $uname,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}

$password = htmlspecialchars($_POST["password"]);

$user = user::getSingleUser($uname, $password);

if ($user != NULL) {
    signIn($uname);
} else{
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showLoginScreen('views/dologinview.php', array(
        'title' => 'login',
        'user' => $uname,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}