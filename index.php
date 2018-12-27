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
        <script src="log.js"></script>
        <title>Main page</title>
    </head>
    
    <body>
        <script>
            var selected = []
            function getElement() {
                var parent = null;
                var selection;
                if (window.getSelection) {
                    selection = window.getSelection();
                    if (selection.rangeCount) {
                        parent = selection.getRangeAt(0).commonAncestorContainer;
                        if (parent.nodeType != 1) {
                            parent = parent.parentNode;
                        }
                    }
                return parent.id;
                }
            }
            function doThis(param) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    }
                };
                xmlhttp.open("GET","updateProperties.php?" + param ,true);
                xmlhttp.send();
            }
            function highlight() {
                var id = getElement();
                var elemen = document.getElementById(id);
                elemen.classList.toggle("highlight")
                console.log("here")
                if (elemen.classList.contains("highlight")) {
                    elemen.dataset.color = "yellow";
                    console.log("here3")
                    doThis("id=" + id + "&style=highlight&change=3");
                }
                else {
                    elemen.dataset.color = "";
                    console.log("here0")
                    doThis("id=" + id + "&style=highlight&change=0");
                }
                //window.location.replace("?id=" + id + "&color=" + colorArray[elemen.style.backgroundColor]);
            }

            function bold() {
                var id = getElement();
                var elemen = document.getElementById(id);
                elemen.classList.toggle("bold")
                if (elemen.classList.contains("bold")) {
                    doThis("id=" + id + "&style=bold&change=1");
                }
                else {
                    doThis("id=" + id + "&style=bold&change=0");
                }
                
                 //window.location.replace("?id=" + id + "&bold=" + boldArray[elemen.style.fontWeight]);
            }

            function underline() {
                var id = getElement();
                var elemen = document.getElementById(id);
                elemen.classList.toggle("underline")
                if (elemen.classList.contains("underline")) {
                    doThis("id=" + id + "&style=underline&change=1");
                }
                else {
                    doThis("id=" + id + "&style=underline&change=0");
                }
            }
            
            function thisToo(str) {
                if (str != "") {
                    var index = selected.indexOf(str);
                    if (index > -1) {
                        selected.splice(index, 1);
                    }
                    else {
                        selected.push(str);
                    }
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("Own_Notes").innerHTML = this.responseText;
                    }
                };

                var temp = JSON.stringify(selected);
                //document.getElementById("textHint").innerHTML = selected.length;
                if (selected.length != 0) {
                    xmlhttp.open("GET","displayChapter.php?chapters="+temp,true);
                    xmlhttp.send();
                }
                else {
                    document.getElementById("Own_Notes").innerHTML = "Select a chapter to view";
                }
            }
            
            function showUser(str) {
                if (document.getElementById("chapterButton" + str).dataset.selected == "false") {
                    document.getElementById("chapterButton" + str).dataset.selected = "true";
                }
                else {
                    document.getElementById("chapterButton" + str).dataset.selected = "false";
                }
                
                thisToo(str)
            }
            
            function showUserAll(element) {
                var elements = document.getElementsByClassName("chapterButton");
                if (element.dataset.all == "false") {
                    var arr = [];
                    element.dataset.all = "true";
                    element.innerHTML = "Deselect All";
                    for (var i=1;i<elements.length;i++) {
                        elements[i].dataset.selected = "true";
                        arr.push(elements[i].id.slice(13));
                    }
                    console.log(arr);
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("Own_Notes").innerHTML = this.responseText;
                        }
                    };

                    var temp = JSON.stringify(arr);

                    xmlhttp.open("GET","displayChapter.php?chapters="+temp,true);
                    xmlhttp.send();
                }
                else {
                    element.dataset.all = "false";
                    element.innerHTML = "Select All";
                    for (var i=1;i<elements.length;i++) {
                        elements[i].dataset.selected = "false";
                    }
                    selected = [];
                    thisToo("");
                }
                

            }
            thisToo(1);
            
            function checkDictionary(text, id) {
                text = text.slice(0, -1);
                if (text[text.length -1] == "s") {
                    text = text.slice(0, -1);
                }
                text = text.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g,"")
                text = text.toLowerCase();
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        /*console.log('xmlhttp.readyState=',xmlhttp.readyState);
                        console.log('xmlhttp.status=',xmlhttp.status);
                        console.log('response=',xmlhttp.responseText);*/
                        document.getElementById("holder").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","dictionarySearcher.php?id=" + id + "&text=" + text,true);
                xmlhttp.send();
            }
            function showSection(id, chapter) {
                if (document.getElementById("chapterButton" + chapter).dataset.selected == "false") {
                    document.getElementById("chapterButton" + chapter).dataset.selected = true;
                    showUser(chapter);
                }
                setTimeout(function(){
                    document.getElementById("Section" + id).scrollIntoView();
                    
                    document.getElementById("Section" + id).style.backgroundColor = "#2e79b9";
                    setTimeout(function(){
                        document.getElementById("Section" + id).style.backgroundColor = "transparent";
                    }, 1000);
                }, 1000);
            }
            
            var editing = false;
            
            function hovering(element) {
                if (element.dataset.dblclicked != "true" && editing) {
                    var plus = document.getElementById("plus");
                    plus.dataset.id = element.id.slice(7);
                    plus.style.display = "inline";
                    plus.style.left = "45%";
                    plus.style.top = element.offsetTop;
                    element.appendChild(plus);
                    element.style.backgroundColor = "#4ceabf";
                    console.log("Background color of " + element.id + "set to light green");
                }
                //element.parentNode.insertBefore(plus, element.nextSibling);
            }
            
            function removePlus(element) {
                if (editing) {
                    var plus = document.getElementById("plus");
                    plus.dataset.id = "";
                    plus.style.display = "none";
                    element.style.backgroundColor = "transparent";
                    console.log("Background color set to white");
                }
            }
            
            function plus(element) {
                console.log(element.dataset.id);
            }
            
            function edit() {
                if (editing) {
                    editing = false;
                    console.log("Editing false");
                }
                else {
                    editing = true;
                    console.log("Editing true");
                }
            }
        </script>
        <?php
            echo "<div id='outer'>";
            $names = array("Own_Notes", "Editing", "Classes_List", "Others'_Notes", "Favorited");
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
                        echo $names[$i];
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
        <script>
            var x = window.innerWidth;
            var y = window.innerHeight;
            var holder = document.getElementById("holder");
            holder.style.height = y * 0.75 + "px";
            
            var draggables = document.getElementsByClassName("draggable");
            for (var i=0;i<draggables.length;i++) {
                var position = 45;
                if (draggables[i].dataset.pos == "left") {
                    position -= 25;
                }
                else if (draggables[i].dataset.pos == "right") {
                    position += 25;
                }
                draggables[i].style.left = position + "%";
                console.log(i + ", " + position);
            }
                
            var percent = 20/x;
            document.getElementById("semicircle").style.left = 45 + "%";
            document.getElementById("semicircle").style.width = 10 + "%";
            document.getElementById("semicircle").style.height = 5 + "%";
            document.getElementById("left").style.width = 50 - 2000/x + "%";
            document.getElementById("right").style.width = 50 - 2000/x + "%";
            document.getElementById("right").style.height = y + "px";
            console.log(percent);
            function arrowClicked() {
                var pos;
                var diff;
                var end;
                if (document.getElementById("semicircle").dataset.clicked == "false") {
                    document.getElementById("semicircle").dataset.clicked = "true";
                    document.getElementById("bottomBar").style.display = "inline";
                    pos = window.innerHeight*0.95; //window.innerHeight-45
                    diff = -1;
                    end = window.innerHeight-300;
                    console.log("start bottom")
                    document.getElementById("cover").style.display = "inline";
                    document.getElementById("cover").style.opacity = 0;
                    //transition("semicircle", 0.5, 0.01);
                    transition("cover", 0.5, 0.01);
                }
                else {
                    pos = window.innerHeight-300;
                    diff = 1;
                    end = window.innerHeight*0.95;
                    console.log("start top")
                    
                    
                }
                
                var elem = document.getElementById("semicircle");   
                
                var id = setInterval(frame, 3);
                function frame() {
                    if (Math.floor(pos) == Math.floor(end)) {
                        clearInterval(id);
                        if (diff == 1) {
                            document.getElementById("semicircle").innerHTML = '<p id="inner" style="margin:-10px;">&#8607;</p>';
                            document.getElementById("semicircle").dataset.clicked = "false";
                            console.log("end bottom")
                            document.getElementById("bottomBar").style.display = "none";
                            transition("semicircle", 0.25, 0.01);
                            transition("cover", 0, 0.01);
                            setTimeout(function() {document.getElementById("cover").style.display = "none";}, 1000)
                        }
                        else {
                            document.getElementById("semicircle").innerHTML = '<p id="inner" style="margin:-10px;">&#8609;</p>';
                            console.log("end top")
                            
                            
                        }
                        
                    } else {
                        pos += diff;
                        document.getElementById("bottomBar").style.top = pos + window.innerHeight*0.05 + "px";
                        elem.style.top = pos + "px";
                    }
                }
            }
            function arrowHovered() {
                console.log("hovered function");
                transition("semicircle", 1, 0.01);
            }
            
            function arrowLeft() {
                if (document.getElementById("semicircle").dataset.clicked == "false") {
                    transition("semicircle", 0.25, 0.01);
                }
                console.log("left function");
            }
            
            function transition(objID, end, rate) {
                var object = document.getElementById(objID);
                var id = setInterval(frame, 3);
                var currentPos = parseFloat(object.style.opacity);
                //alert(currentPos);
                var multiplier = -1;
                if (end-currentPos>0) {
                    multiplier = 1;
                }
                function frame() {
                    if (Math.round(100 * currentPos)/100 == end) {
                        clearInterval(id);
                        console.log("Finished");
                    }
                    else {
                        currentPos += multiplier * rate;
                        object.style.opacity = currentPos;
                        console.log("Current: " + (Math.round(100 * currentPos)/100) + " End: " + end);
                    }
                }
            }
        </script>
    </body>
</html>