<!DOCTYPE html>
<head>
    <link href="css/cocktail.css" rel="stylesheet">
</head>
<div id ="recipe"><textarea readonly cols=30 rows=10><?php if (strlen($data->recipe) == 0) { ?>Drinkille ei ole vielä lisätty reseptiä!<?php          
        } else {
            echo $data->recipe
            ?>
        <?php } ?>
    </textarea></div>
<div class ="infofields">
    <?php echo "Nimi: ", $data->name ?><br>
    <?php echo "Arvosana: ", $data->rating ?><br>
    <?php echo "Hinta: ", $data->price ?><br>
</div>
