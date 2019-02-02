<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }

	$classCookie = 1;
	if(isset($_COOKIE["classCookie"])) {
		$classCookie = $_COOKIE["classCookie"];
	}

	$userID;
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION["userID"];
	}
?>

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
$location = $_GET['location'];
	
//echo "Cookie: " . $classCookie . "<br>";
//echo "Location: " . $location . "<br>";
    
$partOfSQL = " WHERE";
for ($i=0;$i<count($chapters);$i++) {
    if ($i == 0) {
        $partOfSQL = $partOfSQL . " (chapter = " . $chapters[$i] . "";
    }
    elseif ($i == count($chapters)-1) {
        $partOfSQL = $partOfSQL . " OR chapter = " . $chapters[$i] . ""; 
    }
    else {
        $partOfSQL = $partOfSQL . " OR chapter = " . $chapters[$i] . "";
    }
    $partOfSQL .= ") AND";
}

//echo $partOfSQL
    
$server = 'sql9.freemysqlhosting.net';
$user = 'sql9262759';
$pass = '4fE3cl8Jqm';
$db = 'sql9262759';
$connection = mysqli_connect($server, $user, $pass, $db);

//echo "SELECT * FROM NotesData" . $partOfSQL . " ClassID = '$classCookie' AND UserID = '$userID';";
$result = mysqli_query($connection, "SELECT * FROM NotesData" . $partOfSQL . " ClassID = '$classCookie' AND UserID = '$userID';");
	
//echo "SELECT text, type, chapter, linebreaks, highlights, bolds, underlines, viewOrder FROM NotesData" . $partOfSQL . " AND ClassID = $classCookie AND UserID = $userID;";
    
$colors = mysqli_query($connection, "SELECT * FROM Highlight;");
    
$color = array();
$colorId = 0;
while($row = mysqli_fetch_array($colors, MYSQLI_ASSOC)) {
    $color[$colorId] = $row['colors'];
    $colorId++;
}
    
// display data in table
/*$columns = mysqli_query($connection, "SHOW COLUMNS FROM GroupedNotes");
    
while($row = mysqli_fetch_array($columns, MYSQLI_ASSOC)) {
    $theColumns[] = $row['Field'];
}
$arrlength = count($theColumns);*/
    
    
$lastSectionType = "";
$linesInList = 0;
$amountOfLists = 0;
$currentList = array(0, 0, 0, 0);
$bigList = array(array(1, 2, 3, 4, 5, 6, 7, 8, 9), array("a", "b", "c", "d", "e", "f", "g", "h"), array("i", "ii", "iii", "iv", "v", "vi", "vi", "vii"));
$firstSection = true;
$firstWord = true;

$length = mysqli_num_rows($result);
	
if ($length <= 0) {
	echo "<script>";
	echo "var object = document.querySelector('.cookieClass');";
	echo "joinClass(object);";
}
else {
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $type = $row['type'];
    $chapter = $row['chapter'];
    $isList = false;
    
     
    if (substr($type, 0, 9) == "LIST_ITEM") { //Check if section is a list
        $isList = true;
        $listType = substr($type, -1);
        $previousType;
        if (substr($lastSectionType, 0, 9) == "LIST_ITEM") { //Check if previous section was a list
            $previousType = substr($lastSectionType, -1);
        }
        else {
            $amountOfLists++;
            $currentList = array(0, 0, 0, 0);
            $linesInList = 0;
        }
    }
    $extra = "";
    if (isList) {
        $extra = "data-list='" . $currentList[0] . "," . $currentList[1] . "," . $currentList[2] . "'";
    }
    
    $text = $row['text'];
    $separatedText = explode(" ", $text);
    $linebreaks = str_split($row['linebreaks']);
    $underlines = str_split($row['underlines']);
    $bolds = str_split($row['bolds']);
    $highlights = str_split($row['highlights']);
    /*if ($id == 3) {
        echo "<script>console.log('" . count($separatedText) . "');</script>";
    }*/
	if ($location == "Own_Notes") {
		echo "<div class='Section' id='Section$id' onmouseout='removePlus(this)' onmouseover='hovering(this)' data-type='$type' data-chapter='$chapter' $extra contenteditable='false' ondblclick='doubleclick(this)' onfocusout='focusOUT(this)'>"; //Create the section's div
	}
	else {
		echo "<div class='Section' id='Section$id'  data-type='$type' data-chapter='$chapter' $extra contenteditable='false' >"; //Create the section's div
	}
    
    for ($i=0; $i<count($separatedText); $i++) { //Iterate through each word applying all information //separatedText must have an empty value
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
           
			$repeated = str_repeat("<br>", $linebreaks[$i]);
			echo $repeated;
			
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
        echo " <br> <div id='here'></div>";
    }
    
    
    
    
    $isList = false;
    
    echo "</div>"; //End the section's div
    $lastSectionType = $type;
    }
}
?>    
</body>
</html>