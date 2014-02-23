<?php
require_once 'libs/models/user.php';
session_start();

/**
 * Näyttää kirjautumis/rekisteröitymissivun
 * @param type $page    näytettävä näkymä
 * @param type $data    näkymälle välitettävä data
 */
function showLoginScreen($page, $data = array()) {
    $data = (object) $data;
    require 'views/loginbase.php';
    die();
}

/**
 * Näyttää parametrinä annettavan näkymän ja antaa sille parametrina dataa
 * @param type $page    näkymä joka halutaan näyttää
 * @param type $data    dataa jonka kontrolleri haluaa välittää näkymälle
 */
function showView($page, $data = array()) {
    $data = (object) $data;
    require 'views/nav.php';
    die();
}

/**
 * Kirjaa parametrina saamansa nimisen käyttäjän järjestelmään
 * @param type $uname   käyttäjänimi
 */
function signIn($uname) {
    $_SESSION['signedin'] = $uname;
    header('Location: frontpage.php');
}

/**
 * Palauttaa kirjautuneena olevan käyttäjän käyttäjänimen
 * @return type käyttäjänimi
 */
function getUserName(){
    return $_SESSION['signedin'];
}

/**
 * Kertoo onko käyttäjä kirjautuneena vai ei
 * @return type     true jos käyttäjä on kirjautuneena, muuten false
 */
function isSignedIn() {
    return isset($_SESSION['signedin']);
}

/**
 * Kirjaa käyttäjän ulos järjestelmästä
 */
function signout() {
    //Poistetaan istunnosta merkintä kirjautuneesta käyttäjästä -> Kirjaudutaan ulos
    unset($_SESSION["signedin"]);

    //Yleensä kannattaa ulkos kirjautumisen jälkeen ohjata käyttäjä kirjautumissivulle
    header('Location: dologin.php');
}

/**
 * Palauttaa käyttäjän oikeudet
 * @return type     boolean arvo. True jos käyttäjä on ylläpitäjä, muuten false.
 */
function getUserAccessRights() {
    $user = $_SESSION['signedin'];

    return User::getAccess($user);
}

?>
