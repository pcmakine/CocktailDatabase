<!DOCTYPE html>

<head>
    <link href="css/userlist.css" rel="stylesheet">
</head>

<div class="container">
    <h3>Käyttäjät:</h3>
    <form action="userlist.php" method="POST">
        <div id = tableArea>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Nimi</th>
                    <th>Ylläpito-oikeudet</th>
                </tr>

                <?php
                for ($i = 0; $i < count($data->list); $i++) {
                    $user = $data->list[$i];
                    ?>
                    <tr>
                        <td><?php echo $user->getUserName() ?></td>
                        <td><?php echo $user->getRights() ? 'kyllä' : 'ei' ?></td>
                        <?php if (!$user->getRights()) { ?>
                            <td class="lastcell"><button name="addRights[]" value="<?php echo $i ?>" class="btn btn-default" >Lisää ylläpito-oikeudet</button></td>
                        <?php } else if ($user->getUserName() != 'pete') {
                            ?>
                            <td class="lastcell"><button name="removeRights[]" value="<?php echo $i ?>" class="btn btn-default" >Poista ylläpito-oikeudet</button></td>
                        <?php } ?>

                    </tr>
                <?php } ?> 
            </table>

        </div>
    </form>
</div>