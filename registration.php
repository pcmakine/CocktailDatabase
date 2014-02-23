<?php

require_once 'libs/common.php';
require_once 'libs/models/user.php';

$data = array('title' => 'Drinkkiarkisto - rekisteröityminen');

if (isSignedIn()) {
    header('Location: frontpage.php');
}

if (!isset($_POST['submitbutton'])) {     //show normal registration screen if the user hasn't yet pressed the login button
    showLoginScreen('views/registrationview.php', $data);
}

if (empty($_POST["user"]) && isset($_POST['submitbutton'])) {
    $data['error'] = "Rekisteröityminen epäonnistui! Et antanut käyttäjätunnusta.";
    showLoginScreen("registrationview.php", $data);
}

$data['user'] = htmlspecialchars($_POST["user"]);

if (empty($_POST["password"]) && isset($_POST['submitbutton'])) {
    $data['error'] = "Rekisteröityminen epäonnistui! Et antanut salasanaa.";
    showLoginScreen("views/registrationview.php", $data);
}

if (empty($_POST["secondpassword"]) && isset($_POST['submitbutton'])) {
    $data['error'] = "Rekisteröityminen epäonnistui! Et antanut salasanaa toiseen kertaan.";
    showLoginScreen("views/registrationview.php", $data);
}

if (!empty($_POST["secondpassword"]) && !empty($_POST["password"]) && isset($_POST['submitbutton'])) {
    if ($_POST["secondpassword"] == $_POST["password"]) {
        $user = new user(htmlspecialchars($_POST["user"]), htmlspecialchars($_POST["password"], false));
        if ($user->userExists()) {                                                  //tietokannassa oli jo käyttäjä samalla nimellä
            $data['error'] = "Käyttäjänimi on jo käytössä!";
            showLoginScreen("views/registrationview.php", $data);
        } else {                                                                    //kirjautuminen onnistui
            $user->createUser();
            signIn($user->getUsername());
            $_SESSION['announcement'] = "Rekisteröityminen onnistui, tervetuloa käyttämään drinkkiarkistoa"  + $user->getUsername() + ".";
            header('Location: frontpage.php');
        }
    } else {
        $data['error'] = "Salasanat eivät olleet samat!!";
        showLoginScreen("views/registrationview.php", $data);
    }
}