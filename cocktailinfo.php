<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';
require_once 'libs/models/ingredient.php';

$id = (int) $_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);
$ingredientlist = ingredient::getIngredientsForCocktail($id);
$dataArray = array('id' => $id,
    'name' => $cocktail->getName(),
    'rating' => $cocktail->getRating(),
    'price' => $cocktail->getPrice(),
    'recipe' => $cocktail->getRecipe(),
    'accessrights' => getUserAccessRights(),
    'title' => 'info',
    'ingredients' => $ingredientlist
);

if (!isSignedIn()) {
    header('Location: dologin.php');
} else {
    if (!isset($_POST['removebtns']) && !isset($_POST['edit']) && !isset($_POST['confirmremove']) && !isset($_POST['removebutton'])
            && !isset($_POST['addingredientbutton']) && !isset($_POST['savebutton'])) {
        $dataArray['editable'] = false;
        showView('cocktailinfoview.php', $dataArray);
    } else if (isset($_POST['edit'])) {        //the user has pressed the edit button
        $dataArray['editable'] = true;
        $dataArray['ingredients'] = $_POST['ingredient'];
        showView('cocktailinfoview.php', $dataArray);
    } else if (isset($_POST['confirmremove'])) {
        cocktail::removeCocktail($id);
        $_SESSION['announcement'] = 'Drinkin poisto onnistui!';
        header('Location: frontpage.php');
    } else if (isset($_POST['removebutton'])) {

        $dataArray['error'] = 'Haluatko varmasti poistaa drinkin tietokannasta?';
        $dataArray['ingredients'] = $_POST['ingredient'];
        showView('cocktailinfoview.php', $dataArray);
    } else if (isset($_POST['addingredientbutton'])) {
        $_POST['ingredient'][] = '';
        $dataArray['ingredients'] = $_POST['ingredient'];
        $dataArray['editable'] = true;
        showView('cocktailinfoview.php', $dataArray);
    } else if (isset($_POST['removebtns'])) {

        foreach ($_POST['removebtns'] as $buttonid) {
            if (isset($buttonid)) {
                $_POST['ingredient'] = (array_diff($_POST['ingredient'], array($_POST['ingredient'][$buttonid])));
                $_POST['ingredient'] = array_values($_POST['ingredient']);
                $dataArray['ingredients'] = $_POST['ingredient'];
            }
        }
        $dataArray['editable'] = true;

        showView('cocktailinfoview.php', $dataArray);
    } else if (isset($_POST['savebutton'])) {    //the user has pressed the save button
        cocktail::removeIngredients($id);
        ingredient::addAndLinkIngredients($_POST['ingredient'], $id);
        cocktail::updateCocktail($id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['recipe']), $_POST['price']);
        $_SESSION['announcement'] = 'Drinkin muokkaus onnistui!';
        header('Location: frontpage.php');
    }
}

