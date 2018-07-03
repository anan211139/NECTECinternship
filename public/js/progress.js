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

function dropdownFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function selectFunction(){
    document.getElementById("selectDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
// window.onclick = function(event) {
//   if (!event.target.matches('.dropbtn')) {

//     var dropdowns = document.getElementsByClassName("dropdown-content");
//     var i;
//     for (i = 0; i < dropdowns.length; i++) {
//       var openDropdown = dropdowns[i];
//       if (openDropdown.classList.contains('show')) {
//         openDropdown.classList.remove('show');
//       }
//     }
//   }
// }

function hover() {
    document.getElementById("rightarrow").setAttribute('src', 'picture/right-arrow.png');
}
  
function unhover() {
    document.getElementById("rightarrow").setAttribute('src', 'picture/right-arrowblack.png');
}
function hover2() {
    document.getElementById("rightarrow2").setAttribute('src', 'picture/right-arrow.png');
}
  
function unhover2() {
    document.getElementById("rightarrow2").setAttribute('src', 'picture/right-arrowblack.png');
}

function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}