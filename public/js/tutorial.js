window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        document.getElementById("myTopnav").style.backgroundColor = "#5bbcd2";
        document.getElementById("myTopnav").style.boxShadow = "0px 5px 20px 2px rgba(0,0,0,0.2)";
    } else {
        document.getElementById("myTopnav").style.backgroundColor = "transparent";
        document.getElementById("myTopnav").style.boxShadow = "none";
    }
}