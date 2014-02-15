<!DOCTYPE html>
<head>
    <link href="css/addcocktail.css" rel="stylesheet">
</head>
<form name="submitnewdrink" action="addcocktail.php" method="POST">
    <div> 
        <label for="name" class="required">Drinkin nimi </label><input type="text" name="name" id="name" maxlength="50" required value="<?php echo$data->cocktailname ?>" title="Nimi on pakollinen!">
        <label for="rating">Arvosana</label><input type = "text" value="<?php echo$data->rating ?>" name ="rating" id ="rating" pattern="[1-5]" title="Arvosanan täytyy olla välillä 1-5" >
        <label for="price">Arvioitu hinta</label><input type="text" name="price" id="price" value="<?php echo$data->price ?>" pattern="\d*\.?\d*" title="Syötteen täytyy olla numeerinen">

        <?php for ($i = 0; $i < (count($data->ingredients) + 1); $i++) { ?>
                <label for="ingredient<?php ($i + 1) ?>"
                       >Ainesosa <?php echo ($i + 1) ?></label>
                <input type="text" name="ingredient[]" value="<?php echo $data->ingredients[$i] ?>"
                       id="ingredient<?php ($i + 1) ?>" maxlength="40">
            <?php 
               }
               ?><br>

        <button type ="submit" name="addingredientbutton">Lisää uusi ainesosa</button>

        <label for="recipe">Valmistusohje</label>
        <textarea rows="10" cols="44" name="recipe" id="recipe" maxlength="1000"> <?php echo trim($data->recipe)?></textarea> <br>

        <button type = submit name="savebutton" ><?php
        if ($data->accessrights) {
            echo "Tallenna uusi drinkki"
                   ?><?php } else { ?>
                <?php echo "Tallenna ehdotus" ?></button>
        <?php } ?>
    </div>
</form>     

<div id="content">

    <?php
    if (!empty($data->error)) {
        ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
        <?php
    }
    ?>
</div>