<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$errors = array();

if (!isSignedIn()) {
    header('Location: dologin.php');
}

if (!isset($_POST["savebutton"])) {
    showView("addcocktailview.php", array(
        'title' => 'add cocktail',
        'accessrights' => getUserAccessRights(),
    ));
}

if (!empty($errors)) {
    showView("addcocktailview.php", array(
        'title' => 'add cocktail',
        'accessrights' => getUserAccessRights(),
        'errors' => $errors
    ));
} else {
    $cocktail = new cocktail(-1, htmlspecialchars($_POST["name"]), htmlspecialchars($_POST["recipe"]), $_POST["price"], getCorrectValueForSuggestion());
    $cocktail->addCocktail();
    $cocktail->addRating($_SESSION['signedin'], $_POST["rating"]);

    $_SESSION['announcement'] = 'Drinkki lisätty onnistuneesti.';
    header('Location: frontpage.php');
}

function getCorrectValueForSuggestion() {
    if(getUserAccessRights()){
        return 0;
    } else{
        return 1;
    }
}


?>
