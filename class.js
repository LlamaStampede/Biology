function callClass(parameters) {
    console.log("here");
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("classResults").innerHTML = this.responseText;
        }
    };
    console.log("going to " + "class.php?" + parameters);
    xmlhttp.open("GET", "class.php?" + parameters ,true);
    xmlhttp.send();
}
