<?php
  $sumoverall = json_decode(session('sumoverall','default'), true);
  $sumsub1 = json_decode(session('sumsub1','default'), true);
  $sumsub2 = json_decode(session('sumsub2','default'), true);
 ?>
<div class="center">
    <h1>จำนวนแบบฝึกหัดที่นักเรียนทำได้</h1>
    <div class="section2">
        <div class="sub-section">
            <p>จำนวนแบบฝึกหัดที่ทำได้</p>
            <div class="layout-score-subject">
                <div>
                    <img class="cup" src="picture/trophy.png">
                </div>
                <div>
                    <p class="main-score-subject">{{$sumoverall[0]['true']}}/{{$sumoverall[0]['max']}}</p>
                    <label>จำนวนข้อทั้งหมดที่ทำได้</label>
                </div>
            </div>
            <div class="layout-score2">
                <div class="div-score div-score-color1">
                    <label>Math (ข้อ)</label>
                    <p class="score">@if($sumsub1[0]['max']){{$sumsub1[0]['true']}}/{{$sumsub1[0]['max']}}@else 0/0 @endif</p>
                </div>
                <div class="div-score div-score-color2">
                    <label>English (ข้อ)</label>
                    <p class="score">@if($sumsub2[0]['max']){{$sumsub2[0]['true']}}/{{$sumsub2[0]['max']}}@else 0/0 @endif</p>
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
  function openNav() {
  document.getElementById("mySidenav").style.width = "calc(200px + 2vw)";
  }

  function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  }
  Chart.defaults.global.defaultFontSize = 15;
  Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";

  var student = @json(session('student_score_allsubject','default'));
  var score_count = @json(session('student_score_count','default'));
  var overall = @json(session('overall_score','default'));
  var st_count = @json(session('student_count','default'));

  var subject_name = [];
  var student_score_allsubject = [];
  var student_score_count = [];
  var overall_score = [];
  var student_count = [];

  for (var i = 0; i < student.length; i++) {
    subject_name.push(student[i].name);
    student_score_allsubject.push(Number(student[i].score));
    student_score_count.push(score_count[i].count);
    overall_score.push(Number(overall[i].overall));
    student_count.push(st_count[i].student_count);
    student_score_allsubject[i] /= student_score_count[i]; //คะแนนบาร์ชาตนักเรียน
    overall_score[i] = ((overall_score[i]+student_score_allsubject[i]) / student_count[i]).toFixed(2); //คะแนนบาร์ชาตรวม
  }

  var bar = document.getElementById('barchart').getContext('2d');

  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#5cbcd2",
          data:  student_score_allsubject
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#007d91",
          data: overall_score
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
