@if(session()->has('student_score_chapter'))
<?php $level =  json_decode(session('level_total','default'),true); ?>
<script type="text/javascript">
  var student = @json(session('student_score_chapter','default'));
  var overall = @json(session('overall_score','default'));
  var st_count = @json(session('student_count','default'));
  var lv_total = @json(session('level_total','default'));
  var lv_true = @json(session('level_true','default'));

  var student_score_chapter = [];
  var chapter_group = [];
  var chapter_name = [];
  var student_count = [];
  var overall_score = [];
  var level_total_easy = [];
  var level_total_medium = [];
  var level_total_hard = [];
  var level_true_easy = [];
  var level_true_medium = [];
  var level_true_hard = [];
  var level_name = [];

  chapter_name.push(student[0].chapter_name);
  student_count.push(st_count[0].count);
  // overall_score.push(overall[0].score/student_count);

  for (var i = 1; i <= student.length; i++) {
    student_score_chapter.push(Number(student[i-1].score));
    chapter_group.push('ชุดที่ '+ i);
  }

  for (var i = 0; i < lv_total.length; i++) {
    if (i === 0) {
      level_total_easy.push(lv_total[i].level_total);
      level_true_easy.push(lv_true[i].level_true);
      level_true_easy.push(level_total_easy[0]-level_true_easy[0]);
    } else if (i === 1) {
      level_total_medium.push(lv_total[i].level_total);
      level_true_medium.push(lv_true[i].level_true);
      level_true_medium.push(level_total_medium[0]-level_true_medium[0]);
    } else if (i === 2) {
      level_total_hard.push(lv_total[i].level_total);
      level_true_hard.push(lv_true[i].level_true);
      level_true_hard.push(level_total_hard[0]-level_true_hard[0]);
    }
    level_name.push(lv_total[i].level_name);
    overall_score.push(overall[0].score/student_count);
  }

  console.log(level_total_hard);

  var bar = document.getElementById('barChart_chapter').getContext('2d');

   //*****
  var pie_easy = document.getElementById('pieChart_chapter_easy').getContext('2d');
  var pie_medium = document.getElementById('pieChart_chapter_medium').getContext('2d');
  var pie_hard = document.getElementById('pieChart_chapter_hard').getContext('2d');

  var line = document.getElementById('lineChart_chapter').getContext('2d');
  Chart.defaults.global.defaultFontSize = 20;
  Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";
  if (level_total_easy[0] == 1) {
    level_true_easy[1] = 1;
  }if (level_total_medium[0] == 1) {
    level_true_medium[1] = 1;
  }if (level_total_hard[0] == 1) {
    level_true_hard[1] = 1;
  }
  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels: chapter_group,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#fec956",
          data:  student_score_chapter
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#32d36b",
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
  var pieChart_easy = new Chart (pie_easy,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#ff525b"],
        data:level_true_easy
      },
      {
        backgroundColor: ["#ff525b"],
        data:level_total_easy
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'ระดับง่าย'
    },
    tooltips: {
      filter: function (tooltipItem, data) {
      var label = data.labels[tooltipItem.index];

      if (tooltipItem.datasetIndex === 0 && tooltipItem.index % 2 !== 0) {
        return false;
      } else {
        return true;
      }
  },
         callbacks: {
             label: function(tooltipItem, data) {
                 var label = data.datasets[tooltipItem.datasetIndex].label || '';
                 var total = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                 console.log(label);
                 console.log(total);
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
  var pieChart_medium = new Chart (pie_medium,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#5fbddf"],
        data:level_true_medium
      },
      {
        backgroundColor: ["#5fbddf"],
        data:level_total_medium
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'ระดับกลาง'
    },
    tooltips: {
      filter: function (tooltipItem, data) {
      var label = data.labels[tooltipItem.index];

      if (tooltipItem.datasetIndex === 0  && tooltipItem.index % 2 !== 0) {
        return false;
      } else {
        return true;
      }
  },
         callbacks: {
             label: function(tooltipItem, data) {
                 var label = data.datasets[tooltipItem.datasetIndex].label || '';
                 var total = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                 label += total;

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
  var pieChart_hard = new Chart (pie_hard,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#ff525b"],
        data:level_true_hard
      },
      {
        backgroundColor: ["#ff525b"],
        data:level_total_hard
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'ระดับยาก'
    },
    tooltips: {
      filter: function (tooltipItem, data) {
      var label = data.labels[tooltipItem.index];

      if (tooltipItem.datasetIndex === 0  && tooltipItem.index % 2 !== 0) {
        return false;
      } else {
        return true;
      }
  },
         callbacks: {
             label: function(tooltipItem, data) {
                 var label = data.datasets[tooltipItem.datasetIndex].label || '';
                 var total = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                 label += total;

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
