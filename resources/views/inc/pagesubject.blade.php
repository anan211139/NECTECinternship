<?php

 ?>
<div class="center">
    <h1>วิชาคณิตศาสตร์</h1>
    <div class="section2">
        <div class="sub-section">
            <p>จำนวนแบบฝึกหัดที่ทำได้</p>
            <div class="layout-score-subject">
                <div>
                    <img class="cup" src="picture/trophy.png">
                </div>
                <div>
                    <p class="main-score-subject">40/60</p>
                    <label>จำนวนข้อทั้งหมดที่ทำได้</label>
                </div>
            </div>
            <div class="layout-score2">
                <div class="div-score div-score-color1">
                    <label>บทสมการ (ข้อ)</label>
                    <p class="score">25/40</p>
                </div>
                <div class="div-score div-score-color2">
                    <label>บทห.ร.ม (ข้อ)</label>
                    <p class="score">15/20</p>
                </div>
            </div>
        </div>
        <div class="sub-section">
            <canvas id="barchart"></canvas>
        </div>
    </div>
</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
  var student_data = @json(session('student_score','default'));
  var above = @json(session('above','default'));
  var below = @json(session('below','default'));

  var student_score = [];
  var score_above = [];
  var score_below = [];
  var chapter_name = [];
  for (var i = 0; i < student_data.length; i++) {
    student_score.push(student_data[i].score);
    score_above.push(Number(above[i].above));
    score_below.push(Number(below[i].below));
    chapter_name.push(student_data[i].name);
    score_above[i] /= score_below[i];
  }
  function openNav() {
  document.getElementById("mySidenav").style.width = "calc(200px + 2vw)";
  }

  function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  }
  Chart.defaults.global.defaultFontSize = 15;


  var bar = document.getElementById('barchart').getContext('2d');

  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#5cbcd2",
          data:student_score
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#007d91",
          data:score_above
        }
      ]
    },
    options:{
      title:{
        display: true,
        text: 'คะแนนที่ได้ในแต่ละบท'
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
