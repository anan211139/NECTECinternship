<?php
  $subject_status = session('subject_status','default');
  $max = json_decode(session('maxchapter','default'), true);
  $score = json_decode(session('scorechapter','default'), true);
  $sumoverall = json_decode(session('sumoverall','default'), true);
  $substatus = json_decode(session('substatus','default'), true);
?>
<div class="center">
    <h1>{{$substatus[0]['name']}}</h1>
    <div class="section2">
        <div class="sub-section">
            <p>จำนวนแบบฝึกหัดที่ทำได้</p>
            <div class="layout-score-subject">
                <div>
                    <img class="cup" src="picture/trophy.png">
                </div>
                <div>
                    <p class="main-score-subject">@if($sumoverall[0]['max']){{$sumoverall[0]['true']}}/{{$sumoverall[0]['max']}}@else 0/0 @endif</p>
                    <label>จำนวนข้อทั้งหมดที่ทำได้</label>
                </div>
            </div>
            @if($subject_status == 1)
            <div class="layout-score2">
                <div class="div-score div-score-color1">
                    <label>{{$chapther_list[0]['name']}} (ข้อ)</label>
                    <p class="score">
                      @php
                      $index = 0;
                      $haveData = False;
                      @endphp
                      @for($i=0;$i<2;$i++)
                        @if(isset($max[$i]['max']))
                          @if($max[$i]['id'] == 1)
                            @php
                              $haveData = True;
                              $index = $i;
                            @endphp
                          @endif
                        @endif
                      @endfor
                      @if($haveData)
                        {{$score[$index]['score']}}/{{$max[$index]['max']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
                <div class="div-score div-score-color2">
                    <label>{{$chapther_list[1]['name']}} (ข้อ)</label>
                    <p class="score">
                      @php
                      $index2 = 0;
                      $haveData2 = False;
                      @endphp
                      @for($i=0;$i<2;$i++)
                        @if(isset($max[$i]['max']))
                          @if($max[$i]['id'] == 2)
                            @php
                              $haveData2 = True;
                              $index2 = $i;
                            @endphp
                          @endif
                        @endif
                      @endfor
                      @if($haveData2)
                        {{$score[$index2]['score']}}/{{$max[$index2]['max']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
            </div>
            @elseif($subject_status == 2)
            <div class="layout-score2">
                <div class="div-score div-score-color1">
                    <label>{{$chapther_list[2]['name']}} (ข้อ)</label>
                    <p class="score">
                    @php
                    $index = 0;
                    $haveData = False;
                    @endphp
                    @for($i=0;$i<2;$i++)
                      @if(isset($max[$i]['max']))
                        @if($max[$i]['id'] == 3)
                          @php
                            $haveData = True;
                            $index = $i;
                          @endphp
                        @endif
                      @endif
                    @endfor
                    @if($haveData)
                      {{$score[$index]['score']}}/{{$max[$index]['max']}}
                    @else
                      0/0
                    @endif</p>
                </div>
                <div class="div-score div-score-color2">
                    <label>{{$chapther_list[3]['name']}} (ข้อ)</label>
                    <p class="score">
                      @php
                      $index2 = 0;
                      $haveData2 = False;
                      @endphp
                      @for($i=0;$i<2;$i++)
                        @if(isset($max[$i]['max']))
                          @if($max[$i]['id'] == 4)
                            @php
                              $haveData2 = True;
                              $index2 = $i;
                            @endphp
                          @endif
                        @endif
                      @endfor
                      @if($haveData2)
                        {{$score[$index2]['score']}}/{{$max[$index2]['max']}}
                      @else
                        0/0
                      @endif
                    </p>
                </div>
            </div>
            @endif
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

  var countgroups = @json(session('countgroups','default'));


  var student_score = [];
  var score_above = [];
  var score_below = [];
  var chapter_name = [];
  for (var i = 0; i < student_data.length; i++) {
    student_score.push(student_data[i].score/countgroups[i].count);
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
  Chart.defaults.global.defaultFontSize = 20;
  Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";

  var bar = document.getElementById('barchart').getContext('2d');

  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels:chapter_name,
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
      },
      tooltips: {
           callbacks: {
               label: function(tooltipItem, data) {
                   var label = data.datasets[tooltipItem.datasetIndex].label || '';
                   if (label) {
                       label += ': ';
                   }
                   label += Math.round(tooltipItem.yLabel * 100) / 100;
                   return label + " " + "คะแนน";
               }
           }
         }
    }
  }
);
</script>
