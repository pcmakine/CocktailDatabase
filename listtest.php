<?php
$list = array("kirahvi", "trumpetti", "jeesus", "parta");
?>

<!DOCTYPE HTML>
<html>
    <head><title>Otsikko</title> </head>
    <body>
        <h1>Listaelementtitesti</h1>
        <ul>
            <?php foreach($list as $asia){ ?>
            <li><?php echo $asia; ?></li>
            <?php } ?>
        </ul>
    </body>
</html>



