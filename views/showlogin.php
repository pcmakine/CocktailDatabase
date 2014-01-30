<!DOCTYPE html>

<head>
    <title>title</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.css" rel="stylesheet">
    <link href = "css/login.css" rel = "stylesheet">
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width">
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
</head>

<form name="input" action="dologin.php" method="POST">
    <label for="user">Käyttäjänimi:</label> <input id ="user" type="text" value="<?php echo $data->user; ?>"name="user">
    <label for="password">Salasana:</label> <input id="password" type="password" name="password">
    <button type="submit">Login</button>
</form>


<div id="content">

    <?php
    if (!empty($data->error)):
        ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
</div>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#">Drinkit</a></li>
            <li><a href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/html-demo/suggest.html#">Ehdota uutta drinkkiä</a></li>
        </ul>
</body>
</html>