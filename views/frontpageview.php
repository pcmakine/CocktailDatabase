<div id = tableArea>
    <form action="frontpage.php" method="GET">
        <div class ="input-group">
            <input class="form-control" placeholder="etsi drinkin nimellä" type="text" name="search" value="<?php echo $data->searchterm ?>">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default" name="searchbutton">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
    <table class="table table-striped table-bordered">
        <tr>
            <th><a href="<?php echo "frontpage.php?page=1&" . ($data->restriction) . "&search=" . ($data->searchterm) . "&orderby=cocktailname"?>">Nimi</a></th>
            <th><a href="<?php echo "frontpage.php?page=1&" . ($data->restriction) . "&search=" . ($data->searchterm) . "&orderby=rating"?>">Arvosana</a></th>
            <th><a href="<?php echo "frontpage.php?page=1&" . ($data->restriction) . "&search=" . ($data->searchterm) . "&orderby=price"?>">Hinta euroa/annos</a></th>
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
            <li><a href="<?php echo "frontpage.php?page=" . ($data->page - 1) . "&" .
                    ($data->restriction) . "&search=" . ($data->searchterm) . "&orderby=" . ($data->orderby)?>">Edellinen</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i < $data->pagestotal + 1; $i++) { ?>          
            <li <?php if ($data->page == $i): ?>     
                    class="active"
                <?php endif; ?>>  
                <a href="<?php echo "frontpage.php?page=" . $i . "&" . ($data->restriction) . 
                        "&search=" . ($data->searchterm) . "&orderby=" . ($data->orderby) ?>"><?php echo $i ?></a>
            </li> 
            <?php
        }
        if ($data->page < $data->pagestotal):
            ?>
            <li><a href="<?php echo "frontpage.php?page=" . ($data->page + 1) . "&" .
                    ($data->restriction) . "&search=" . ($data->searchterm) . "&orderby=" . ($data->orderby)?>">Seuraava</a></li>
        <?php endif; ?>
    </ul>  
</div>
Yhteensä <?php echo $data->numofcocktails; ?> drinkkiä. 
Olet sivulla <?php echo $data->page; ?>/<?php echo $data->pagestotal; ?>.

<?php if ($data->accessrights): ?>
    <form action="frontpage.php" method="GET">
        <button class="btn btn-default"  type="submit" name="getAll"> Näytä kaikki </button>
        <button class="btn btn-default"  type="submit" name="getSuggestions"> Näytä vain ehdotukset </button>
    </form>

<?php endif; ?>