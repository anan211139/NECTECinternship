<?php
  $childdata = session('childdata','default');
  $choosechild = session('choosechild','default');
  $subject_list = session('subject_list', 'default');
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
                    <!-- namespace -->
                    @for($i=0;$i<count($subject_list);$i++)

                      @if($i == 0)
                        {{$subject_list["$i"]["subjects_name"]}}
                        @for($j=0;$j<count($subject_list);$j++)
                          @if($subject_list["$i"]["subjects_name"] == $subject_list["$j"]["subjects_name"])
                            {{$subject_list["$j"]["chapters_name"]}}
                          @endif
                        @endfor
                      @else
                        @for($k=0;$k<$i;$k++)
                          @if($subject_list["$k"]["subjects_name"] != $subject_list["$i"]["subjects_name"])
                            {{$subject_list["$i"]["subjects_name"]}}
                          @endif
                        @endfor
                      @endif

                    @endfor
                </div>
                <div class="dropdown">
                    <button onclick="dropdownFunction()" class="dropbtn">
                        <p>เปลียนวิชา</p>
                        <img class="dropdownicon" src="picture/down-arrowblack.png">
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <ul class="main-navigation" onmouseover="hover();" onmouseout="unhover();">
                            <li class="list"><a class="a">ภาษาอังกฤษ <img id="rightarrow" class="dropdownicon" src="picture/right-arrowblack.png"></a>
                              <ul class="main-navigation">
                                <li class="list"><a class="a" href="#Grammar">Grammar</a></li>
                                <li class="list"><a class="a" href="#Listening">Listening</a></li>
                              </ul>
                            </li>
                        </ul>
                        <ul class="main-navigation" onmouseover="hover2();" onmouseout="unhover2();">
                            <li class="list"><a class="a">คณิตศาสตร์ <img id="rightarrow2" class="dropdownicon" src="picture/right-arrowblack.png"></a>
                                <ul class="main-navigation">
                                  <li class="list"><a class="a">สมการ</a></li>
                                  <li class="list"><a class="a">หรม./ครน.</a></li>
                                </ul>
                            </li>
                        </ul>
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
                    </div>
                    <div id="barChart">
                        <p>Bar Chart</p>
                    </div>
                </div>
                <!-- <a class="button">จัดการข้อมูล</a>  -->
            </div>
            <div class="footer">
                <div class="footerCenter">
                    <div class="tooltip">
                        <img class="imgContact" src="picture/facebook-logo-button.png">
                        <span class="tooltiptext">พี่หมีติวเตอร์</span>
                    </div>
                    <div class="tooltip">
                        <img class="imgContact" src="picture/linefooter.png">
                        <span class="tooltiptext">@พี่หมีติวเตอร์</span>
                    </div>
                    <div class="tooltip">
                        <img class="imgContact" src="picture/web.png">
                        <span class="tooltiptext">www.พี่หมีติวเตอร์.com</span>
                    </div>
                </div>
                <div class="footerLeft">
                        <img class="nectecLogo" src="picture/Nectec_logo.png">
                </div>
            </div>


            <div id="addPop" class="modal">
                    <div class="modal-content animate" action="/action_page.php">
                        <div class="container">
                            <p class="headRegis"><b>เพิ่มนักเรียน</b></p>
                            <p>ท่านสามารถเพิ่มนักเรียนได้โดยรับลิ้งค์จากไลน์พี่หมีติวเตอร์</p>
                            <div class="popBtnLayout">
                                <button class="registerBtn" type="submit" onclick="document.getElementById('addPop').style.display='none'">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                @include('inc.footer')
        </div>

        <script type="text/javascript" src="js/progress.js"></script>
    </body>
</html>
