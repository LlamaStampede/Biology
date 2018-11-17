<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

$chapters = json_decode($_GET['chapters']);
    
$partOfSQL = "";
for ($i=0;$i<count($chapters);$i++) {
    echo "$chapters[$i]";
    if ($i == 0) {
        $partOfSQL = $partOfSQL . " WHERE chapter = " . $chapters[$i];
    }
    elseif ($i == count($chapters)-1) {
        $partOfSQL = $partOfSQL . " OR chapter = " . $chapters[$i] . ";"; 
    }
    else {
        $partOfSQL = $partOfSQL . " OR chapter = " . $chapters[$i];
    }
    
}
 
echo $partOfSQL;
    
$server = 'sql9.freemysqlhosting.net';
$user = 'sql9262759';
$pass = '4fE3cl8Jqm';
$db = 'sql9262759';
$connection = mysqli_connect($server, $user, $pass, $db);


$result = mysqli_query($connection, "SELECT * FROM Notes" . $partOfSQL);
    
$colors = mysqli_query($connection, "SELECT * FROM Highlight;");
    
$color = array();
$colorId = 0;
while($row = mysqli_fetch_array($colors, MYSQLI_ASSOC)) {
    $color[$colorId] = $row['colors'];
    $colorId++;
}
    
// display data in table
$columns = mysqli_query($connection, "SHOW COLUMNS FROM Notes");
    
while($row = mysqli_fetch_array($columns, MYSQLI_ASSOC)) {
    $theColumns[] = $row['Field'];
}
$arrlength = count($theColumns);
    
$sections = 0;
$previousHeading = "";
$previousLine;
$currentList = array(0, 0, 0, 0);
$bigList = array(array(1, 2, 3, 4, 5, 6, 7, 8, 9), array("a", "b", "c", "d", "e", "f", "g", "h"), array("i", "ii", "iii", "iv", "v", "vi", "vi", "vii"));
echo "<div class='col6' style='padding-top:150px;'>";
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $section++;


// echo out the contents of each row into a table

//echo "<tr>";
    $headerType = $row['headerType'];
    if (substr($headerType, 0, 1) == "H") {
        $headerType = "Heading" . substr($headerType, -1);
    }
    $id = $row['id'];
    $chapter = $row['chapter'];
    $word = $row['word'];
    $line = $row['line'];
    $highlight = $color[$row['highlight']];
    $bold = $row['bold'];
    $underline = $row['underline'];
    $style = " style='";
    
    if ($highlight != 'none') {
        $style = $style . "background-color:$highlight;";
    }
    if ($bold != 0) {
        $style = $style . "font-weight:bold;";
    }
    if ($underline != 0) {
        $style = $style . "text-decoration:underline;";
    }
    
    $style = $style . "' ";
    
    $startSection = "<div class='Section' id='Section_$section' data-headingType='$headerType' data-chapter='$chapter'>";
    $endSection = "</div>";
    $startLine = "<div class='Line' id='Line_$line'>";
    $endLine = "</div>";
    
    //if ($headerType.substr(0,6) == "Heading" || substr($headerType, -4) == "itle") { //only headings & title & subtitle
    if ($id != 1) //not the first word
    {
        if ($headerType == $previousHeading) { //If the word before is the same header
            $section--;
            if ($previousLine == $line) { //If the previous word was on the same line
                echo "</span><span$style"; //end previous word's span start own word's span
            }
            else { //If the previous word is of the same type but it is now a new line
                echo "</span><br>"; //Different lines create and end line divs
                if (substr($headerType, 0, 9) == "LIST_ITEM") { //If it is a list
                    $indent = intval(substr($headerType, -1));
                    $previousSpot = $currentList[$indent-1];
                    echo "<span class='list$indent'>" . $bigList[$indent-1][$previousSpot] . ") </span><span$style";
                    $currentList[$indent-1] += 1;
                }
                else {//previous and current same on different lines and not a list
                    echo "<span$style"; //If wasn't same line 
                }
            }
        }
        elseif (substr($headerType, 0, 8) == substr($previousHeading, 0, 8)){//Both lists but not same indentation
            echo "</span>$endSection<br>$startSection<span$style"; 
            $indent = intval(substr($headerType, -1));
            if ($currentList[$indent-1] == 0) { //if it changes to farther indented
                echo "class='list$indent'>" . $bigList[$indent-1][0] . ") </span><span$style"; //$bigList[(int)indent-1][0]
                $currentList[$indent-1] += 1;
            }
            else { //if it changes to less indented
                $previousSpot = $currentList[$indent-1];
                echo "class='list$indent'>" . $bigList[$indent-1][$previousSpot] . ") </span><span$style";
                $currentList[$indent] = 0;
                $currentList[$indent+1] = 0;
                $currentList[$indent-1] += 1;
            }
        }
        else {
            if ($headerType == "LIST_ITEM1") { //if previous word wasn't a list and this word is a start of a list
                echo "</span></div><br>$startSection<span class='list1'>1) </span><span$style";
                $currentList = array(1,0,0,0);
            }
            elseif (substr($previousHeading, 0, 9) == "LIST_ITEM") {
                echo "</span>$endSection<br>$startSection<span$style";
            }
            else {
                echo "</span>$endSection<br>$startSection<span$style";   
            }
        }

    }
    else {
        echo "$startSection<span$style";
    }
    echo "  id='$id' data-chapter='$chapter'> $word "; //create the id of the span
    //}
    $previousHeading = $headerType;
    $previousLine = $line;
}
echo "</div>";
?>
</body>
</html>