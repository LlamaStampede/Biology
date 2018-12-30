function callClass(destinationID, parameters) {
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
            document.getElementById(destinationID).innerHTML = this.responseText;
        }
    };
    console.log("going to " + "class.php?" + parameters);
    xmlhttp.open("GET", "class.php?" + parameters ,true);
    xmlhttp.send();
}

function createClass() {
    var children = document.getElementById("bottomClassBox").childNodes;
    /*for (var i=0;i<children.length;i++) {
        console.log(children[i].id);
        children[i].style.display = "none";
    }*/
    document.getElementById("searchResults").style.display = "none"; //make seachResultsinner div noen
	document.getElementById("helper").style.display = "none"; //make seachResultsinner div noen
    document.getElementById("bottomTitle").innerHTML = "Class Creator";
    //document.getElementById("bottomClassBox").appendChild(document.getElementById("classCreator"));
    document.getElementById("classCreator").style.display = "inline";
}

function submitCancelButton() {
    var theForm = document.getElementById("THEFORM");
    var name = theForm.querySelector("#name");
    var desc = theForm.querySelector("#desc");
    var submit = theForm.querySelector("#submit");
    if (name.value == "" && desc.value == "") {
        submit.value = "Cancel";
        submit.type = "button";
        submit.setAttribute("onclick", "cancelRedirect()");
    }
    else {
        submit.value = "Submit";
        submit.type = "submit";
    }
}
function cancelRedirect() {
    document.getElementById("searchResults").style.display = "inline";
	document.getElementById("helper").style.display = "inline";
    document.getElementById("bottomTitle").innerHTML = "Most Recently Created Classes";
    document.getElementById("classCreator").style.display = "none";//make seachResultsinner div noen
}

function classSearch(value) {
	document.getElementById("classCreator").style.display = "none";
	if (value == "") {
		document.getElementById("bottomTitle").innerHTML = "Most Recently Created Classes";
		callClass('searchResults', 'type=mostRecent');
	}
	else {
		document.getElementById("bottomTitle").innerHTML = "Search Results";
		callClass('searchResults', 'type=search&words=' + encodeURIComponent(value));
	}
	
}

function joinClass(object) {
	if (object.dataset.joined == "false") {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "class.php?" + "type=add&classID=" + object.dataset.classID ,true);
    	xmlhttp.send();
	}
	else if (object.innerHTML != "You are already in this class!") {
		var temp = object.innerHTML;
		object.innerHTML = "You are already in this class!";
		setTimeout(function() {object.innerHTML = temp}, 2000);
	}
}