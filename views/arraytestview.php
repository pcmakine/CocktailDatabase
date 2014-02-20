<html>
    <body>
        <form name="frmUserDetails" method="post" action="arraytest.php">
            Name: <input type="text" name="txtName[]" id="txtName_1" value="<?php echo $data->array['0'] ?>" /><br />
            Name: <input type="text" name="txtName[]" id="txtName_2" /><br />
            Name: <input type="text" name="txtName[]" id="txtName_3" /><br />
            <input type="submit" name="btnSubmit" value="Submit" />
            <input type="reset" name="btnReset" value="Reset" />
        </form>
    </body>
</html>