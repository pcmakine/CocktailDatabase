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

$list = cocktail::getCocktails($perpage, $page);

$numofcocktails = cocktail::numofCocktails();
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


