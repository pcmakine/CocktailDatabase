<?php
require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$id = (int)$_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);

if (isSignedIn()) {
    showView('cocktailview.php', array('id' => $id,
                                        'name' => $cocktail->getName(),
                                        'rating' => $cocktail->getRating(),
                                        'price' => $cocktail->getPrice(),
                                        'recipe' => $cocktail->getRecipe(),
                                        'accessrights' => getUserAccessRights()));
} else {
    header('Location: dologin.php');
}
