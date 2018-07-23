@if(session()->has('student_score_allsubject'))

<script type="text/javascript">
 var student = @json(session('student_score_allsubject','default'));
 var score_count = @json(session('student_score_count','default'));
 var overall = @json(session('overall_score','default'));
 var st_count = @json(session('student_count','default'));
 var inside =  @json(session('pie_inside','default'));
 var outside = @json(session('pie_outside','default'));
 console.log(student);

 var subject_name = [];
 var student_score_allsubject = [];
 var student_score_count = [];
 var overall_score = [];
 var student_count = [];
 var pie_inside = [];
 var pie_outside = [];


 for (var i = 0; i < student.length; i++) {
   subject_name.push(student[i].name);
   student_score_allsubject.push(Number(student[i].score));
   student_score_count.push(score_count[i].count);
   overall_score.push(Number(overall[i].overall));
   student_count.push(st_count[i].student_count);
   student_score_allsubject[i] /= student_score_count[i]; //คะแนนบาร์ชาตนักเรียน
   overall_score[i] = (overall_score[i]+student_score_allsubject[i]) / student_count[i]; //คะแนนบาร์ชาตรวม
   console.log(overall_score[i]);

   pie_inside.push(inside[i].inside);
   pie_outside.push(outside[i].outside);
 }
 console.log(overall_score);

  var bar = document.getElementById('barChart_allsubject').getContext('2d');
  var pie = document.getElementById('pieChart_allsubject').getContext('2d');
  Chart.defaults.global.defaultFontSize = 20;
  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels:subject_name,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#f0882f",
          data:student_score_allsubject
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
        text: 'คะแนนที่ได้ในแต่ละวิชา'
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

var pieChart = new Chart (pie,{
  type:'pie',
  data:{
    labels:subject_name,
    datasets:[
      {
        backgroundColor: ["#f0882f","#013f73"],
        data:pie_outside
      },
      {
        backgroundColor: ["#f0882f","#013f73"],
        data:pie_inside
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: 'จำนวนแบบฝึกหัดที่ทำได้ในแต่ละวิชา'
    },
    tooltips: {
         callbacks: {
//          title: function (tooltipItem, data){
//          console.log( data);
//          return "จำนวนข้อที่ทำได้" ;
//       },
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
</script>
@endif
