<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

if (!isSignedIn()) {
    header('Location: dologin.php');
}

if (!isset($_POST["savebutton"])) {
    showView("addcocktailview.php", array(
        'title' => 'add cocktail',
        'accessrights' => getUserAccessRights(),
    ));
}

if (empty($_POST["name"])) {
    showView("addcocktailview.php", array(
        'title' => 'add cocktail',
        'accessrights' => getUserAccessRights(),
        'error' => "Anna drinkille nimi!",
    ));
} else {
    $cocktail = new cocktail(-1, $_POST["name"], $_POST["recipe"], $_POST["price"]);
    $cocktail->addCocktail();
    $cocktail->addRating($_SESSION['signedin'], $_POST["rating"]);

    $_SESSION['announcement'] = "Drinkki lisätty onnistuneesti.";
    header('Location: frontpage.php');
}
?>
