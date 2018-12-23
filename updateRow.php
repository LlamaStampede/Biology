<!Doctype html>
<html>
    <body>
        <?php
            $id = $_GET['id'];
            $type = $_GET['type'];
            $text = $_GET['text'];
            $list = $_GET['list'];
            $linebreaks = $_GET['linebreaks'];
            $default = str_repeat("0", strlen($linebreaks));
        
            $server = 'sql9.freemysqlhosting.net';
            $user = 'sql9262759';
            $pass = '4fE3cl8Jqm';
            $db = 'sql9262759';
            $connection = mysqli_connect($server, $user, $pass, $db);
        
            $result = mysqli_query($connection, "UPDATE GroupedNotes SET text='$text', linebreaks='$linebreaks', highlights='$default', bolds='$default', underlines='$default' WHERE id = '$id';");
        
$lastSectionType = "";
$linesInList = 0;
$amountOfLists = 0;
$currentList = array(0, 0, 0, 0);
$bigList = array(array(1, 2, 3, 4, 5, 6, 7, 8, 9), array("a", "b", "c", "d", "e", "f", "g", "h"), array("i", "ii", "iii", "iv", "v", "vi", "vi", "vii"));
$firstSection = true;
$firstWord = true;
//while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    //$id = $row['id'];
    //$type = $row['type'];
    //$chapter = $row['chapter'];
    $isList = false;
    //echo "<div class='Section' id='Section$id' data-type='$type' data-chapter='$chapter' contenteditable='false' ondblclick='doubleclick(this)' onfocusout='focusOUT(this)'>"; //Create the section's div
    echo "<br>";
    if (substr($type, 0, 9) == "LIST_ITEM") { //Check if section is a list
        $isList = true;
        $listType = substr($type, -1);
        //$previousType;
        /*if (substr($lastSectionType, 0, 9) == "LIST_ITEM") { //Check if previous section was a list
            $previousType = substr($lastSectionType, -1);
        }
        else {
            $amountOfLists++;
            $currentList = array(0, 0, 0, 0);
            $linesInList = 0;
        }*/
    }
    
    
    
    //$text = $row['text'];
    $separatedText = explode(" ", $text);
    $sL = explode(",", $list);
    $currentList = array($sL[0], $sL[1], $sL[2], 0);
    $linebreaks = str_split($linebreaks);
    $underlines = str_split($default);
    $bolds = str_split($default);
    $highlights = str_split($default);
    for ($i=0; $i<count($separatedText); $i++) { //Iterate through each word applying all information
        $styleClasses = "";
        $dataColor = "";
        if ($highlights[$i] != 0) {
            $styleClasses .= " highlight";
            $dataColor = " data-color=" . $color[$highlights[$i]];
        }
        if ($bolds[$i] != 0) {
            $styleClasses .= " bold";
        }
        if ($underlines[$i] != 0) {
            $styleClasses .= " underline";
        }
        if ($linebreaks[$i] != 0) {
            if ($firstWord) {
                $firstWord = false;
            }
            else {
                echo "<br>";
            }
            if ($isList) {
                echo "<span class='list' id='List$amountOfLists.$linesInList'>" . $bigList[$listType-1][$currentList[$listType-1]] . ") </span>";
                $linesInList++; 
                $currentList[substr($type, -1)-1]++;
                $currentList[substr($type, -1)] = 0;
                $currentList[substr($type, -1)+1] = 0;
            }
        }
    
        echo "<span class='word$styleClasses' onclick='checkDictionary(this.innerHTML, this.id)'$dataColor id='Word$id.$i'>" . $separatedText[$i] . " </span>";
        
    
    }
    
    
  
    if ($firstSection) {
        $firstSection = false;
    }
    
    
    
    
    
    
    //echo "</div>"; //End the section's div
    //$lastSectionType = $type;
    //}
        ?>
    </body>
</html>