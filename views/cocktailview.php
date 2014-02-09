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
    <input readonly = <?php $data->editable?> 
    <?php echo "Nimi: ", $data->name ?>>
    <?php echo "Nimi: ", $data->name ?><br>
    <?php echo "Arvosana: ", $data->rating ?><br>
    <?php echo "Hinta: ", $data->price ?><br>
</div>

    <button type ="submit" name="edit">Muokkaa</button>
</form>

