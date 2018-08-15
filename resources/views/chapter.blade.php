<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="CSS/detail.css" />
        <!-- <link rel="stylesheet" href="footer.css" /> -->
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body>
        <div class="main-container">
            <div id="sideMenu">
                <button class="homeBtn">
                    <img class="imgHome" src="picture/home.png">
                </button>
                <img class="profileImg" src="picture/c96f90063fe961d88c043faa29b545b6.jpg">
                <p>Name</p>
                <div class="layoutMenu">
                    <p>วิชาคณิตศาสตร์</p>
                    <div class="menuBtn">
                        <a>สมการ</a>
                        <a>ห.ร.ม</a>
                    </div>
                    <p>วิชาภาษาอังกฤษ</p>
                    <div class="menuBtn">
                        <a>Eng1</a>
                        <a>Eng2</a>
                    </div>
                    <p>ดูคะแนนรวม</p>
                    <div class="menuBtn">
                        <a>Overall</a>
                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav">
                <a onclick="closeNav()" class="close-btn">Close</a>
                <button class="homeBtn">
                    <img class="imgHome" src="picture/home.png">
                </button>
                <img class="profileImg" src="picture/c96f90063fe961d88c043faa29b545b6.jpg">
                <p>Name</p>
                <div class="layoutMenu">
                    <p>วิชาคณิตศาสตร์</p>
                    <div class="menuBtn">
                        <a>สมการ</a>
                        <a>ห.ร.ม</a>
                    </div>
                    <p>วิชาภาษาอังกฤษ</p>
                    <div class="menuBtn">
                        <a>Eng1</a>
                        <a>Eng2</a>
                    </div>
                    <p>ดูคะแนนรวม</p>
                    <div class="menuBtn">
                        <a>Overall</a>
                    </div>
                </div>
            </div>
            <div class="content">
                <div id="navbar">
                        <div class="navLeft">
                            <div id="hamberger" onclick="openNav()"><img class="logo" src="picture/hamberger.png"></div>
                        </div>
                    <div class="navRight">
                        <a>สุพาพร</a>
                        <a class="navLogOut">ออกจากระบบ</a>
                    </div>
                </div>
                <div class="center">
                    <h1>บทสมการ</h1>
                    <div class="grid-container">
                        <div class="section1">
                            <p>จำนวนแบบฝึกหัดที่ทำได้ครั้งล่าสุด</p>
                            <div>
                                <img class="cup" src="picture/trophy.png">
                            </div>
                            <p class="main-score">13/20</p>
                            <div>
                                <div class="div-score div-score-color1">
                                    <label>ระดับยาก (ข้อ)</label>
                                    <p class="score">6/10</p>
                                </div>
                                <div class="div-score div-score-color2">
                                    <label>ระดับกลาง (ข้อ)</label>
                                    <p class="score">7/10</p>
                                </div>
                                <div class="div-score div-score-color3">
                                    <label>ระดับง่าย (ข้อ)</label>
                                    <p class="score">0/0</p>
                                </div>
                            </div>
                        </div>
                        <div class="section2">
                            <div class="sub-section">
                                <canvas id="linechart"></canvas>
                            </div>
                            <div class="sub-section">
                                <canvas id="barchart"></canvas>
                            </div>
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
                
                
                var bar = document.getElementById('barchart').getContext('2d');
                  var line = document.getElementById('linechart').getContext('2d');
                var lineChart = new Chart (line,{
                  type:'line',
                  data:{
                    labels:[1,2,3,4,5,6,7,8,9,10],
                    datasets:[
                      {
                        label : "นักเรียน",
                        borderColor: ["#5cbcd2"],
                        fill :false,
                        data: [10,20,30,25,27,29,30,40,50,60,70]
                      }
                    ]
                  },
                  options:{
                    title:{
                      display: true,
                      text: 'คะแนนทีนักเรียนทำได้ในแต่ละครั้ง'
                    }
                  }
                }
                );
                
                var barChart = new Chart (bar,{
                  type:'bar',
                  data:{
                    datasets:[
                      {
                        label: "นักเรียน",
                        backgroundColor: "#5cbcd2",
                        data:  [36]
                      },
                      {
                        label: "นักเรียนทั้งหมดในระบบ",
                        backgroundColor: "#007d91",
                        data: [50]
                      }
                    ]
                  },
                  options:{
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
                }
                );
                </script>
    </body>
</html>