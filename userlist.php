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
    if (isset($_POST['addRights'])) {
        foreach ($_POST['addRights'] as $buttonid) {
            if (isset($buttonid)) {
                $user = $list[$buttonid];
                $user->addAccessRights();
                $list = user::getUsers();
                $data['list'] = $list;
            }
        }
        $_SESSION['announcement'] = "Ylläpito-oikeudet lisätty käyttäjälle " . $user->getUsername();
    }
    
    showView('userlistview.php', $data);
} else {
    header('Location: frontpage.php');
}



