<?php
  $stu = session('childdata','default');
  $pointsub1 = session('sub1','default');
  $pointsub2 = session('sub2','default');
  $meansub1 = session('meansub1','default');
  $meansub2 = session('meansub2','default');
  $overall = ($meansub1[0]['mean']+$meansub2[0]['mean'])/2;
 ?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="css/dashboard.css" />
        <link rel="stylesheet" href="css/footer.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body>
        <div class="main-container">
            <div id="navbar">
                <div class="navLeft" onclick = "window.location.href = '/dashboard';">
                    <div><img class="logo" src="picture/bear_N.png"></div>
                    <div class="logoBtn">พี่หมีติวเตอร์</div>
                </div>
                <div class="navRight">
                    <a href="/dashboard" class="F">{{session('name','default')}}</a>
                    <a class="navLogOut" href="/logout" >ออกจากระบบ</a>
                </div>
            </div>
            <div class="section1">
                <div class="item colorGreen">
                    <label class="label">จำนวนนักเรียนในห้อง (คน)</label>
                    <div class="value">{{count($stu)}}</div>
                </div>
                <div class="item colorYellow">
                    <label class="label">ค่าเฉลี่ยของนักเรียนทั้งหมด</label>
                    <div class="layoutScore">
                        <div class="value">{{number_format($overall, 2, '.', '')}}</div>
                        <div class="smallLabel">/55</div>
                    </div>
                </div>
                <div class="item colorBlue">
                    <label class="label">อันดับของห้องเรียน</label>
                    <div class="layoutScore">
                        <div class="value">1</div>
                        <div class="smallLabel">/10</div>
                    </div>
                </div>
            </div>
            <div class="section2">
                <div class="section2_1">
                    <div class="subSection1">
                        <h3 class="align-left">ข้อสอบทั้งหมด</h3>
                        <div class="barCon">
                            <p class="align-left label">ข้อสอบคณิตศาสตร์</p>
                            <div class="pro">
                                <div id="bar1" class="bar" style="background-color: #ff525b;"></div>
                            </div>
                            <label class="smallLabel">นักเรียนทำข้อสอบไปแล้ว {{count($pointsub1)}} จาก {{count($stu)}} คน</label>
                        </div>
                        <div class="barCon">
                            <p class="align-left label">ข้อสอบภาษาอังกฤษ</p>
                            <div class="pro">
                                <div id="bar2" class="bar" style="background-color: #5fbddf;"></div>
                            </div>
                            <label class="smallLabel">นักเรียนทำข้อสอบไปแล้ว {{count($pointsub2)}} จาก {{count($stu)}} คน</label>
                        </div>
                    </div>
                </div>
                <div class="subSectionR">
                    <h3>ค่าเฉลี่ยรายวิชา</h3>
                    <div class="meanScore">
                        <div>
                            <label class="subjectIcon" style="background-color: #ff525b;">วิชาคณิตศาสตร์</label>
                            <div class="layoutScore">
                                <div class="value">{{number_format($meansub1[0]['mean'], 2, '.', '')}}</div>
                                <div class="smallLabel">/55</div>
                            </div>
                            <label class="smallLabel">ทำแล้ว {{count($pointsub1)}}/{{count($stu)}} คน</label>
                        </div>
                        <div>
                            <label class="subjectIcon" style="background-color: #5fbddf;">วิชาภาษาอังกฤษ</label>
                            <div class="layoutScore">
                                <div class="value">{{number_format($meansub2[0]['mean'], 2, '.', '')}}</div>

                                <div class="smallLabel">/55</div>
                            </div>
                            <label class="smallLabel">ทำแล้ว {{count($pointsub2)}}/{{count($stu)}} คน</label>
                        </div>
                    </div>
                        <!-- <div class="subSection1" style="margin-top: 1vw; padding-bottom: 22px;">
                            </div> -->
                </div>
            </div>
            <div class="section3">
                <div class="subSection1 overflow">
                    <div class="headT">
                        <h3>รายชื่อนักเรียนทั้งหมด</h3>
                        <form class="searchCon">
                            <input type="text" name="search" placeholder="Search">
                            <button type="submit">ค้นหา</button>
                        </form>
                    </div>
                    <table id="student">
                        <tr>
                            <th scope="col" rowspan="2"></th>
                            <th scope="col" rowspan="2">ชื่อ</th>
                            <th colspan="2" scope="colgroup">ค่าเฉลี่ยรายวิชา</th>
                        </tr>
                        <tr>
                            <th scope="col">คณิตศาสตร์</th>
                            <th scope="col">ภาษาอังกฤษ</th>
                        </tr>


                        @for($i = 0;$i < count($stu); $i++)
                        <tr onclick = "window.location.href = '/selectoverall/{{$stu[$i]['line_code']}}';">
                          <td><img src="@if($stu[$i]['local_pic']){{$stu[$i]['local_pic']}}@else picture/bear_N.png @endif"></td>
                          <td>{{$stu[$i]['name']}}</td>
                          <td>
                            @php
                            $index = 0;
                            $haveData = False;
                            @endphp
                            @for($j =0;$j < count($pointsub1);$j++)
                              @if($pointsub1[$j]['line_code'] == $stu[$i]['line_code'])
                                @php
                                  $haveData = True;
                                  $index = $j;
                                @endphp
                              @endif
                            @endfor
                            @if($haveData)
                              {{number_format($pointsub1[$index]['mean'])}}
                            @else
                              -
                            @endif
                          </td>
                          <td>
                            @php
                            $index2 = 0;
                            $haveData2 = False;
                            @endphp
                            @for($j =0;$j < count($pointsub2);$j++)
                              @if($pointsub2[$j]['line_code'] == $stu[$i]['line_code'])
                                @php
                                $haveData2 = True;
                                $index2 = $j;
                                @endphp
                              @endif
                            @endfor
                            @if($haveData2)
                              {{number_format($pointsub2[$index2]['mean'])}}
                            @else
                              -
                            @endif
                          </td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
            @include('inc.footer')
        </div>
        <script type="text/javascript" src="js/dashboard.js"></script>
    </body>
    <script type="text/javascript">
      var elemMath = document.getElementById("bar1");
      var elemEng = document.getElementById("bar2");
      var maxValue = {{count($stu)}};
      move({{count($pointsub1)}},elemMath,maxValue);
      move({{count($pointsub2)}},elemEng,maxValue);
      function move(value,elem,max) {
          var width = 0;
          var id = setInterval(frame, 15);
          var data = (value/max)*100;
          console.log(data);
          function frame() {
              if(data == 0 || max == 0){
                  elem.style.width = 0 + '%';
              } else {
                  if (width >= data) {
                  clearInterval(id);
                  } else {
                  width++;
                  elem.style.width = width + '%';
                  }
              }
          }
        }

    </script>

</html>
