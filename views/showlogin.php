
<form name="input" action="dologin.php" method="POST">
    <label for="user">Käyttäjänimi:</label> <input id ="user" type="text" value="<?php echo $data->user; ?>"name="user">
    <label for="password">Salasana:</label> <input id="password" type="password" name="password">
    <button type="submit" name="submitbutton">Login</button>
</form>

<div id="content">

    <?php
    if (!empty($data->error)):
        ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
</div>

</html>