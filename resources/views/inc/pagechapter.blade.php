<div class="center">
    <h1>บทสมการ</h1>
    <div class="grid-container">
        <div class="section1">
            <p>จำนวนแบบฝึกหัดที่ทำได้ครั้งล่าสุด</p>
            <div>
                <img class="cup" src="picture/trophy.png">
            </div>
            <p class="main-score">13/20</p>
            <div>
                <div class="div-score div-score-color1">
                    <label>ระดับยาก (ข้อ)</label>
                    <p class="score">6/10</p>
                </div>
                <div class="div-score div-score-color2">
                    <label>ระดับกลาง (ข้อ)</label>
                    <p class="score">7/10</p>
                </div>
                <div class="div-score div-score-color3">
                    <label>ระดับง่าย (ข้อ)</label>
                    <p class="score">0/0</p>
                </div>
            </div>
        </div>
        <div class="section2">
            <div class="sub-section">
                <canvas id="linechart"></canvas>
            </div>
            <div class="sub-section">
                <canvas id="barchart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
function openNav() {
document.getElementById("mySidenav").style.width = "calc(200px + 2vw)";
}

function closeNav() {
document.getElementById("mySidenav").style.width = "0";
}
Chart.defaults.global.defaultFontSize = 15;


var bar = document.getElementById('barchart').getContext('2d');
  var line = document.getElementById('linechart').getContext('2d');
var lineChart = new Chart (line,{
  type:'line',
  data:{
    labels:[1,2,3,4,5,6,7,8,9,10],
    datasets:[
      {
        label : "นักเรียน",
        borderColor: ["#5cbcd2"],
        fill :false,
        data: [10,20,30,25,27,29,30,40,50,60,70]
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'คะแนนทีนักเรียนทำได้ในแต่ละครั้ง'
    }
  }
}
);

var barChart = new Chart (bar,{
  type:'bar',
  data:{
    datasets:[
      {
        label: "นักเรียน",
        backgroundColor: "#5cbcd2",
        data:  [36]
      },
      {
        label: "นักเรียนทั้งหมดในระบบ",
        backgroundColor: "#007d91",
        data: [50]
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'คะแนนที่นักเรียนได้ในครั้งล่าสุดเปรียบเทียบกับคะแนนเฉลี่ยของนักเรียนทั้งหมดในระบบ'
    },
    scales: {
      yAxes: [{
      ticks: {
      beginAtZero:true
        }
      }]
    }
  }
}
);
</script>
