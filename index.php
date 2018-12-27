<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        //echo "<script> alert('you are logged in') </script>";
    }
    else {
        $_SESSION['message'] = "Please Log in or Sign up";
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }
?>

<!DOCTYPE html>

<html>
    
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="contentEdit.js"></script>
        <script src="original.js"></script>
        <script src="log.js"></script>
        <script src="class.js"></script>
        <title>Main page</title>
    </head>
    
    <body>
        <?php
            echo "<div id='outer'>";
            $names = array("Own_Notes", "Editing", "Classes_List", "Others'_Notes", "Favorited");
            $email = $_SESSION['email'];
            for ($i=0;$i<5;$i++) {
                //echo '<script>console.log(' . $i . ');</script>';
                echo '<div class="display" id="' . $names[$i] . '" data-hide=true>';
                switch ($i) {
                    case 0:
                        echo '<b>Select a chapter to view it</b>';
                        break;
                    case 1:
                        echo '<div id="chapterButtons" style="overflow-x: auto;white-space: nowrap;height:5%;padding-bottom:10px;">';
                        echo '<button class="button chapterButton" onclick="showUserAll(this)" data-selected="false" data-all="false" id="chapterButtonAll"> Select All </button>';
                        for ($j=1; $j<20; $j++) {
                            if ($j == 1) {
                                echo '<button class="button chapterButton" onclick="showUser(' . $j . ')" data-selected="true" id="chapterButton' . $j . '"> Chapter ' . $j . ' </button>';
                            }
                            else {
                                echo '<button class="button chapterButton" onclick="showUser(' . $j . ')" data-selected="false" id="chapterButton' . $j . '"> Chapter ' . $j . ' </button>';
                            }
                        }
                        echo '</div><button class="button editButton" type="button" onclick="highlight()">Highlight</button><button class="button editButton" type="button" onclick="bold()">Bold</button><button class="button editButton" type="button" onclick="underline()">Underline</button><button class="button editButton" type="button" onclick="edit()">Edit</button><div style="width:100%;height:3px;background-color:black;margin-top:5px;margin-bottom:5px;">  </div><div id="holder" style="overflow-y:scroll; height: 750px;">Click on a word to see dictionary entries and other occurences of that word</div>';
                        break;
                    case 2:
                        echo "<div id='currentClasses' class='classSelection'><div style='width:100%;font-size:48px;text-align:center;text-decoration:underline;'>Current Classes</div><br><div id='classResults'>holder text</div></div>";
                        echo '<input id="searchBar" type="text" size="30" onkeyup="showResult(this.value)">';
                        echo "<div id='searchResults' class='classSelection'>Sample Text</div>";
                        echo "<script> callClass('email=' + '$email'); </script>"; //calls('class.php', 'email=" . $_SESSION['email'] . "')
                        break;
                    case 3:
                        echo $names[$i];
                        break;
                    case 4:
                        echo $names[$i];
                        break;
                }
                echo '</div>';
            }
            echo '</div>';
        ?>
        <input onclick="plus(this)" id="plus" type="image" src="plus.png" alt="Add Section" width="30" data-id="" height="30" style="display:none;margin-left:80%;">
        
        <div id="left" style="padding:10px;"></div>
        
        <div id="right" style="position:fixed;height:100%;background-color:#c7dce6;top:0px;left:50%;padding:10px;"></div>
        
        <div id="cover" style="width:100%;height:100%;position:fixed;top:0px;left:0px;z-index:1;background-color:black;display:none;">
            text
        </div>
        <div id='bottomContainer'>
            <div id='semicircle' style="bottom:0%;left:45%;width:100px;height:50px;position:fixed;border-top-left-radius:100px;border-top-right-radius:100px;background-color:black;color:white;text-align:center;font-size:50px;vertical-align:-10px;opacity:0.25;z-index:2;" onmouseover="arrowHovered()" onmouseout="arrowLeft()" onclick="arrowClicked()" data-clicked="false">
                <p id="inner" style="margin:-10px;">&#8607;</p>
            </div>
            <div id="bottomBar" style="width:100%;height:255px;background-color:#484848;position:fixed;display:none;text-align:center;z-index:2;">
                <div id="D_Own" class="draggable" data-pos="left">Own Notes</div>
                <div id="D_Edit" class="draggable" data-pos="right">Editing</div>
                <div id="D_Class" class="draggable" data-pos="center">Classes List</div>
                <div id="D_Other" class="draggable" data-pos="center">Others' Notes</div>
                <div id="D_Fav" class="draggable" data-pos="center">Favorited</div>
            </div>
        </div>
        <script src="drag.js"></script>
        <script src="semicircle.js"></script>
    </body>
</html>