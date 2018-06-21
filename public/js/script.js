var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("navbar").style.top = "0";
        document.getElementById("plus").src = "picture/arrowup.png";
        document.getElementById("arrowBtn").href = "#login";
    } else {
        document.getElementById("navbar").style.top = "-100px";
        document.getElementById("plus").src = "picture/arrow.png";
        document.getElementById("arrowBtn").href = "#detail";
    }
}