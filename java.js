var register = document.getElementById('reg');

var btn = document.getElementById("open");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    register.style.display = "block";
}

span.onclick = function() {
    register.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == register) {
	register.style.display = "none";
    }
}
