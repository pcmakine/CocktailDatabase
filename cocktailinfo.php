<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$id = (int) $_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);
$dataArray = array('id' => $id,
    'name' => $cocktail->getName(),
    'rating' => $cocktail->getRating(),
    'price' => $cocktail->getPrice(),
    'recipe' => $cocktail->getRecipe(),
    'accessrights' => getUserAccessRights(),
    'title' => 'info');

if (!isSignedIn()) {
    header('Location: dologin.php');
} else {
    if (isset($_POST['edit'])) {        //the user has pressed the edit button
        $dataArray['editable'] = true;
        showView('cocktailview.php', $dataArray);
    }else if(isset($_POST['confirmremove'])){
        cocktail::removeCocktail($id);
        $_SESSION['announcement'] = 'Drinkin poisto onnistui!';
        header('Location: frontpage.php');
    } 
    else if(isset($_POST['removebutton'])){
        $dataArray['error'] = 'Haluatko varmasti poistaa drinkin tietokannasta?';
        showView('cocktailview.php', $dataArray);
    }
    else if (isset($_POST['savebutton'])) {    //the user has pressed the save button
        cocktail::updateCocktail($id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['recipe']), $_POST['price']);
        $_SESSION['announcement'] = 'Drinkin muokkaus onnistui!';
        header('Location: frontpage.php');
    } else {
        $dataArray['editable'] = false;
        showView('cocktailview.php', $dataArray);
    }
}

