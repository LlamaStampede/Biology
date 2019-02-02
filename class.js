function callClass(destinationID, parameters) {
    console.log("In callClass function class.js");
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			if (destinationID != null) {
				document.getElementById(destinationID).innerHTML = this.responseText;
			}
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
	document.getElementById("classRemover").style.display = "none"; //make seachResultsinner div noen
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
	document.getElementById("classRemover").style.display = "inline";
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
		if (object.innerHTML != "Joining this class!") {
			var temp = object.innerHTML;
			object.innerHTML = "Joining this class!";
			setTimeout(function() {object.innerHTML = temp}, 2000);
		}
		console.log("Class.js joinclass() joined==false");
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				object.dataset.joined = "true";
				callClass("classResults", "a=a");
			}
		};
		console.log("going to " + "class.php?" + "type=add&classID=" + object.dataset.classid);
		xmlhttp.open("GET", "class.php?" + "type=add&classID=" + object.dataset.classid ,true);
    	xmlhttp.send();
		
	}
	else if (object.innerHTML != "You are already in this class!") {
		var temp = object.innerHTML;
		object.innerHTML = "You are already in this class!";
		setTimeout(function() {object.innerHTML = temp}, 2000);
	}
}

function setCookie(cname, cvalue, exdays) {
    console.log("Name: " + cname + " Value: " + cvalue + " Expiration: " + exdays);
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
    console.log("setting Cookie: " + cname);
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function clickedTopClass(object) {
	var selected = document.getElementsByClassName("cookieClass");
	if (selected.length > 0) {
		selected = selected[0];
		selected.classList.remove("cookieClass");
	}
	object.classList.add("cookieClass");
	setCookie("classCookie", object.dataset.classid, 30);
	var arrayOfText = object.innerHTML.split(" - ");
	arrayOfText[0] = arrayOfText[0].substr(2);
	
	var removeButton = document.getElementById("classRemover");
	removeButton.innerHTML = "Click here to leave the class <b>" + arrayOfText[0] + "</b> " + arrayOfText[2];
	removeButton.classList.add("pointer");
	removeButton.setAttribute("onclick", "removeClass('" + object.dataset.classid + "')");
	thisToo("", "Own_Notes");
	loadStudents();
}

function removeClass(classID) {
	console.log("Here leave the class: " + classID);
	callClass("", "type=leave&classID=" + classID);
	callClass("classResults", "a=a");
	
	var removeButton = document.getElementById("classRemover");
	removeButton.innerHTML = "Click on a class to select it";
	removeButton.classList.remove("pointer");
	removeButton.removeAttribute("onclick");
	
	var searchResults = document.getElementById("searchResults");
	var classDiv = searchResults.querySelector("[data-classid='" + classID +"']")
	classDiv.dataset.joined = "false";
}