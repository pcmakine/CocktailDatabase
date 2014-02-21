<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$page = 1;

if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($page < 1)
        $page = 1;
}
$perpage = 3;

$list = array();
$numofcocktails;
$accessrights = getUserAccessRights();
$searchterm = htmlspecialchars(trim($_GET['search']));

if (!$accessrights) {   //tavallinen käyttäjä, näytä aina vain hyväksytyt drinkit
    unset($list);
    $list = cocktail::getApprovedCocktails($perpage, $page);
    $numofcocktails = cocktail::numofApprovedCocktails();
} else if (isset($_GET['getSuggestions'])) { //pääkäyttäjä, ei ole valinnut pelkästään ehdotuksia nähtäväkseen
    unset($list);
    $list = cocktail::searchForCocktail($searchterm, $perpage, $page, TRUE);
    $numofcocktails = cocktail::numofSuggestions();
} else {
    unset($list);
    $list = cocktail::searchForCocktail($searchterm, $perpage, $page, FALSE);
    $numofcocktails = cocktail::numofCocktails();
}

$pagestotal = ceil($numofcocktails / $perpage);

if (!isSignedIn()) {

    header('Location: dologin.php');
} else {

    showView('frontpageview.php', array('title' => "frontpage",
        'list' => $list,
        'page' => $page,
        'pagestotal' => $pagestotal,
        'numofcocktails' => $numofcocktails,
        'accessrights' => $accessrights,
        'searchterm' => $searchterm));
    
    
}



