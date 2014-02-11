<head>
    <link href="css/front.css" rel="stylesheet">
</head>
<div id = tableArea>
    <input type="text" name="input" placeholder = "search for a drink">
    <table border="1">
        <tr>
            <th>Nimi</th>
            <th>Arvosana</th>
            <th>Hinta euroa/annos</th>
        </tr>

        <?php foreach ($data->list as $asia) { ?>
            <tr>
                <td><a href="cocktailinfo.php?id=<?php echo $asia->getId() ?>"><?php echo $asia->getName() ?></a></td>
                <td><?php echo $asia->getRating(); ?></td>
                <td><?php echo $asia->getPrice(); ?></td>
            </tr>
        <?php } ?> 
    </table>
</div>

<?php if ($data->page > 1): ?>
    <a href="frontpage.php?page=<?php echo $data->page - 1; ?>">Edellinen sivu</a>
<?php endif; ?>
<?php if ($data->page < $data->pagestotal): ?>
    <a href="frontpage.php?page=<?php echo $data->page + 1; ?>">Seuraava sivu</a>
<?php endif; ?>

    <br>Yhteensä <?php echo $data->numofcocktails; ?> drinkkiä. 
Olet sivulla <?php echo $data->page; ?>/<?php echo $data->pagestotal; ?>.