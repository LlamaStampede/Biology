<!Doctype html>
<html>
    <head>
    
    
    </head>
    <body>
        <?php
        $id = $_GET['id'];
        $style = $_GET['style'];
        $change = $_GET['change'];
        $style = $style . "s";
        echo "ID: $id \nSTYLE: $style \nCHANGE: $change\n";
        if (substr($id, 0, 4) == "Word") {
            $idparts = explode('.',substr($id, 4)); //Section, Word
        }
        echo "IDPARTS: $idparts[0]\n, $idparts[1]\n";
        
        
        //Here i am writing the code for the update from a button click.
        $server = 'sql9.freemysqlhosting.net';
        $user = 'sql9262759';
        $pass = '4fE3cl8Jqm';
        $db = 'sql9262759';
        $connection = mysqli_connect($server, $user, $pass, $db);
    
        $theRow = mysqli_query($connection, "SELECT $style FROM GroupedNotes WHERE id=$idparts[0];");
        $previousRow;
        while($row = mysqli_fetch_array($theRow, MYSQLI_ASSOC)) {
            $previousRow = $row[$style];
        }
        echo $previousRow . "\n";
        $previousRow[$idparts[1]] = $change;
        echo $previousRow . "\n";
        $result = mysqli_query($connection, "UPDATE GroupedNotes SET $style = '$previousRow' WHERE id=$idparts[0];");
        ?>
    </body>
</html>