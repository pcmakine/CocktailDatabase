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

if (!$accessrights) {   //tavallinen käyttäjä, näytä aina vain hyväksytyt drinkit
    unset($list);
    $list = cocktail::getApprovedCocktails($perpage, $page);
    $numofcocktails = cocktail::numofApprovedCocktails();
} else if(isset($_GET['getSuggestions'])) { //pääkäyttäjä, ei ole valinnut pelkästään ehdotuksia nähtäväkseen
    
        unset($list);
    $list = cocktail::getSuggestions($perpage, $page);
    $numofcocktails = cocktail::numofSuggestions();
}else{
    unset($list);
    $list = cocktail::getCocktails($perpage, $page);
    $numofcocktails = cocktail::numofCocktails();
}

$pagestotal = ceil($numofcocktails / $perpage);

if (isSignedIn()) {
    showView('front.php', array('title' => "frontpage",
        'list' => $list,
        'page' => $page,
        'pagestotal' => $pagestotal,
        'numofcocktails' => $numofcocktails,
        'accessrights' => $accessrights));
} else {
    header('Location: dologin.php');
}



