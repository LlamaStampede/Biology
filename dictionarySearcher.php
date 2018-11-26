<!Doctype html>
<html>
    <head>
    
    </head>
    <body>
        <?php
            $id = $_GET['id'];
            $text = $_GET['text'];
            
            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
            
            $result = mysqli_query($connection, "SELECT * FROM dictionary WHERE LOWER(word) LIKE '%$text%' AND NOT id='$id';");
            if (mysqli_num_rows($result) > 0) {
                echo "<div id='definitionHeader'>Definitions:</div><br>";
            }
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $word = $row['word'];
                $definition = $row['definition'];
                $firstChapter = $row['first_chapter'];
                $id = $row['id'];
                echo "<div class='definition' id='DEF_$id'> <span class='DEF_term' id='TERM_$id'>$word</span>: $definition <br>First Chapter: $firstChapter</div><br>";
            }
        
            //$headings = mysqli_query($connection, "SELECT id, text, chapter FROM GroupedNotes WHERE LOWER(text) LIKE '%$text%' AND (type LIKE 'Heading _' OR type LIKE '%Title';");
            $headings = mysqli_query($connection, "SELECT id, text, chapter FROM GroupedNotes WHERE LOWER(text) LIKE '%$text%';");// AND (type LIKE 'Heading _' OR type LIKE '%Title';");
            if (mysqli_num_rows($headings) > 0) {
                echo "<div id='definitionHeader'>Related Headings:</div><br>";
            }
            while($row = mysqli_fetch_array($headings, MYSQLI_ASSOC)) {
                $text = $row['text'];
                $chapter = $row['chapter'];
                $id = $row['id'];
                echo "<div class='headingFinder' id='HEAD_$id' onclick='showSection($id, $chapter)'> $text <br>Chapter: $chapter</div><br>";
            }
        ?>
    </body>
</html>