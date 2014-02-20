<!DOCTYPE html>


<p><?php echo "Hei " . $_SESSION['signedin'] . "! Vaihtaaksesi salasanasi täytä uusi salasana alla oleviin kenttiin ja paina tallenna"; ?></p>


<form name="input" action="changepassword.php" method="POST">

    <div class="form-group">
        <label for="password">Salasana</label>
        <input type="password" class="form-control" id="password" placeholder="Salasana" name="password">
    </div>

    <div class="form-group">
        <label for="secondpassword">Salasana uudelleen</label>
        <input type="password" class="form-control" id="secondpassword" placeholder="Salasana" name="secondpassword">
    </div>

    <button type="submitbutton" class="btn btn-primary" name="submitbutton">Tallenna uusi salasana</button>
</form>
<div class ="alert alert-warning">
    <?php echo 'Otathan huomioon että salasanat tallennetaan tietokantaan selväkielisinä'; ?><br>
</div>