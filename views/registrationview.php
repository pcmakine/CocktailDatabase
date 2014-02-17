<!DOCTYPE html>

<h4><b>Rekisteröityminen</h4>
<form name="input" action="registration.php" method="POST">
    <label for="user">Käyttäjänimi:</label> <input id ="user" type="text" value="<?php echo $data->user; ?>"name="user" maxlength="30">
    <label for="password">Salasana:</label> <input id="password" type="password" name="password" maxlength="20">
    <label for="secondpassword">Salasana uudestaan:</label> <input id="secondpassword" type="password" name="secondpassword" maxlength="20">
    <button type="submit" name="submitbutton">Login</button>

</form>