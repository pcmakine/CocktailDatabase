<?php

require_once 'libs/common.php';
require_once 'libs/models/cocktail.php';

$list = cocktail::getCocktails();

if (isSignedIn()) {
    showView('front.php', array('title' => "frontpage",
       'list' => $list ));
} else {
    header('Location: dologin.php');
}
