<?php
    session_start();
    if (isset($_SESSION['allowed']) && $_SESSION['allowed'] == true) {
        echo "<script> alert('you are logged in') </script>";
    }
    else {
        echo "<script> window.location.replace('/Biology/Login/') </script>";
    }
?>

<!DOCTYPE html>

<html>
    
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
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
                xmlhttp.open("GET","update.php?" + param ,true);
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
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };

                var temp = JSON.stringify(selected);
                //document.getElementById("textHint").innerHTML = selected.length;
                if (selected.length != 0) {
                    xmlhttp.open("GET","displayChapter.php?chapters="+temp,true);
                    xmlhttp.send();
                }
                else {
                    document.getElementById("txtHint").innerHTML = "Please Select a chapter to view";
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
        </script>
        <div class="col6" id="txtHint">
            <b>Person info will be listed here.</b>
        </div>
        
        <div class="col5" id="right" style="position:fixed;height:300px;background-color:aqua;top:0px;right:0px;padding:10px;">
            <div id="chapterButtons" style="overflow-x: auto;white-space: nowrap;height:75px;padding-bottom:10px;">
                <script>document.getElementById("right").style.height = screen.height + "px";</script>
                <?php
                    for ($i=1; $i<20; $i++) {
                        if ($i == 1) {
                            echo '<button class="button" type="checkbox" onclick="showUser(' . $i . ')" data-selected="true" id="chapterButton' . $i . '"> Chapter ' . $i . ' </button>';
                        }
                        else {
                            echo '<button class="button" type="checkbox" onclick="showUser(' . $i . ')" data-selected="false" id="chapterButton' . $i . '"> Chapter ' . $i . ' </button>';
                        }
                    }
                ?>
            </div>
            <button class="button editButton" type="button" onclick="highlight()">Highlight</button>
            <button class="button editButton" type="button" onclick="bold()">Bold</button>
            <button class="button editButton" type="button" onclick="underline()">Underline</button>
            <div id="holder" style="overflow-y:scroll; height: 80%;">
                Text will show here
            </div>
        </div>
    </body>
</html>