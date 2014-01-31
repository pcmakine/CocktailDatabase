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

        <?php
        foreach ($data->list as $asia) { ?>
            <tr>
                <td><a href="http://pcmakine.users.cs.helsinki.fi/cocktaildatabase/html-demo/info.html"><?php echo $asia -> getName(); ?></a></td>
                <td><?php echo $asia -> getRating();?></td>
                <td><?php echo $asia -> getPrice();?></td>
            </tr>
        <?php } ?> 

    </table>
</div>