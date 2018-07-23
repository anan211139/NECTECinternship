var valueMath = 36;
var valueEng = 21;
var elemMath = document.getElementById("bar1");
var elemEng = document.getElementById("bar2");

move(valueMath,elemMath);
move(valueEng,elemEng);
function move(value,elem) {  
    var width = 0;
    var id = setInterval(frame, 15);
    function frame() {
        if(value != 0){
            if (width >= value) {
            clearInterval(id);
            } else {
            width++; 
            elem.style.width = width + '%'; 
            }
        } else {
            elem.style.width = 0+ '%'; 
        }
    }
}