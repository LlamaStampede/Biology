var x = window.innerWidth;
var y = window.innerHeight;
var holder = document.getElementById("holder");
holder.style.height = y * 0.75 + "px";

var draggables = document.getElementsByClassName("draggable");
for (var i=0;i<draggables.length;i++) {
    var position = 45;
    if (draggables[i].dataset.pos == "left") {
        position -= 25;
    }
    else if (draggables[i].dataset.pos == "right") {
        position += 25;
    }
    draggables[i].style.left = position + "%";
    //console.log(i + ", " + position);
}

var percent = 20/x;
document.getElementById("semicircle").style.left = 45 + "%";
document.getElementById("semicircle").style.width = 10 + "%";
document.getElementById("semicircle").style.height = 5 + "%";
document.getElementById("left").style.width = 50 - 2000/x + "%";
document.getElementById("right").style.width = 50 - 2000/x + "%";
document.getElementById("right").style.height = y + "px";
//console.log(percent);
function arrowClicked() {
    var pos;
    var diff;
    var end;
    if (document.getElementById("semicircle").dataset.clicked == "false") {
        document.getElementById("semicircle").dataset.clicked = "true";
        document.getElementById("bottomBar").style.display = "inline";
        pos = window.innerHeight*0.95; //window.innerHeight-45
        diff = -1;
        end = window.innerHeight-300;
        //console.log("start bottom")
        document.getElementById("cover").style.display = "inline";
        document.getElementById("cover").style.opacity = 0;
        //transition("semicircle", 0.5, 0.01);
        transition("cover", 0.5, 0.01);
    }
    else {
        pos = window.innerHeight-300;
        diff = 1;
        end = window.innerHeight*0.95;
        //console.log("start top")


    }

    var elem = document.getElementById("semicircle");   

    var id = setInterval(frame, 3);
    function frame() {
        if (Math.floor(pos) == Math.floor(end)) {
            clearInterval(id);
            if (diff == 1) {
                document.getElementById("semicircle").innerHTML = '<p id="inner" style="margin:-10px;">&#8607;</p>';
                document.getElementById("semicircle").dataset.clicked = "false";
                //console.log("end bottom")
                document.getElementById("bottomBar").style.display = "none";
                transition("semicircle", 0.25, 0.01);
                transition("cover", 0, 0.01);
                setTimeout(function() {document.getElementById("cover").style.display = "none";}, 1000)
            }
            else {
                document.getElementById("semicircle").innerHTML = '<p id="inner" style="margin:-10px;">&#8609;</p>';
                //console.log("end top")


            }

        } else {
            pos += diff;
            document.getElementById("bottomBar").style.top = pos + window.innerHeight*0.05 + "px";
            elem.style.top = pos + "px";
        }
    }
}
function arrowHovered() {
    //console.log("hovered function");
    transition("semicircle", 1, 0.01);
}

function arrowLeft() {
    if (document.getElementById("semicircle").dataset.clicked == "false") {
        transition("semicircle", 0.25, 0.01);
    }
    //console.log("left function");
}

function transition(objID, end, rate) {
    var object = document.getElementById(objID);
    var id = setInterval(frame, 3);
    var currentPos = parseFloat(object.style.opacity);
    //alert(currentPos);
    var multiplier = -1;
    if (end-currentPos>0) {
        multiplier = 1;
    }
    function frame() {
        if (Math.round(100 * currentPos)/100 == end) {
            clearInterval(id);
            //console.log("Finished");
        }
        else {
            currentPos += multiplier * rate;
            object.style.opacity = currentPos;
            //console.log("Current: " + (Math.round(100 * currentPos)/100) + " End: " + end);
        }
    }
}