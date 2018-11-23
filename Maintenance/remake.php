<!DOCTYPE html>

<html>

    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <title>Main page</title>

    </head>


    <?php
        $server = 'sql9.freemysqlhosting.net';
        $user = 'sql9262759';
        $pass = '4fE3cl8Jqm';
        $db = 'sql9262759';
        $connection = mysqli_connect($server, $user, $pass, $db);

        /*$createNewDB = mysqli_query($connection, "CREATE TABLE GroupedNotes (id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                                             text TEXT,
                                                                             type VARCHAR(20),
                                                                             chapter TINYINT UNSIGNED,
                                                                             linebreaks VARCHAR(20),
                                                                             highlights VARCHAR(255),
                                                                             bolds VARCHAR(255),
                                                                             underlines VARCHAR(255));");*/
        $result = mysqli_query($connection, "SELECT * FROM Notes;");
        $clear = mysqli_query($connection, "TRUNCATE TABLE GroupedNotes;");
    
        $currentType = NULL;
        $currentID = 1;
        $currentText = "";
        $currentChapter = 0;
        $previousLine = 0;
        $linebreaks = "";
        $highlights = "";
        $bolds = "";
        $underlines = "";
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $type = $row['headerType'];
            $line = $row['line'];
            //echo $type . "<br>";
            if ($currentType == NULL) { //If first row
                $currentType = $type;
                //echo "first\n";
            }
            
            //echo $currentID . "<br>";
            if ($currentType != $type) {
                $add = mysqli_query($connection, "INSERT INTO GroupedNotes VALUES ('$currentID', '$currentText', '$currentType', '$currentChapter', '$linebreaks', '$highlights', '$bolds', '$underlines')");
                //echo "INSERT INTO GroupedNotes ('id', 'text', 'type', 'chapter', 'linebreaks', 'highlights', 'bolds', 'underlines') VALUES ('$currentID', '$currentText', '$currentType', '$currentChapter', '$linebreaks', '$highlights', '$bolds', '$underlines')";
                $currentID++;
                $currentType = $type;
                $linebreaks = "";
                $highlights = "";
                $bolds = "";
                $underlines = "";
                $currentText = "";
                echo $currentID;
            }
            $currentText = $currentText . $row['word'] . " ";
            if ($previousLine == $line) {
                $linebreaks = $linebreaks . '0';
            }
            else {
                $linebreaks = $linebreaks . '1';
                $previousLine = $line;
            }
            $highlights = $highlights . $row['highlight'];
            $bolds = $bolds . $row['bold'];
            $underlines = $underlines . $row['underline'];
            $currentChapter = $row['chapter'];
        }
        echo "done";
        
    ?>

    <body>

    </body>
    
</html>