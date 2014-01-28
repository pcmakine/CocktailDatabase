<?php
//require_once sisällyttää annetun tiedoston vain kerran
require_once "libs/models/user.php"; 

//Lista asioista array-tietotyyppiin laitettuna:
$list = user::getUsers();
$password = user::getPassword();

?><!DOCTYPE HTML>
<html>
    <head><title>Otsikko</title> </head>
    <body>
        <h1>Käyttäjälista</h1>
        <ul>
            <?php foreach($list as $asia){ ?>
            <li><?php echo "username: ", $asia->getUsername(), ", accessrights: ", $asia -> getRights(); ?></li>
            <?php } ?> 
        </ul>

    </body>
</html>
