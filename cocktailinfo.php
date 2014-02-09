<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$id = (int) $_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);

if (!isSignedIn()) {
    header('Location: dologin.php');
} else {
    if (isset($_POST['edit'])) {

    showView('cocktailview.php', array('id' => $id,
        'name' => $cocktail->getName(),
        'rating' => $cocktail->getRating(),
        'price' => $cocktail->getPrice(),
        'recipe' => $cocktail->getRecipe(),
        'accessrights' => getUserAccessRights(),
        'editable' => true));
}  else{
        showView('cocktailview.php', array('id' => $id,
        'name' => $cocktail->getName(),
        'rating' => $cocktail->getRating(),
        'price' => $cocktail->getPrice(),
        'recipe' => $cocktail->getRecipe(),
        'accessrights' => getUserAccessRights()));
}
}

