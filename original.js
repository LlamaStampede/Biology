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
    //console.log("here")
    if (elemen.classList.contains("highlight")) {
        elemen.dataset.color = "yellow";
        //console.log("here3")
        doThis("id=" + id + "&style=highlight&change=3");
    }
    else {
        elemen.dataset.color = "";
        //console.log("here0")
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

function thisToo(str, location, UserID) {
    if (str != "") {
        var index = selected.indexOf(str);
        if (index > -1) {
            selected.splice(index, 1);
        }
        else {
            selected.push(str);
        }
    }
	var extraID = "";
	if (UserID != null) {
		console.log("UserID: " + UserID);
		extraID = "&UserID=" + UserID;
	}
	console.log("In thisToo function. Str: " + str + ". Location: " + location);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(location).innerHTML = this.responseText;
			console.log("Completed request");
			console.log("result: " + this.responseText)
        }
    };

    var temp = JSON.stringify(selected);
    //document.getElementById("textHint").innerHTML = selected.length;
	console.log("Selected Length: " + selected.length);
	console.log("Destination: " + "displayChapter.php?chapters="+temp+"&location="+location+extraID);
    //if (selected.length != 0) {
        xmlhttp.open("GET","displayChapter.php?chapters="+temp+"&location="+location+extraID,true);
        xmlhttp.send();
    //}
    //else {
		//console.log(location);
        // temp document.getElementById(location).innerHTML = "Select a chapter to view";
    //}
}

function showUser(str) {
    if (document.getElementById("chapterButton" + str).dataset.selected == "false") {
        document.getElementById("chapterButton" + str).dataset.selected = "true";
    }
    else {
        document.getElementById("chapterButton" + str).dataset.selected = "false";
    }

    thisToo(str, "Own_Notes")
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
        //console.log(arr);
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
        thisToo("", "Own_Notes");
    }


}
thisToo(1, "Own_Notes");
selected = [];
//thisToo(1, "right");

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
            /*//console.log('xmlhttp.readyState=',xmlhttp.readyState);
            //console.log('xmlhttp.status=',xmlhttp.status);
            //console.log('response=',xmlhttp.responseText);*/
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
        //console.log("Background color of " + element.id + "set to light green");
    }
    //element.parentNode.insertBefore(plus, element.nextSibling);
}

function removePlus(element) {
    if (editing) {
        var plus = document.getElementById("plus");
        plus.dataset.id = "";
        plus.style.display = "none";
        element.style.backgroundColor = "transparent";
        //console.log("Background color set to white");
    }
}

function plus(element) {
    //console.log(element.dataset.id);
}

function edit() {
    if (editing) {
        editing = false;
        //console.log("Editing false");
    }
    else {
        editing = true;
        //console.log("Editing true");
    }
}