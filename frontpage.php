<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

if (!isSignedIn()) {

    header('Location: dologin.php');
}

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
$restriction = 'getAll=';
$orderby = makeSafe(htmlspecialchars(trim($_GET['orderby'])));
$orderdir = makeDirSafe(htmlspecialchars(trim($_GET['orderdir'])));
$nextdir = reverseDir($orderdir);


if ($orderby == '') {
    $orderby = "cocktailname";
}

if (!$accessrights) {   //tavallinen käyttäjä, näytä aina vain hyväksytyt drinkit. Tietokantahaku ottaa myös hakusanan huomioon
    $list = cocktail::getApprovedCocktails($searchterm, $orderby, $orderdir, $perpage, $page);
    $numofcocktails = cocktail::numofApprovedCocktails($searchterm);
} else if (isset($_GET['getSuggestions'])) { //pääkäyttäjä, joka on valinnut nähtäväkseen vain ehdotukset
    $list = cocktail::getSuggestions($searchterm, $orderby, $orderdir, $perpage, $page);
    $numofcocktails = cocktail::numofSuggestions($searchterm);
    $restriction = 'getSuggestions=';
} else {
    $list = cocktail::getCocktails($searchterm, $orderby, $orderdir, $perpage, $page);
    $numofcocktails = cocktail::numofCocktails($searchterm);
}

$pagestotal = ceil($numofcocktails / $perpage);

showView('frontpageview.php', array('title' => "frontpage",
    'list' => $list,
    'page' => $page,
    'pagestotal' => $pagestotal,
    'numofcocktails' => $numofcocktails,
    'accessrights' => $accessrights,
    'searchterm' => $searchterm,
    'restriction' => $restriction,
    'orderby' => $orderby,
    'nextdir' => $nextdir,
    'orderdir' => $orderdir));

function makeSafe($orderby) {
    if ($orderby != 'cocktailname' && $orderby != 'rating' && $orderby != 'price') {
        return 'cocktailname';
    }
    return $orderby;
}

function makeDirSafe($orderdir){
    if($orderdir != 'asc' && $orderdir != 'desc'){
        return 'asc';
    }
    return $orderdir;
}

function reverseDir($dir){
    if($dir == 'desc'){
        return 'asc';
    }
    return 'desc';
}