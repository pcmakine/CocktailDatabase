<!DOCTYPE html>
<head>
    <link href="css/addcocktail.css" rel="stylesheet">
</head>
<form name="submitnewdrink" action="addcocktail.php" method="POST">
    <div> 
        <label for="name" class="required">Drinkin nimi </label><input type="text" name="name" id="name" maxlength="20" required>
        <label for="rating">Arvosana</label><input type = "text" name ="rating" id ="rating">
        <label for="price">Arvioitu hinta</label><input type="text" name="price" id="price">

        <label for="recipe">Valmistusohje</label>
        <textarea rows="10" cols="44" name="recipe" id="recipe" maxlength="1000"></textarea> <br>

        <button type = submit name="savebutton" ><?php
if ($data->accessrights == 'a') {
    echo "Tallenna uusi drinkki"
   ?><?php } else { ?>
                <?php echo "Tallenna ehdotus" ?></button>
        <?php } ?>
    </div>
</form>     

<div id="content">

    <?php
    if (!empty($data->error)):
        ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
</div>