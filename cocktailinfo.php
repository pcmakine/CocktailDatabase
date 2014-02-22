<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';
require_once 'libs/models/ingredient.php';

$id = (int) $_GET['id'];
$cocktail = cocktail::getSingleCocktail($id);
$ingredientlist = ingredient::getIngredientsForCocktail($id);
$dataArray = array(
    'cocktail' => $cocktail,
    'accessrights' => getUserAccessRights(),
    'title' => 'Drinkkiarkisto-info',
    'ingredients' => $ingredientlist
);

if (!isSignedIn()) {
    header('Location: dologin.php');
} else {
    if (!isset($_POST['removebtns']) && !isset($_POST['edit']) && !isset($_POST['confirmremove']) && !isset($_POST['removebutton'])
            && !isset($_POST['addingredientbutton']) && !isset($_POST['savebutton']) && !isset($_POST['acceptsuggestion'])) {
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
        $cocktail->addRating(getUserName(), $_POST['rating']);
        cocktail::updateCocktail($id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['recipe']), $_POST['price'], $cocktail->getSuggestion());
        
        if(getUserAccessRights()){
            $_SESSION['announcement'] = 'Drinkin muokkaus onnistui!';
        }else{
            $_SESSION['announcement'] = 'Arvosana tallennettu!';
        }
       
        header('Location: frontpage.php');
    } else if (isset($_POST['acceptsuggestion'])) {
        var_dump("hyväksytty!");
        cocktail::updateCocktail($id, $cocktail->getName(), $cocktail->getRecipe(), $cocktail->getPrice(), false);
        $_SESSION['announcement'] = 'Ehdotus hyväksytty!';
        header('Location: frontpage.php');
    }
}

