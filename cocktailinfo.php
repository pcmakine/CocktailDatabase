<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$id = (int) $_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);

if (!isSignedIn()) {
    header('Location: dologin.php');
} else {
    if (isset($_POST['edit'])) {        //the user has pressed the edit button

    showView('cocktailview.php', array('id' => $id,
        'name' => $cocktail->getName(),
        'rating' => $cocktail->getRating(),
        'price' => $cocktail->getPrice(),
        'recipe' => $cocktail->getRecipe(),
        'accessrights' => getUserAccessRights(),
        'editable' => true));
}  else if(isset($_POST['savebutton'])){    //the user has pressed the save button
    cocktail::updateCocktail($id, htmlspecialchars($_POST['name']), $_POST['recipe'], $_POST['price']);
    $_SESSION['announcement'] = 'Drinkin muokkaus onnistui!';
    header('Location: frontpage.php');
}
else{
        showView('cocktailview.php', array('id' => $id,
        'name' => $cocktail->getName(),
        'rating' => $cocktail->getRating(),
        'price' => $cocktail->getPrice(),
        'recipe' => $cocktail->getRecipe(),
        'accessrights' => getUserAccessRights(),
            'editable' => false));
}
}

