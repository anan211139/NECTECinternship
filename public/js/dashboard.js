var elemMath = document.getElementById("bar1");
var elemEng = document.getElementById("bar2");
var maxValue = 45;
move(36,elemMath,maxValue);
move(21,elemEng,maxValue);
function move(value,elem,max) {
    var width = 0;
    var id = setInterval(frame, 15);
    var data = (value/max)*100;
    console.log(data);
    function frame() {
        if(data != 0){
            if (width >= data) {
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
