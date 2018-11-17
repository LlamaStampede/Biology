<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Main page</title>

</head>
<body>
    <script>
        function getCheckedBoxes(chkboxName) {
          var checkboxes = document.getElementsByName(chkboxName);
          var checkboxesChecked = [];
          // loop over them all
          for (var i=0; i<checkboxes.length; i++) {
             // And stick the checked ones onto an array...
             if (checkboxes[i].checked) {
                checkboxesChecked.push(checkboxes[i].value);
                 alert("yes");
             }
          }
          // Return the array if it is non-empty, or null
          return checkboxesChecked.length > 0 ? checkboxesChecked : null;
        }
        
        var selected = []
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
            document.getElementById("textHint").innerHTML = selected.length;
            if (selected.length != 0) {
                xmlhttp.open("GET","displayChapter.php?chapters="+temp,true);
                xmlhttp.send();
            }
            else {
                document.getElementById("txtHint").innerHTML = "Please Select a chapter to view";
            }
            
        }
        showUser("");
    </script>
    
    <form>
        <!--select name="users" onchange="showUser(this.value)">
          <option value="">Select a chapter:</option>
          <option value="1">Chapter 1</option>
          <option value="2">Chapter 2</option>
          <option value="3">Chapter 3</option>
          <option value="4">Chapter 4</option>
        </select-->
        <input type="checkbox" onchange="showUser(this.value)" name="chapter1" value="1" /> Chapter 1
        <input type="checkbox" onchange="showUser(this.value)" name="chapter2" value="2" /> Chapter 2
        <input type="checkbox" onchange="showUser(this.value)" name="chapter3" value="3" /> Chapter 3
    </form>
    <div id="textHint"><b>Person info will be listed here.</b></div>
    <div id="txtHint"><b>Person info will be listed here.</b></div>
    </body>
</html>