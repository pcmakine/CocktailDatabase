<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $data->title; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href = "css/main.css" rel = "stylesheet">
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
    </head>
    <body>
        <div class = "container">
                <h1><a id="mainlink" href="dologin.php">Drinkkiarkisto</a></h1>

                <?php require $page; ?>

                <?php
                if (!empty($data->error)):
                    ?>
                    <div class="alert alert-danger"><?php echo $data->error; ?></div>
                <?php endif; ?>

        </div>
    </body>
</html>

