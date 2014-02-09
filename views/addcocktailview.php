<!DOCTYPE html>
<head>
    <link href="css/addcocktail.css" rel="stylesheet">
</head>
<form name="submitnewdrink" action="addcocktail.php" method="POST">
    <div> 
        <label>Drinkin nimi </label><input type="text" name="name" id="name">
        <label>Arvosana</label><input type = "text" name ="rating" id ="rating">
        <label>Arvioitu hinta</label><input type="text" name="price">

        <p>Valmistusohje</p>
        <textarea rows="10" cols="44" name="recipe">

        </textarea> <br>

        <button type = submit ><?php
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