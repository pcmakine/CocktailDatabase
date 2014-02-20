<div class="container">
    <div id = tableArea>
        <input type="text" name="input" placeholder = "etsi drinkkejä">

        <table class="table table-striped table-bordered">
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
                        <td><?php echo $cocktail->getSuggestion() ? 'kyllä' : 'ei'; ?></td>
                    <?php endif; ?>
                </tr>
            <?php } ?> 
        </table>
    </div>

    <div >  
        <ul class="pagination">  
            <?php if ($data->page > 1): ?>
                <li><a href="frontpage.php?page=<?php echo($data->page - 1) ?>">Edellinen</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i < $data->pagestotal + 1; $i++) { ?>          
                <li <?php if ($data->page == $i): ?>     
                        class="active"
                    <?php endif; ?>>  
                    <a href="frontpage.php?page=<?php echo$i ?>"><?php echo $i ?></a>  
                </li> 
            <?php
            }
            if ($data->page < $data->pagestotal):
                ?>
                <li><a href="frontpage.php?page=<?php echo($data->page + 1) ?>">Seuraava</a></li>
<?php endif; ?>
        </ul>  
    </div>
    Yhteensä <?php echo $data->numofcocktails; ?> drinkkiä. 
    Olet sivulla <?php echo $data->page; ?>/<?php echo $data->pagestotal; ?>.

<?php if ($data->accessrights): ?>
        <form name="submitnewdrink" action="frontpage.php" method="GET">
            <button class="btn btn-default"  type="submit" name="getAll"> Näytä kaikki </button>
            <button class="btn btn-default"  type="submit" name="getSuggestions"> Näytä vain ehdotukset </button>
        </form>

<?php endif; ?>
</div>