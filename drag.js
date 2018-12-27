var objects = document.getElementsByClassName("draggable");
var width = window.innerWidth;

document.addEventListener('mousedown', function (event) {
    var object = event.target;
    var initX, initY, mouseX, mouseY;
    function mouseMove(e) {
        var newPos = (initX + e.clientX - mouseX);
        if (0 < newPos && newPos < width*0.9) {
            object.style.left = newPos + "px";
        }
        else if (newPos <= 0) {
            object.style.left = "1px";
        }
        else if (width*0.9 <= newPos){
            object.style.left = (width*0.89) + "px";
        }
    }

    function mouseUp() {
        object.removeEventListener("mousemove", mouseMove);
        object.removeEventListener("mouseup", mouseUp);
        object.removeEventListener("mouseout", mouseUp);
        stopped(object);
    }
    
    if (event.target.classList.contains('draggable') && event.target.dataset.pos == "center") {
        object.addEventListener("mousemove", mouseMove);
        object.addEventListener("mouseup", mouseUp);
        object.addEventListener("mouseout", mouseUp);
        initX = object.offsetLeft;
        initY = object.offsetTop;
        mouseX = event.clientX;
        mouseY = event.clientY;
    }
    else if (event.target.classList.contains('draggable') && event.target.dataset.pos != "center") {
        switchOuters();
    }
}, false);

function stopped(object) {
    var left = object.offsetLeft;
    //console.log("Offset Left: " + left + ". Width: " + width);
    if (0.3*width < left && left < 0.5*width) {
        document.getElementById(object.id).style.left = "45%";
        //console.log("Repositioned " + object.id + " to the center");
    }
    else if (0 <= left && left <= 0.3*width) {
        document.getElementById(object.id).style.left = "20%";
        //console.log("Repositioned " + object.id + " to the left");
        var result = object.parentElement.querySelector("[data-pos='left']")
        //console.log("Left object: " + result.id);
        result.dataset.pos = "center";
        object.dataset.pos = "left";
        hide(result.innerHTML);
        show(object.innerHTML, "left");
        goBack(result, 0.45*width, 1);
    }
    else if (0.5*width <= left && left <= width*0.9) {
        document.getElementById(object.id).style.left = "70%";
        var result = object.parentElement.querySelector("[data-pos='right']")
        //console.log("Right object: " + result.id);
        result.dataset.pos = "center";
        object.dataset.pos = "right";
        hide(result.innerHTML);
        show(object.innerHTML, "right");
        goBack(result, 0.45*width, 1);
        //console.log("Repositioned " + object.id + " to the right");
    }
} //1.57079

function goBackOriginal(object, end) {
    var id = setInterval(frame, 1);
    var pos = object.offsetLeft
    var diff;
    if (pos < end) {
        diff = 1
    }
    else {
        diff = -1
    }
    function frame() {
        if (Math.floor(pos) == Math.floor(end)) {
            clearInterval(id);
            //console.log("Animation over");

        } else {
            pos += diff;
            object.style.left = pos + "px";
        }
    }
}

function goBack(object, end, multiplier) {
    var id = setInterval(frame, 1);
    var pos = object.offsetLeft
    //var end = 0.45 * width;
    var originalDiff = Math.abs(pos-end);
    //console.log("Start Position: " + pos + ". End Pos: " + end + ". Diff: " + Math.abs(pos-end))
    var diff;
    if (pos < end) {
        diff = 1
    }
    else {
        diff = -1
    }
    var tryy = 0
    function frame() {
        if (Math.floor(100 *tryy)/100 == 3.14) {
            clearInterval(id);
            //console.log("Animation over");

        } else {
            tryy += 0.01
            tryy = Math.round(100 * tryy)/100;
            pos += diff * difference(tryy) * multiplier;
            object.style.left = pos + "px";
        }
    }
}

function difference(tryy) {
    //console.log(tryy);
    return 2.09444 * Math.sin(tryy);
}

function hide(text) {
    var name = text.replace(" ", "_");
    var object = document.getElementById(name);
    document.getElementById(name).dataset.hide = "true";
    document.getElementById("outer").appendChild(object);
}

function show(text, side) {
    var name = text.replace(" ", "_");
    var object = document.getElementById(name);
    //console.log("Got an object here: " + name);
    document.getElementById(side).appendChild(object);
    document.getElementById(name).dataset.hide = "false";
}

show("Editing", "right");
show("Own Notes", "left");

function switchOuters() {
    var container = document.getElementById("bottomBar");
    var left = container.querySelector("[data-pos='left']");
    var right = container.querySelector("[data-pos='right']");
    left.dataset.pos = "right";
    show(left.innerHTML, "right");
    right.dataset.pos = "left";
    show(right.innerHTML, "left");
    goBack(left, width*0.7, 2);
    goBack(right, width*0.2, 2);
}
