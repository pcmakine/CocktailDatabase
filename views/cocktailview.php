<!DOCTYPE html>
<head>
    <link href="css/cocktail.css" rel="stylesheet">
</head>
<form name="edit" action="cocktailinfo.php" method="POST">
    <div id ="recipe"><textarea readonly cols=45 rows=10><?php if (strlen($data->recipe) == 0) { ?>Drinkille ei ole vielä lisätty reseptiä!<?php
} else {
    echo $data->recipe
   ?>
            <?php } ?>
        </textarea></div>
    <div class ="infofields">
        <label for="name"> Nimi: </label><input type="text" id="name" 
                                                value="<?php echo $data->name?>"<?php if (!$data->editable) { ?> 
                                                    readonly>
                                                <?php } ?> <br>
        
        <label for="price"> Hinta: </label><input type="text" id="price" 
                                                value="<?php echo $data->price?>"<?php if (!$data->editable) { ?> 
                                                    readonly>
                                                <?php } ?><br>
         <label for="rating"> Arvosana: </label><input type="text" id="rating" 
                                                value="<?php echo $data->rating?>" readonly>
    </div>

    <button type ="submit" name="edit">Muokkaa</button>
</form>

