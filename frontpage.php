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

$list;
$numofcocktails;

if(getUserAccessRights()){
    $list= cocktail::getCocktails($perpage, $page);
    $numofcocktails = cocktail::numofCocktails();
}else{
    $list = cocktail::getApprovedCocktails($perpage, $page);
    $numofcocktails = cocktail::numofApprovedCocktails();
}

$pagestotal = ceil($numofcocktails / $perpage);

$accessrights = getUserAccessRights();

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


