<!DOCTYPE html>
<div class="container">
    <form name="input" action="dologin.php" method="POST">

        <div class="form-group">
            <label class="control-label" for="user">Käyttäjänimi</label>
            <input type="text" class="form-control" id="user" placeholder="käyttäjänimi" name="user" value="<?php echo $data->user; ?>">
        </div>

        <div class="form-group">
            <label for="password">Salasana</label>
            <input type="password" class="form-control" id="password" placeholder="Salasana" name="password">
        </div>

        <button type="submitbutton" class="btn btn-primary" name="submitbutton">Kirjaudu</button>
        <button type="submitbutton" class="btn btn-default" name="registerbutton">Rekisteröidy</button>
    </form>
</div>