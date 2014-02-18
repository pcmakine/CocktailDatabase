<?php

require_once 'libs/common.php';
require_once "libs/models/user.php";

//Lista asioista array-tietotyyppiin laitettuna:
$list = user::getUsers();
$data = array('list' => $list,
    'accessrights' => getUserAccessRights());

if (!isSignedIn()) {
    header('Location: dologin.php');
} else if (getUserAccessRights()) {
    $user;
    $announcement;
    if (isset($_POST['addRights'])) {
        $user = $list[getPressedButton($_POST['addRights'])];
        $user->updateAccessRights(1);
        $announcement = "Ylläpito-oikeudet lisätty käyttäjälle " . $user->getUsername();
    } else if (isset($_POST['removeRights'])) {
        $user = $list[getPressedButton($_POST['removeRights'])];
        $user->updateAccessRights(0);
        $announcement = "Ylläpito-oikeudet poistettu käyttäjältä " . $user->getUsername();
    }

    $list = user::getUsers();
    $data['list'] = $list;
    $_SESSION['announcement'] = $announcement;
    showView('userlistview.php', $data);
} else {
    header('Location: frontpage.php');
}

function getPressedButton($array) {
    foreach ($array as $buttonid) {
        if (isset($buttonid)) {
            return $buttonid;
        }
    }
}

