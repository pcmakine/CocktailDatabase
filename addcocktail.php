<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';
require_once 'libs/models/ingredient.php';

$errors = array();

if (!isSignedIn()) {
    header('Location: dologin.php');
}

if (!isset($_POST["savebutton"])) {

    showView("addcocktailview.php", array(
        'title' => 'add cocktail',
        'accessrights' => getUserAccessRights(),
        'cocktailname' => htmlspecialchars($_POST['name']),
        'rating' => $_POST['rating'],
        'price' => $_POST['price'],
        'ingredients' => $_POST['ingredient'],
        'recipe' => htmlspecialchars($_POST['recipe'])
    ));
} else {
    $cocktail = new cocktail(-1, htmlspecialchars($_POST["name"]), htmlspecialchars($_POST["recipe"]), $_POST["price"], getCorrectValueForSuggestion());
    $cocktail->addCocktail();
    $cocktail->addRating($_SESSION['signedin'], $_POST["rating"]);

    ingredient::addAndLinkIngredients($_POST['ingredient'], $cocktail->getId());

    $_SESSION['announcement'] = "Drinkki lisätty onnistuneesti.";
    header('Location: frontpage.php');
}

function getCorrectValueForSuggestion() {
    if (getUserAccessRights()) {
        return 0;
    } else {
        return 1;
    }
}

function getNumbOfIngrd() {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 9) == "lastingrd") {
            $identifier = substr($key, 4);
            if (isset($value['tag' . $identifier])) {
                inserttag('tag', $identifier);
            }
        }
    }
}

?>
