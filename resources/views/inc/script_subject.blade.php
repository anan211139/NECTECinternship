@if(session()->has('student_score_chapter'))
<script type="text/javascript">
  var student_data = @json(session('student_score','default'));
  var above = @json(session('above','default'));
  var below = @json(session('below','default'));
  var inside = @json(session('pie_inside','default'));
  var outside = @json(session('pie_outside','default'));
  console.log(outside);
  var student_score = [];
  var group = [];
  var ch1_name = [];
  var ch2_name = [];
  var score_above = [];
  var score_below = [];
  var pie_ch1_total =[];
  var pie_ch1_true=[];
  var pie_ch2_total =[];
  var pie_ch2_true=[];
  var chapter_name = [];
  var sum = 0;


  for (var i = 0; i < student_data.length; i++) {
    student_score.push(student_data[i].score);
    score_above.push(Number(above[i].above));
    score_below.push(Number(below[i].below));
    chapter_name.push(student_data[i].name);
    score_above[i] /= score_below[i];

    if (i === 0) {
      pie_ch1_total.push(Number(inside[i].pie_inside));
      pie_ch1_true.push(Number(outside[i].pie_outside));
      pie_ch1_true.push(pie_ch1_total[0]-pie_ch1_true[0]);
      ch1_name.push(student_data[i].name);
    } else if (i === 1) {
      pie_ch2_total.push(Number(inside[i].pie_inside));
      pie_ch2_true.push(Number(outside[i].pie_outside));
      pie_ch2_true.push(pie_ch2_total[0]-pie_ch2_true[0]);
      ch2_name.push(student_data[i].name);
    }

  }

  var bar = document.getElementById('barChart_subject').getContext('2d');
  var pie_ch1 = document.getElementById('pieChart_subject_ch1').getContext('2d');
  var pie_ch2 = document.getElementById('pieChart_subject_ch2').getContext('2d');
Chart.defaults.global.defaultFontSize = 20;
  Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";
  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels:chapter_name,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#fec956",
          data:student_score
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#32d36b",
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

var pieChart_ch1 = new Chart (pie_ch1,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#f0882f"],
        data:pie_ch1_true
      },
      {
        backgroundColor: ["#f0882f"],
        data:pie_ch1_total
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: ch1_name
    },
    tooltips: {
      filter: function (tooltipItem, data) {
      var label = data.labels[tooltipItem.index];
      console.log(tooltipItem);
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
                 if (label) {
                     label += ': ';
                 }
                 label += total;
                 console.log(label);
                   if(tooltipItem.datasetIndex === 0){
                      return  "จำนวนข้อที่ทำได้"+ ":" + " " + label + " " + "ข้อ";
                   } else if (tooltipItem.datasetIndex === 1) {
                     return  "จำนวนข้อที่ได้ทำ" + ":" + " " + label + " " + "ข้อ";
                   }
             }
         }
       }
  }
}
);

var pieChart_ch2 = new Chart (pie_ch2,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#013f73"],
        data:pie_ch2_true
      },
      {
        backgroundColor: ["#013f73"],
        data:pie_ch2_total
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: ch2_name
    },
    tooltips: {
      filter: function (tooltipItem, data) {
      var label = data.labels[tooltipItem.index];
      console.log(tooltipItem);
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
                 if (label) {
                     label += ': ';
                 }
                 label += total;
                 console.log(label);
                   if(tooltipItem.datasetIndex === 0){
                      return  "จำนวนข้อที่ทำได้"+ ":" + " " + label + " " + "ข้อ";
                   } else if (tooltipItem.datasetIndex === 1) {
                     return  "จำนวนข้อที่ได้ทำ" + ":" + " " + label + " " + "ข้อ";
                   }
             }
         }
       }
  }
}
);

</script>
@endif
