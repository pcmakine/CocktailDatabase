
<?php

require_once 'libs/common.php';
require_once 'libs/models/user.php';

$data = array('title' => 'Drinkkiarkisto - salasanan vaihto',
                'accessrights' => getUserAccessRights(),
                 'user' => $_SESSION['signedin']);

if (!isSignedIn()) {
     header('Location: dologin.php');
} 
if(!isset($_POST['submitbutton'])){
    showView('changepasswordview.php', $data);
}
if (empty($_POST["password"]) && isset($_POST['submitbutton'])) {
    $data['error'] = "Salasanan vaihto epäonnistui! Et antanut salasanaa.";
        showView('changepasswordview.php', $data);
}

if (empty($_POST["secondpassword"]) && isset($_POST['submitbutton'])) {
    $data['error'] = "Salasanan vaihto epäonnistui! Et antanut salasanaa toiseen kertaan.";
    showView("changepasswordview.php", $data);
}
if(isset($_POST['submitbutton'])){
    if(((htmlspecialchars($_POST["secondpassword"]) == htmlspecialchars($_POST["password"])))){
        user::changePassword(htmlspecialchars($_POST["password"]), $_SESSION['signedin']);
        $_SESSION['announcement'] = "Salasanan vaihto onnistui!";
        header('Location: frontpage.php');
    }else{
        $data['error'] = 'Salasanan vaihto epäonnistui! Salasanat eivät täsmää!';
        showView("changepasswordview.php", $data);
    }
    
}

