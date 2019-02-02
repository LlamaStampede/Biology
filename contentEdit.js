var array = ["1", "There are cool things And fun!", "1", "100010", "100010"];
var regex = /(<([^>br]+)>)/ig;

function getAllIndexes(arr, val) {
    var indexes = [], i = -1;
    while ((i = arr.indexOf(val, i+1)) != -1){
        indexes.push(i);
    }
    return indexes;
}

function doubleclick(ele) {
    console.log("Top of Double Click");
    if (ele.hasChildNodes()) {
        if (ele.querySelector("#plus") != null) {
            document.getElementById("txtHint").appendChild(document.getElementById("plus"));
        }
    }
    console.log(ele.id);
    var id = ele.id.slice(7);
    console.log(id);
    console.log("getRow.php?id=" + id);
    ele.dataset.dblclicked = "true";
    var rawText = "yesNEXTno";
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            rawText = this.responseText;
        }
    };
    xmlhttp.open("GET","getRow.php?id=" + id ,false);
    
    xmlhttp.send();
    
    rawText = rawText.split("NEXT");
    console.log(rawText);
    currentText = rawText[1];
    currentLinebreaks = rawText[2];
    
 
    var split = currentText.split(" "); //split text into array at the spaces
    var text = "";
    for (var i=0;i<split.length;i++) { //loop through each word
		if (text != "") {
			text = text + "<br>".repeat(currentLinebreaks[i]); //add a <br> at the 1's in the linebreak part of array
		}
        
        text = text + split[i] + " "; //add the word and a space to the new text
    }
    ele.innerHTML = text; //reset the innerHTML to the newtext
    ele.contentEditable = "true"; //allow div editing
    ele.style.whiteSpace = "pre-wrap"; 
    ele.focus();
}
function focusOUT(ele) {
    if (ele.dataset.dblclicked == "true") {
        ele.dataset.dblclicked = "false";
        var id = ele.id.slice(7);
        var type = ele.dataset.type;
        console.log("ID: " + id);

        ele.contentEditable = "false";
        //console.log("Inner html: " + ele.innerHTML);
        ele.style.whiteSpace = "normal";
        var inner = ele.innerHTML.replace(/<\/div><div>/g, "</div> <div>");
        inner = inner.replace(/<div><br><\/div>/gi, "<br>");
        inner = inner.replace(/<br>/g, " <br> ");
        //inner = inner.replace(/<div>/g, " <br> ");
        var text = inner.split(" ");
        //console.log("Text before processing: " + text);
        for (var i=0;i<text.length;i++) { 
            /*if (text[i].includes("<div>")) {
                //var newText = text[i].replace(regex, "<br>");
                var newText = text[i].replace(/<div><br>/gi, "<br>");
                newText = newText.replace(/<\/div>/gi, "");
                //var newText = text[i].replace(/<\/div>/gi, "");
                console.log(newText + "\n");
                text[i] = newText;
            }*/
            var newText = text[i].replace(/<div><br><\/div>/gi, "<br>");
            newText = newText.replace(/<div>/gi, "<br>");
            newText = newText.replace(/<\/div>/gi, "");

            //newText = newText.replace(/<br>/g, " ");
            text[i] = newText.replace(/  +/g, ' ');
        }
        text.pop();

        var filtered = text.filter(function (el) {
          return el != "";
        });
        text = filtered;

        console.log("Text midway through processing: " + text + "\n");

        var list = ele.dataset.list;
		
		while (text[text.length-1] == "<br>") {
			text.pop();
		}

        var indexes = getAllIndexes(text, "<br>");
        var times = 0;
        for (var i = 0; i<indexes.length; i++) {
            text.splice(indexes[i]-times, 2, text[indexes[i]-times] + text[indexes[i]-times+1]);
            times++;
        }
       console.log("Text 75% through processing: " + text + "\n");

        var lines = new Array(text.length);
        for (var i=0;i<text.length;i++) { 
            var count = (text[i].match(/<br>/g) || []).length;
            if (count > 9) { //can't have two digits
                count = 9;
                alert('Please do not type 10 or more new lines in a row');
            }
            lines[i] = count;
            text[i] = text[i].replace(/<br>/g, "");
        }
        //console.log("Line status: " + lines);


        text = text.join(" ").split(" ");

        var finalText = text.join(" ");
        var finalLinebreaks = lines.join("");
        console.log("Final Text: " + finalText);
        console.log("Final Linebreaks: " + finalLinebreaks);

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log('FINISHED');
                ele.innerHTML = this.responseText;
            }
        };
        console.log('before');
        xmlhttp.open("GET","updateRow.php?id=" + id + "&text=" + encodeURIComponent(finalText) + "&linebreaks=" + finalLinebreaks + "&type=" + type + "&list=" + encodeURIComponent(list), true);
        console.log("updateRow.php?id=" + id + "&text=" + encodeURIComponent(finalText) + "&linebreaks=" + finalLinebreaks + "&type=" + type + "&list=" + list);
        xmlhttp.send();
        console.log('after');
        //text = text.replace("<br>", "");
    }
}