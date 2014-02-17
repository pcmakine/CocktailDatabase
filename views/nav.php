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
        if ($data->accessrights) {
            $addCocktailsText = 'Lisää drinkkejä tietokantaan';
        } else {
            $addCocktailsText = 'Ehdota uutta drinkkiä';
        }
        ?>
        <div id ="header">
            <a id="mainlink" href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/frontpage.php"><h1>Drinkkiarkisto</h1></a>
            <a id ="signout"href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/logout.php">Kirjaudu ulos</a>
            <ul class="nav nav-tabs">

                <li <?php if ($page == 'frontpageview.php') { ?>
                        class="active"
                    <?php } ?>>
                    <a href="frontpage.php">Drinkit</a></li>

                <li <?php if ($page == 'addcocktailview.php') { ?>
                        class="active"
                    <?php } ?>>
                    <a href="addcocktail.php"><?php echo $addCocktailsText ?> </a></li>

                <?php if ($data->accessrights): ?>
                    <li <?php if ($page == 'userlistview.php') { ?>
                            class="active"
                        <?php } ?>>
                        <a href="userlist.php">Hallinnoi käyttäjiä</a></li>
                <?php endif; ?>
            </ul>

        </div>
        <div class="content">

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
        </div>
    </body>
</html>