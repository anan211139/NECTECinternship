<script type="text/javascript">
  var student_data = @json($student_score);
  var above = @json($above);
  var below = @json($below);
  var inside = @json($pie_inside);
  var outside = @json($pie_outside);

  var student_score = [];
  var group = [];
  var chapter_name = [];
  var score_above = [];
  var score_below = [];
  var pie_inside =[];
  var pie_outside=[];
  var sum =0;


  for (var i = 0; i < student_data.length; i++) {
    student_score.push(student_data[i].score);
    chapter_name.push(student_data[i].name);
    score_above.push(Number(above[i].above));
    score_below.push(below[i].below);
    score_above[i] /= score_below[i];

    pie_inside.push(Number(inside[i].pie_inside));
    pie_outside.push(Number(outside[i].pie_outside));
  }
  console.log(pie_inside);
  console.log(pie_outside);
  var bar = document.getElementById('barChart_subject').getContext('2d');
  var pie = document.getElementById('pieChart_subject').getContext('2d');
  Chart.defaults.global.defaultFontSize = 20;  //font-size in graph
  var barChart = new Chart (bar,{
    type:'bar',//ชนิตกราฟ
    data:{
      labels:chapter_name,
      datasets:[
        {
          label: "นักเรียน",
          backgroundColor: "#f0882f",
          data:student_score
        },
        {
          label: "นักเรียนทั้งหมดในระบบ",
          backgroundColor: "#013f73",
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

    }tooltips: {
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
  );

  var pieChart = new Chart (pie,{
  type:'pie',
  data:{
    labels:chapter_name,
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
      text: 'จำนวนแบบฝึกหัดที่ทำได้ในแต่ละบท'
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
