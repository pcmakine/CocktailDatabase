<?php

require_once 'libs/common.php';
require_once 'libs/models/user.php';

if (empty($_POST["user"])) {
    showView("showlogin.php", array(
        'error' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}

$user = $_POST["user"];

if (empty($_POST["password"])) {
    showView("views/showlogin.php", array(
        'user' => $user,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}

$password = $_POST["password"];

/* Tarkistetaan onko parametrina saatu oikeat tunnukset */
if (user::getSingleUser($user, $password) != NULL) {
    /* Jos tunnus on oikea, ohjataan käyttäjä sopivalla HTTP-otsakkeella kissalistaan. */
    header('Location: listtest.php');
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showView('views/showlogin.php', array(
        'user' => $user,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}