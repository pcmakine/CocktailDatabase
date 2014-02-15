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
                <?php if ($data->accessrights): ?>
                    <th>Ehdotus</th>
                <?php endif; ?>
            </tr>

            <?php foreach ($data->list as $cocktail) { ?>
                <tr>
                    <td><a href="cocktailinfo.php?id=<?php echo $cocktail->getId() ?>"><?php echo $cocktail->getName() ?></a></td>
                    <td><?php echo $cocktail->getRating(); ?></td>
                    <td><?php echo $cocktail->getPrice(); ?></td>
                    <?php if ($data->accessrights): ?>
                        <td><?php echo $cocktail->getSuggestion(); ?></td>
                    <?php endif; ?>
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
Olet sivulla <?php echo $data->page; ?>/<?php echo $data->pagestotal; ?>.<br>

<?php if ($data->accessrights): ?>
<form name="submitnewdrink" action="addcocktail.php" method="POST">
    <button type="submit" name="getSuggestionsButton"> Näytä vain ehdotukset </button>
</form>

<?php endif; ?>
</form>
