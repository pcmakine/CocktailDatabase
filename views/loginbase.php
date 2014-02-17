<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $data->title; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href = "css/login.css" rel = "stylesheet">
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
    </head>
    <body>
        <div id = "container">
            <div id = "header">
                <h1>Drinkkiarkisto</h1>
                <?php if ($page == 'views/dologinview.php'): ?>
                    <a id="registerlink" href="registration.php">Rekisteröidy</a>
                <?php endif; ?>
                <?php require $page; ?>

                <?php
                if (!empty($data->error)):
                    ?>
                    <div class="alert alert-danger"><?php echo $data->error; ?></div>
                <?php endif; ?>
            </div>


        </div>
    </body>
</html>

