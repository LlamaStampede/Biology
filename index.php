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
            function highlight() {
                var id = getElement();
                var elemen = document.getElementById(id);
                var colorArray = {yellow:3};
                if (elemen.style.backgroundColor == "yellow") {
                    elemen.style.backgroundColor = null;
                }
                else {
                    elemen.style.backgroundColor = "yellow";
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
                    }
                };
                xmlhttp.open("GET","update.php?id=" + id + "&style=highlight&change=" + colorArray[elemen.style.backgroundColor],true);
                xmlhttp.send();
                //window.location.replace("?id=" + id + "&color=" + colorArray[elemen.style.backgroundColor]);
            }

            function bold() {
                var id = getElement();
                var elemen = document.getElementById(id);
                var boldArray = {normal:0,bold:1};
                if (elemen.style.fontWeight == "bold") {
                    elemen.style.fontWeight = "normal";
                }
                else {
                    elemen.style.fontWeight = "bold";
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
                        //document.getElementById("teextHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","update.php?id=" + id + "&style=bold&change=" + boldArray[elemen.style.fontWeight],true);
                xmlhttp.send();
                 //window.location.replace("?id=" + id + "&bold=" + boldArray[elemen.style.fontWeight]);
            }

            function underline() {
                var id = getElement();
                var elemen = document.getElementById(id);
                var underlineArray = {none:0,underline:1};
                if (elemen.style.textDecoration == "underline") {
                    elemen.style.textDecoration = "none";
                }
                else {
                    elemen.style.textDecoration = "underline";
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
                        /*console.log('xmlhttp.readyState=',xmlhttp.readyState);
                        console.log('xmlhttp.status=',xmlhttp.status);
                        console.log('response=',xmlhttp.responseText);*/
                    }
                };
                xmlhttp.open("GET","update.php?id=" + id + "&style=underline&change=" + underlineArray[elemen.style.textDecoration],true);
                xmlhttp.send();

            }
            function showUser(str) {
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
            showUser("1");
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
                if (document.getElementById("CB" + chapter).checked == false) {
                    document.getElementById("CB" + chapter).checked = true;
                    showUser(chapter);
                }
                setTimeout(function(){
                    document.getElementById("Section" + id).scrollIntoView();
                }, 1000);
            }
        </script>
        <div class="col6" id="txtHint">
            <b>Person info will be listed here.</b>
        </div>
        
        <div class="col5" id="right" style="position:fixed;height:300px;background-color:aqua;top:0px;right:0px;">
            <div id="chapterButtons" style="overflow-x: auto;white-space: nowrap;height:50px;">
                <script>document.getElementById("right").style.height = screen.height + "px";</script>
                <?php
                    for ($i=1; $i<20; $i++) {
                        if ($i == 1) {
                            echo 'Chapter ' . $i . ': <input type="checkbox" onchange="showUser(this.value)" name="chapter' . $i . '"  value="' . $i . '" id="CB' . $i . '" checked />';
                        }
                        else {
                            echo 'Chapter ' . $i . ': <input type="checkbox" onchange="showUser(this.value)" name="chapter' . $i . '"  value="' . $i . '" id="CB' . $i . '" />';
                        }
                    }
                ?>
            </div>
            <button type="button" onclick="highlight()">Highlight</button>
            <button type="button" onclick="bold()">Bold</button>
            <button type="button" onclick="underline()">Underline</button>
            <div id="holder" style="overflow-y:scroll; height: 80%;">
                Text will show here
            </div>
        </div>
    </body>
</html>