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
        'rating' => htmlspecialchars($_POST['rating']),
        'price' => htmlspecialchars($_POST['price']),
        'ingredients' => ($_POST['ingredient']),
        'recipe' => htmlspecialchars($_POST['recipe'])
    ));
} else {
    $cocktail = new cocktail(-1, htmlspecialchars($_POST["name"]), htmlspecialchars($_POST["recipe"]), $_POST["price"], getCorrectValueForSuggestion());
    $cocktail->addCocktail();
    $cocktail->addRating($_SESSION['signedin'], htmlspecialchars($_POST["rating"]));

    ingredient::addAndLinkIngredients(($_POST['ingredient']), $cocktail->getId());

    if(getUserAccessRights()){
        $_SESSION['announcement'] = "Drinkki lisätty onnistuneesti.";
    }else{
        $_SESSION['announcement'] = "Ehdotus lisätty onnistuneesti. Drinkkisi tulee näkyviin kun ylläpitäjä on hyväksynyt sen.";
    }
    
    header('Location: frontpage.php');
}

function getCorrectValueForSuggestion() {
    if (getUserAccessRights()) {
        return 0;
    } else {
        return 1;
    }
}

?>
