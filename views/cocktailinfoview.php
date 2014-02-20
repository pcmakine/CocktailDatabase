<!DOCTYPE html>
<form name="edit" action="cocktailinfo.php?id=<?php echo $data->cocktail->getId() ?>" method="POST">
    <div class="row">
        <div class="col-xs-4">
            <div id ="recipe"><label class="control-label" for="recipefield">Valmistusohje:</label><textarea class="form-control" id="recipefield" cols=45 rows=20 name="recipe" <?php if (!$data->editable): ?>readonly <?php endif; ?> 
                                                                                                             ><?php if (strlen($data->cocktail->getRecipe()) == 0) { ?>Drinkille ei ole vielä lisätty reseptiä!<?php
                                                                                                                 } else {
                                                                                                                     echo $data->cocktail->getRecipe();
                                                                                                                 }
                                                                                                                 ?></textarea><br></div>
            <?php if ($data->accessrights): ?><div>
                    <?php if (!$data->editable): ?>
                        <button class="btn btn-default" type ="submit" name="edit" id="edit" >Muokkaa</button>
                    <?php endif; ?>
                    <button class="btn btn-default" type ="submit" name="removebutton" id="remove">Poista</button>
                    <?php if ($data->cocktail->getSuggestion()): ?>
                        <button class="btn btn-default" type ="submit" name="acceptsuggestion" id="save">Hyväksy ehdotus</button>
                    <?php endif; ?>
                    <?php if ($data->editable): ?>       <!--        means that the edit button has been pressed -> we can show the save button-->
                        <button class="btn btn-default" type ="submit" name="savebutton" id="save">Tallenna</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-xs-2">
            <div class ="infofields">
                <label class="control-label" for="name"> Nimi: </label><input class="form-control" type="text" id="name" name="name"
                                                                              value="<?php echo $data->cocktail->getName() ?>"<?php if (!$data->editable) { ?> 
                                                                                  readonly>
                <?php } ?> <br>

                <label class="control-label" for="price"> Arvioitu Hinta: </label><input class="form-control"  type="text" name="price" id="price" pattern="\d*\.?\d*" title="Syötteen täytyy olla numeerinen"
                                                                                         value="<?php echo $data->cocktail->getPrice() ?>"<?php if (!$data->editable) { ?> 
                                                                                             readonly>
                <?php } ?><br>
                <label class="control-label" for="rating"> Arvosana: </label><input class="form-control"  type="text" name="rating" id="rating" value="<?php echo $data->cocktail->getRating() ?>"
                                                                                    pattern="[1-5]" title="Arvosanan täytyy olla välillä 1-5" readonly>
                                                                                    <?php if ($data->accessrights): ?>
                    <label class="control-label" for="suggestion">Ehdotus</label><input class="form-control"  type="text" name="suggestion" id="suggestion"
                                                                                        value="<?php echo ($data->cocktail->getSuggestion()) ? 'kyllä' : 'ei' ?>" readonly>
                                                                                    <?php endif; ?>
            </div>
        </div>

        <div class="col-xs-3">
            <div class ="ingredientfields">
                <?php for ($i = 0; $i < count($data->ingredients); $i++) { ?>


                    <label class="control-label" for="ingredient <?php echo($i + 1) ?>"> Ainesosa <?php echo $i + 1 ?> </label>
                    <div class ="input-group">
                        <input class="form-control" type="text" id="ingredient <?php echo($i + 1) ?>" name="ingredient[]" maxlength="40"
                               value="<?php echo $data->ingredients[$i] ?>"<?php if (!$data->editable) { ?> 
                                   readonly           
                               <?php } ?>>

                        <?php if ($data->editable): ?>
                            <div class="input-group-btn">
                                <button class="btn btn-default" id ="removebutton" type ="submit" name="removebtns[]" value="<?php echo $i ?>">Poista</button>
                            </div>
                        <?php endif; ?>
                    </div>


                <?php } ?>
                <?php if ($data->editable): ?><br>

                    <button type ="submit" class="btn btn-default" name="addingredientbutton" id="addingredient">Lisää uusi ainesosa</button>

                <?php endif; ?></div><br>

        </div>
    </div>

    <?php
    if (!empty($data->error)):
        ?>
        <div class="alert alert-danger"> 
            <?php echo $data->error; ?><br>
            <button class="btn btn-default" type ="submit" name="confirmremove" id="remove">Kyllä</button>
            <button class="btn btn-default" type ="submit" name="cancelremove" id="cancelremove">Peruuta</button>
        </div>

    </form>
<?php endif; ?>


