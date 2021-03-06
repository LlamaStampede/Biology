<!DOCTYPE html>

<html>

    <head>
        <!--link rel="stylesheet" type="text/css" href="styles.css"-->
        <title>Main page</title>

    </head>
        <script>
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
                console.log("The section was double clicked"); //signal a double click
                console.log("Array beginning: " + array);
                var split = array[1].split(" "); //split text into array at the spaces
                var text = "";
                for (var i=0;i<split.length;i++) { //loop through each word
                    text = text + "<br>".repeat(array[3][i]); //add a <br> at the 1's in the linebreak part of array
                    
                    text = text + split[i] + " "; //add the word and a space to the new text
                }
                ele.innerHTML = text; //reset the innerHTML to the newtext
                ele.contentEditable = "true"; //allow div editing
                ele.style.whiteSpace = "pre-wrap"; 
                ele.focus();
            }
            function focusOUT(ele) {
                ele.contentEditable = "false";
                console.log("Inner html: " + ele.innerHTML);
                ele.style.whiteSpace = "normal";
                var inner = ele.innerHTML.replace(/<\/div><div>/g, "</div> <div>");
                inner = inner.replace(/<div><br><\/div>/gi, "<br>");
                inner = inner.replace(/<br>/g, " <br> ");
                //inner = inner.replace(/<div>/g, " <br> ");
                var text = inner.split(" ");
                console.log("Text before processing: " + text);
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
                console.log("Line status: " + lines);
                
                
                text = text.join(" ").split(" ");
                
                
                
                console.log("Text after processing: " + text + "\n");
                console.log("Line breaks : " + lines);
                array[1] = text.join(" ");
                array[3] = lines.join("");
                console.log("Array at the end: " + array + "\n\n\n");
                //text = text.replace("<br>", "");
                
            }
        </script>
        <p>Hello, this is a paragraph above</p>
        <div class="Section" id="Section1" contenteditable="false" ondblclick="doubleclick(this)" onfocusout="focusOUT(this)">
            <br>
            <span class="Word" id="Word1.0">There</span>
            <span class="Word" id="Word1.1">are</span>
            <span class="Word" id="Word1.2">cool</span>
            <span class="Word" id="Word1.3">things</span>
            <br>
            <span class="Word" id="Word2.0">And</span>
            <span class="Word" id="Word2.1">fun!</span>
        </div>

    <body>

    </body>
    
</html>