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
 var pie_subj1_total =[];
 var pie_subj1_true=[];
 var pie_subj2_total =[];
 var pie_subj2_true=[];
 var subj1_name = [];
 var subj2_name = [];


 for (var i = 0; i < student.length; i++) {
   subject_name.push(student[i].name);
   student_score_allsubject.push(Number(student[i].score));
   student_score_count.push(score_count[i].count);
   overall_score.push(Number(overall[i].overall));
   student_count.push(st_count[i].student_count);
   student_score_allsubject[i] /= student_score_count[i]; //คะแนนบาร์ชาตนักเรียน
   overall_score[i] = (overall_score[i]+student_score_allsubject[i]) / student_count[i]; //คะแนนบาร์ชาตรวม


   if (i === 0) {
     pie_subj1_total.push(Number(inside[i].inside));
     pie_subj1_true.push(Number(outside[i].outside));
     pie_subj1_true.push(pie_subj1_total[0]-pie_subj1_true[0]);
     subj1_name.push(student[i].name);
   } else if (i === 1) {
     pie_subj2_total.push(Number(inside[i].inside));
     pie_subj2_true.push(Number(outside[i].outside));
     pie_subj2_true.push(pie_subj2_total[0]-pie_subj2_true[0]);
     subj2_name.push(student[i].name);
   }
 }
  console.log(pie_subj1_total);
  console.log(pie_subj1_true);
  console.log(subj1_name);

  var bar = document.getElementById('barChart_allsubject').getContext('2d');
  var pie_subj1 = document.getElementById('pieChart_allsubject_subj1').getContext('2d');
  var pie_subj2 = document.getElementById('pieChart_allsubject_subj2').getContext('2d');
  Chart.defaults.global.defaultFontSize = 20;
  Chart.defaults.global.elements.rectangle.borderWidth = 0;
  Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";
  var barChart = new Chart (bar,{
    type:'bar',
    data:{
      labels:subject_name,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#fec956",
          borderWidth : 0,
          data:student_score_allsubject

        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#32d36b",
          borderWidth : 0,
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

var pieChart_subj1 = new Chart (pie_subj1,{
  type:'pie',
  data:{
    datasets:[
      {
        backgroundColor: ["#ff525b"],
        data:pie_subj1_true
      },
      {
        backgroundColor: ["#ff525b"],
        data:pie_subj1_total
      }
    ]
  },
  options:{
    title:{
      display: true,
      text: subj1_name
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

  var pieChart_subj2 = new Chart (pie_subj2,{
    type:'pie',
    data:{
      datasets:[
        {
          backgroundColor: ["#5fbddf"],
          data:pie_subj2_true
        },
        {
          backgroundColor: ["#5fbddf"],
          data:pie_subj2_total
        }
      ]
    },
    options:{
      title:{
        display: true,
        text: subj2_name
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
