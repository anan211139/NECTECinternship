<?php
    $extenlevel = json_decode(session('extenlevel','default'), true);
    $chapterstatus = json_decode(session('chapterstatus','default'), true);
    $scoreeverbody = json_decode(session('scoreeverbody','default'), true);

    $totalmax = 0;
    $totaltrue = 0;

    for ($i=0; $i < count($extenlevel) ; $i++) {
      $totalmax += $extenlevel[$i]['total_level'];
    }
    for ($i=0; $i < count($extenlevel) ; $i++) {
      $totaltrue += $extenlevel[$i]['total_level_true'];
    }
 ?>

<div class="center">
    <h1>{{$chapterstatus[0]['name']}}</h1>
    <div class="grid-container">
        <div class="section1">
            <p>จำนวนแบบฝึกหัดที่ทำได้ครั้งล่าสุด</p>
            <div>
                <img class="cup" src="picture/trophy.png">
            </div>
            <p class="main-score">{{$totaltrue}}/{{$totalmax}}</p>
            <div>
                <div class="div-score div-score-color1">
                    <label>ระดับยาก (ข้อ)</label>
                    <p class="score">
                      @php
                        $index = 0;
                        $haveData = False;
                      @endphp
                      @for($i=0;$i<count($extenlevel);$i++)
                        @if($extenlevel[$i]['level_id'] == 3)
                          @php
                            $haveData = True;
                            $index = $i;
                          @endphp
                        @endif
                      @endfor
                      @if($haveData)
                        {{$extenlevel[$index]['total_level_true']}}/{{$extenlevel[$index]['total_level']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
                <div class="div-score div-score-color2">
                    <label>ระดับกลาง (ข้อ)</label>
                    <p class="score">
                      @php
                        $index2 = 0;
                        $haveData2 = False;
                      @endphp
                      @for($i=0;$i<count($extenlevel);$i++)
                        @if($extenlevel[$i]['level_id'] == 2)
                          @php
                            $haveData2 = True;
                            $index2 = $i;
                          @endphp
                        @endif
                      @endfor
                      @if($haveData2)
                        {{$extenlevel[$index2]['total_level_true']}}/{{$extenlevel[$index2]['total_level']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
                <div class="div-score div-score-color3">
                    <label>ระดับง่าย (ข้อ)</label>
                    <p class="score">
                      @php
                        $index3 = 0;
                        $haveData3 = False;
                      @endphp
                      @for($i=0;$i<count($extenlevel);$i++)
                        @if($extenlevel[$i]['level_id'] == 1)
                          @php
                            $haveData3 = True;
                            $index3 = $i;
                          @endphp
                        @endif
                      @endfor
                      @if($haveData3)
                        {{$extenlevel[$index3]['total_level_true']}}/{{$extenlevel[$index3]['total_level']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="section2">
            <div class="sub-section">
                <canvas id="linechart"></canvas>
            </div>
            <div class="sub-section">
                <canvas id="TESTmixchart"></canvas>
            </div>
        </div>
    </div>
    <!-- <div class="test">
        <canvas id="TESTmixchart" width="700" height="500"></canvas>
    </div> -->
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

  // var bar = document.getElementById('barchart').getContext('2d');
  var line = document.getElementById('linechart').getContext('2d');
  var mix = document.getElementById('TESTmixchart').getContext('2d');

  var student = @json(session('student_score_chapter','default'));
  var overall = @json(session('overall_score','default'));
  var st_count = @json(session('student_count','default'));
  var st_score_everybody = @json(session('scoreeverbody','default'));

  var student_score_chapter = [];
  var chapter_group = [];
  var overall_score = [];
  var student_count = [];
  var scorebar = [];
  var countscorelength = [0,0,0,0,0,0,0,0,0,0,0];
  var colorarray = ["#007d91","#007d91","#007d91","#007d91","#007d91","#007d91","#007d91","#007d91","#007d91","#007d91","#007d91"];

  student_count.push(st_count[0].count);
  overall_score.push((overall[0].score/student_count).toFixed(2));
  for (var i = 1; i <= student.length; i++) {
    student_score_chapter.push(Number(student[i-1].score));
    chapter_group.push('ชุดที่ '+ i);
  }
  if (student.length) {
    scorebar.push(Number(student[student.length-1].score));
  }

  for (var i = 0; i < st_score_everybody.length; i++) {
    if (st_score_everybody[i].score >= 0 && st_score_everybody[i].score <= 5) {
      countscorelength[0]++;
    }if (st_score_everybody[i].score >= 6 && st_score_everybody[i].score <= 10) {
      countscorelength[1]++;
    }if (st_score_everybody[i].score >= 11 && st_score_everybody[i].score <= 15) {
      countscorelength[2]++;
    }if (st_score_everybody[i].score >= 16 && st_score_everybody[i].score <= 20) {
      countscorelength[3]++;
    }if (st_score_everybody[i].score >= 21 && st_score_everybody[i].score <= 25) {
      countscorelength[4]++;
    }if (st_score_everybody[i].score >= 26 && st_score_everybody[i].score <= 30) {
      countscorelength[5]++;
    }if (st_score_everybody[i].score >= 31 && st_score_everybody[i].score <= 35) {
      countscorelength[6]++;
    }if (st_score_everybody[i].score >= 36 && st_score_everybody[i].score <= 40) {
      countscorelength[7]++;
    }if (st_score_everybody[i].score >= 41 && st_score_everybody[i].score <= 45) {
      countscorelength[8]++;
    }if (st_score_everybody[i].score >= 46 && st_score_everybody[i].score <= 50) {
      countscorelength[9]++;
    }if (st_score_everybody[i].score >= 51 && st_score_everybody[i].score <= 55) {
      countscorelength[10]++;
    }
  }
  console.log(scorebar);
  if (scorebar[0] >= 0 && scorebar[0] <= 5) {
    colorarray[0] = "#5cbcd2";
  }if (scorebar[0] >= 6 && scorebar[0] <= 10) {
    colorarray[1] = "#5cbcd2";
  }if (scorebar[0] >= 11 && scorebar[0] <= 15) {
    colorarray[2] = "#5cbcd2";
  }if (scorebar[0] >= 16 && scorebar[0] <= 20) {
    colorarray[3] = "#5cbcd2";
  }if (scorebar[0] >= 21 && scorebar[0] <= 25) {
    colorarray[4] = "#5cbcd2";
  }if (scorebar[0] >= 26 && scorebar[0] <= 30) {
    colorarray[5] = "#5cbcd2";
  }if (scorebar[0] >= 31 && scorebar[0] <= 35) {
    colorarray[6] = "#5cbcd2";
  }if (scorebar[0] >= 36 && scorebar[0] <= 40) {
    colorarray[7] = "#5cbcd2";
  }if (scorebar[0] >= 41 && scorebar[0] <= 45) {
    colorarray[8] = "#5cbcd2";
  }if (scorebar[0] >= 46 && scorebar[0] <= 50) {
    colorarray[9] = "#5cbcd2";
  }if (scorebar[0] >= 51 && scorebar[0] <= 55) {
    colorarray[10] = "#5cbcd2";
  }
  console.log(colorarray);
  console.log(countscorelength);

  var lineChart = new Chart (line,{
    type:'line',
    data:{
      labels:[1,2,3,4,5,6,7,8,9,10],
      datasets:[
        {
          label : "นักเรียน",
          borderColor: ["#5cbcd2"],
          fill :false,
          data: student_score_chapter
        }
      ]
    },
    options:{
      title:{
        display: true,
        text: 'คะแนนทีนักเรียนทำได้ในแต่ละครั้ง (10ครั้งล่าสุด)'
      }
    }
  }
  );

  // var barChart = new Chart (bar,{
  //   type:'bar',
  //   data:{
  //     datasets:[
  //       {
  //         label: "นักเรียน",
  //         backgroundColor: "#5cbcd2",
  //         data:  scorebar
  //       },
  //       {
  //         label: "นักเรียนทั้งหมดในระบบ",
  //         backgroundColor: "#007d91",
  //         data: overall_score
  //       }
  //     ]
  //   },
  //   options:{
  //     title:{
  //       display: true,
  //       text: 'คะแนนที่นักเรียนได้ในครั้งล่าสุดเปรียบเทียบกับคะแนนเฉลี่ยของนักเรียนทั้งหมดในระบบ'
  //     },
  //     scales: {
  //       yAxes: [{
  //       ticks: {
  //       beginAtZero:true
  //         }
  //       }]
  //     }
  //   }
  // }
  // );






  var mixedChart = new Chart(mix, {
  type: 'bar',
  data: {
    datasets: [{
          label: "จำนวนนักเรียน",
          data: countscorelength,
          backgroundColor: colorarray,
          type: 'bar'
        }],
    labels:["0-5","5-10","10-15","15-20","20-25","25-30","30-35","35-40","40-45","45-50","50-55"]
  },
  options: {
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
});
</script>
