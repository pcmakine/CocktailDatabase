<!DOCTYPE html>
<head>
    <link href="css/cocktail.css" rel="stylesheet">
</head>
<form name="edit" action="cocktailinfo.php?id=<?php echo $data->id ?>" method="POST">
    <div id ="recipe"><textarea cols=45 rows=10 name="recipe" <?php if (!$data->editable): ?>readonly <?php endif; ?> 
                                ><?php if (strlen($data->recipe) == 0) { ?>Drinkille ei ole vielä lisätty reseptiä!<?php
} else {
    echo $data->recipe;
}
?></textarea></div>
    <div class ="infofields">
        <label for="name"> Nimi: </label><input type="text" id="name" name="name"
                                                value="<?php echo $data->name ?>"<?php if (!$data->editable) { ?> 
                                                readonly>
        <?php } ?> <br>

        <label for="price"> Arvioitu Hinta: </label><input type="text" name="price" id="price" pattern="\d*\.?\d*" title="Syötteen täytyy olla numeerinen"
                                                           value="<?php echo $data->price ?>"<?php if (!$data->editable) { ?> 
                                                               readonly>
        <?php } ?><br>
        <label for="rating"> Arvosana: </label><input type="text" name="rating" id="rating" value="<?php echo $data->rating ?>"
                                                      pattern="[1-5]" title="Arvosanan täytyy olla välillä 1-5" readonly>
    </div>

    <div class ="ingredientfields">
        <?php for ($i = 0; $i < count($data->ingredients); $i++) { ?>
            <label for="ingredient <?php echo($i+1)?>"> Ainesosa <?php echo $i+1?> </label><input type="text" id="name" name="name"
                                                           value="<?php echo $data->ingredients[$i]->getName() ?>"<?php if (!$data->editable) { ?> 
                                                               readonly>
            <?php } ?> <br>
        <?php } ?>

    </div>

    <?php if ($data->accessrights): ?>
        <div>
            <button type ="submit" name="edit" id="edit" >Muokkaa</button>
            <button type ="submit" name="removebutton" id="remove">Poista</button>
            <?php if ($data->editable): ?>       <!--        means that the edit button has been pressed -> we can show the save button-->
                <button type ="submit" name="savebutton" id="save">Tallenna</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
    if (!empty($data->error)):
        ?>
        <div class="alert alert-danger"> 
            <?php echo $data->error; ?><br>
            <button type ="submit" name="confirmremove" id="remove">Kyllä</button>
            <button type ="submit" name="cancelremove" id="remove">Peruuta</button>
        </div>
    </form>
<?php endif; ?>



