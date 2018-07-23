@if(session()->has('student_score_chapter'))

<script type="text/javascript">
  var student = @json(session('student_score_chapter','default'));
  var overall = @json(session('overall_score','default'));
  var st_count = @json(session('student_count','default'));
  var lv_total = @json(session('level_total','default'));
  var lv_true = @json(session('level_true','default'));
  console.log(overall);

  var student_score_chapter = [];
  var chapter_group = [];
  var chapter_name = [];
  var student_count = [];
  var overall_score = [];
  var level_total = [];
  var level_true = [];
  var level_name = [];

  chapter_name.push(student[0].chapter_name);
  student_count.push(st_count[0].count);
  // overall_score.push(overall[0].score/student_count);

  for (var i = 1; i <= student.length; i++) {
    student_score_chapter.push(Number(student[i-1].score));
    chapter_group.push('ชุดที่ '+ i);
  }

  for (var i = 0; i < lv_total.length; i++) {
    level_total.push(lv_total[i].level_total);
    level_name.push(lv_total[i].level_name);
    level_true.push(lv_true[i].level_true);
    overall_score.push(overall[0].score/student_count);
  }
  console.log(level_total);
  console.log(level_name);
  console.log(level_true);

  var bar = document.getElementById('barChart_chapter').getContext('2d');
  var pie = document.getElementById('pieChart_chapter').getContext('2d');
  var line = document.getElementById('lineChart_chapter').getContext('2d');
  Chart.defaults.global.defaultFontSize = 20;
  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels: chapter_group,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#f0882f",
          data:  student_score_chapter
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#013f73",
          data: overall_score
        }
      ]
      },
      options:{
        title:{
          display: true,
          text: 'คะแนนที่ได้ในแต่ละชุด'
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
                  // console.log(tooltipItem.yLabel);
                  //    console.log(label);

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

  var pieChart = new Chart (pie,{
    type:'pie',
    data:{
      labels:level_name,
      datasets:[
        {
          backgroundColor: ["#f0882f","#013f73"],
          data:level_true
        },
        {
          backgroundColor: ["#f0882f","#013f73"],
          data:level_total
        }
      ]
    },
    options:{
      title:{
        display: true,
        text: 'จำนวนแบบฝึกหัดที่ทำได้ในแต่ละระดับ'
      },
      tooltips: {
           callbacks: {
  //             title: function (tooltipItem, data){
  // console.log( data);
  //                  return "จำนวนข้อที่ทำได้" ;
  //             },
               label: function(tooltipItem, data) {
                   var label = data.datasets[tooltipItem.datasetIndex].label || '';
                   var total = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                   label += total;
                   console.log(label);
                     if(tooltipItem.datasetIndex === 0){
                        return  "จำนวนข้อที่ทำได้"+ ":" + " " +  + label + " " + "ข้อ";
                     } else if (tooltipItem.datasetIndex === 1) {
                       return  "จำนวนข้อที่ได้ทำ" + ":" + " " + label + " " + "ข้อ";
                     }
               }
           }
         }
    }
  }
  );

  var lineChart = new Chart (line,{
    type:'line',
    data:{
      labels:chapter_group,
      datasets:[
        {
          label : "นักเรียน",
          borderColor: ["#f0882f"],
          fill :false,
          data: student_score_chapter

        }
      ]
    },
    options:{
      title:{
        display: true,
        text: 'คะแนนที่ได้ในแต่ละชุด'
      }
    }
  }
  );
</script>
@endif
