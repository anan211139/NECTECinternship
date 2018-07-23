<?php
  $childdata = session('childdata','default');
  $choosechild = session('choosechild','default');
  $subject_list = session('subject_list', 'default');
  $chapther_list = session('chapter_list', 'default');
  $count = count($childdata);
 ?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="css/progress.css" />
        <link rel="stylesheet" href="css/footer.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
        <!-- Graph -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    </head>
    <body>
        <div class="main-container">
            <div class="topnav" id="myTopnav">
                <div class="logotop">
                    <img class="logo" src="picture/bear_Nffff.png">
                    <p class="logoP">พี่หมีติวเตอร์</p>
                </div>
                <div id="menu">
                    <a href="" class="layoutMenu">{{session('name','default')}}</a>
                    <a href="/logout" class="layoutMenu">Log out</a>
                </div>
                <a  class="icon" onclick="openNav()">
                    <!-- <i class="fa fa-bars"></i> -->
                    <img class="logo" src="picture/hamberger.png">
                </a>
            </div>
            <div>
                <img class="image" src="picture/bgwater.png">
            </div>
            <div id="layoutDropdown" class="layoutDropdown">
                <div class="dropdown">
                    <button onclick="selectFunction()" id="nameBtn" class="dropbtn dropbtn2">
                      @for($i=0;$i<$count;$i++)
                        @if($choosechild == $childdata[$i]["line_code"])
                          <img class="avata" src="{{$childdata["$i"]["local_pic"]}}">
                          <p>{{$childdata["$i"]["name"]}}</p>
                          <img class="dropdownicon" src="picture/down-arrow.png">
                        @endif
                      @endfor
                    </button>
                    <div id="selectDropdown" class="dropdown-content">
                        <div id="child">
                          @for($i=0;$i<$count;$i++)
                            <a href="/choosechild/{{$childdata["$i"]["line_code"]}}">
                                <img class="avata" src="{{$childdata["$i"]["local_pic"]}}">
                                <p>{{$childdata[0]["name"]}}</p>
                            </a>
                          @endfor
                        </div>
                        <a onclick="document.getElementById('addPop').style.display='block'">
                            <img class="avata" src="picture/plus.png">
                        </a>
                        <a>ดูทั้งหมด</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="dropdownFunction()" class="dropbtn">
                        <p>เปลียนวิชา</p>
                        <img class="dropdownicon" src="picture/down-arrowblack.png">
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                      @for($i=0;$i<count($subject_list);$i++)
                          <ul class="main-navigation" onmouseover="hover();" onmouseout="unhover();">
                              <li class="list"><a href="/selectsubject/{{$subject_list["$i"]["id"]}}" class="a">{{$subject_list["$i"]["name"]}}<img id="rightarrow" class="dropdownicon" src="picture/right-arrowblack.png"></a>
                                <ul class="main-navigation">
                                  @for($j=0;$j<count($chapther_list);$j++)
                                    @if($subject_list["$i"]["id"] == $chapther_list["$j"]["subject_id"])
                                        <li class="list"><a class="a" href="/selectchapter/{{$subject_list["$i"]["id"]}}/{{$chapther_list["$j"]["id"]}}">{{$chapther_list["$j"]["name"]}}</a></li>
                                    @endif
                                  @endfor
                                </ul>
                              </li>
                          </ul>
                      @endfor

                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <ul class="cd-accordion-menu">
                        <li class="has-children">
                            <input type="checkbox" name="group-2" id="group-2">
                                <label class="sidenavImgLogo" for="group-2">
                                  @for($i=0;$i<$count;$i++)
                                  @if($choosechild == $childdata[$i]["line_code"])
                                    <img class="avata" src="{{$childdata["$i"]["local_pic"]}}">
                                    <p>{{$childdata["$i"]["name"]}}</p>
                                    @endif
                                  @endfor
                                    <img class="dropdownicon" src="picture/down-arrowblack.png">
                                </label>
                              <ul>
                                  <li class="has-children">
                                    @for($i=0;$i<$count;$i++)
                                      <a class="backgroundsub" href="/choosechild/{{$childdata["$i"]["line_code"]}}">{{$childdata["$i"]["name"]}}</a>
                                    @endfor
                                    <a class="backgroundsub" onclick="document.getElementById('addPop').style.display='block'">
                                        <img class="avata" src="picture/plusffff.png">
                                    </a>

                                  </li>
                                  <!-- <li class="has-children">
                                    <a class="backgroundsub" href="#ggo">oat</a>
                                  </li> -->
                            </ul>
                        </li>
                        <li class="has-children">
                            <input type="checkbox" name="group-1" id="group-1">
                            <label class="sidenavLabel" for="group-1">เปลี่ยนวิชา <img class="dropdownicon" src="picture/down-arrowblack.png"></label>

                              <ul>
                                  <li class="has-children">
                                      <input type="checkbox" name="sub-group-1" id="sub-group-1">
                                    <label class="backgroundsub sidenavLabel" for="sub-group-1">ภาษาอังกฤษ <img class="dropdownicon" src="picture/down-arrow.png"></label>

                                    <ul>
                                        <li class="backgroundsub2">
                                            <a href="#0">Grammar</a>
                                            <a href="#1">Listening</a>
                                        </li>
                                        <!-- <li class="backgroundsub2"><a href="#1">Listening</a></li> -->
                                    </ul>
                                  </li>
                                  <li class="has-children">
                                      <input type="checkbox" name="sub-group-2" id="sub-group-2">
                                    <label class="backgroundsub sidenavLabel" for="sub-group-2">คณิตศาสตร์ <img class="dropdownicon" src="picture/down-arrow.png"></label>

                                    <ul>
                                        <li class="backgroundsub2">
                                            <a href="#m1">สมการ</a>
                                            <a href="#m2">หรม./ครน.</a>
                                        </li>
                                        <!-- <li class="backgroundsub2"><a href="">หรม./ครน.</a></li> -->
                                    </ul>
                                  </li>
                            </ul>
                        </li>
                    </ul>
                <a href="/logout">Log out</a>
            </div>
            <div class="content">
                <h1 id="label">ทุกวิชา</h1>
                <div class="layoutContent">
                    <div id="pieChart">
                        <p>Pie Chart</p>
                        <canvas id="pieChart_subject"></canvas>
                    </div>
                    <div id="barChart">
                        <p>Bar Chart</p>
                        <canvas id="barChart_subject"></canvas>
                    </div>
                </div>
            </div>
            @include('inc.pop-up-addchild')
            @include('inc.footer')
        </div>

        <script type="text/javascript" src="js/progress.js"></script>

        @include('inc.script_overall')
        @include('inc.script_subject')
        @include('inc.script_chapter')

    </body>
</html>