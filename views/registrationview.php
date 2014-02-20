<!DOCTYPE html>
    <a id="loginlink" href="dologin.php">&#171;-Takaisin kirjautumissivulle</a>
    <h4><b>Rekisteröityminen</h4>

<form name="input" action="registration.php" method="POST">

    <div class="form-group">
        <label class="control-label" for="user">Käyttäjänimi</label>
        <input type="text" class="form-control" id="user" placeholder="käyttäjänimi" name="user" value="<?php echo $data->user; ?>">
    </div>

    <div class="form-group">
        <label for="password">Salasana</label>
        <input type="password" class="form-control" id="password" placeholder="Salasana" name="password">
    </div>

    <div class="form-group">
        <label for="secondpassword">Salasana uudelleen</label>
        <input type="password" class="form-control" id="secondpassword" placeholder="Salasana" name="secondpassword">
    </div>

    <button type="submitbutton" class="btn btn-primary" name="submitbutton">Kirjaudu</button>
</form>