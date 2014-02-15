<!DOCTYPE html>
<html>
    <head>
        <title>Drinkkiarkisto</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/nav.css" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>

    <body>

        <?php
        if ($data->accessrights == 'a') {
            $addCocktailsText = 'Lisää drinkkejä tietokantaan';
        } else {
            $addCocktailsText = 'Ehdota uutta drinkkiä';
        }
        ?>
        <div id ="header">
            <a id="mainlink" href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/frontpage.php"><h1>Drinkkiarkisto</h1></a>
            <a id ="signout"href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/logout.php">Kirjaudu ulos</a>
            <ul class="nav nav-tabs">
                <li <?php if ($page == 'front.php') { ?>
                        class="active">
                        <a href="#">Drinkit</a></li>
                <?php } else { ?>
                    <li><a href="frontpage.php">Drinkit</a></li>
                <?php } ?>
                <li <?php if ($page == 'addcocktailview.php') { ?>
                        class="active">
                        <a href="#"><?php echo $addCocktailsText ?></a></li>
                <?php } else { ?>
                    <li><a href="addcocktail.php"><?php echo $addCocktailsText ?></a></li>
                    <?php } ?>
                </ul>

            </div>
            <?php require $page; ?>

            <?php if (!empty($_SESSION['announcement'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['announcement']; ?>
                </div>
                <?php
                // Samalla kun viesti näytetään, se poistetaan istunnosta,
                // ettei se näkyisi myöhemmin jollain toisella sivulla uudestaan.
                unset($_SESSION['announcement']);
                ?>
            <?php endif; ?>
    </body>
</html>