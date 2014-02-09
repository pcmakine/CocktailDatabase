<!DOCTYPE html>
<html>
    <head>
        <title><?php $data->title; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/nav.css" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div id ="header">
            <h1>Drinkkiarkisto</h1>
            <a id ="signout"href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/logout.php">Kirjaudu ulos</a>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">Drinkit</a></li>
                <?php if($data -> accessrights == 'a'){?>
                    <li><a href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/html-demo/suggest.html#">Lisää drinkkejä tietokantaan</a></li>
                <?php }else{?>
                    <li><a href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/html-demo/suggest.html#">Ehdota uutta drinkkiä</a></li>
               <?php }?>
            </ul>

        </div>
        <?php require $page; ?>
    </body>
</html>