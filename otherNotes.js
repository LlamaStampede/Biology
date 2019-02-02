function loadStudents() {
	var destination = document.getElementById("ONTopContainer");
	
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			destination.innerHTML = this.responseText;
		}
	};
	
	var link = "otherNotes.php?type=students"
	console.log("Going to " + link);
	xmlhttp.open("GET", link ,true);
	xmlhttp.send();
}

function loadON(object) {
	var UserID = object.dataset.userid;
	
	var currentSelectedUser = document.getElementById("ONTopContainer").querySelector("[data-fontWeight='bold']")
	if (currentSelectedUser != null) {
		currentSelectedUser.style.fontWeight = "normal";
		currentSelectedUser.dataset.fontweight = "normal";
	}
	
	object.style.fontWeight = "bold";
	object.dataset.fontweight = "bold";
	
	thisToo("", "ONResults", UserID);
}