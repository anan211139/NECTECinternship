<?php
  $choosechild = session('choosechild','default');
  $subject_list = session('subject_list', 'default');
  $chapther_list = session('chapter_list', 'default');
  $chapterCh =session('chapterCh','default');
  $choosechilddata =session('choosechilddata','default');
 ?>
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
                <button class="homeBtn" onclick = "window.location.href = '/dashboard';">
                    <img class="imgHome" src="picture/home.png">
                </button>
                <img class="profileImg" src="@if($choosechilddata[0]['local_pic']){{$choosechilddata[0]['local_pic']}}@else picture/bear_Nffff.png @endif">
                <p>{{$choosechilddata[0]['name']}}</p>
                <div class="layoutMenu">
                  @for($i=0;$i<count($subject_list);$i++)
                  <div class="head-menu" onclick = "window.location.href = '/selectsubject/{{$subject_list["$i"]["id"]}}';">
                    <a>{{$subject_list["$i"]["name"]}}</a>
                  </div>
                    <div class="menuBtn">
                      @for($j=0;$j<count($chapther_list);$j++)
                        @if($subject_list["$i"]["id"] == $chapther_list["$j"]["subject_id"])
                          <a href="/selectchapter/{{$subject_list["$i"]["id"]}}/{{$chapther_list["$j"]["id"]}}">{{$chapther_list["$j"]["name"]}}</a>
                        @endif
                      @endfor
                    </div>
                  @endfor
                    <a>ดูคะแนนรวม</a>
                    <div class="menuBtn">
                        <a href="/selectoverall/{{$choosechild}}">Overall</a>
                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav">
                <a onclick="closeNav()" class="close-btn">Close</a>
                <button class="homeBtn" onclick = "window.location.href = '/dashboard';">
                    <img class="imgHome" src="picture/home.png">
                </button>
                <img class="profileImg" src="@if($choosechilddata[0]['local_pic']){{$choosechilddata[0]['local_pic']}}@else picture/bear_Nffff.png @endif">
                <p>{{$choosechilddata[0]['name']}}</p>
                <div class="layoutMenu">
                  @for($i=0;$i<count($subject_list);$i++)
                    <a href="/selectsubject/{{$subject_list["$i"]["id"]}}">{{$subject_list["$i"]["name"]}}</a>
                    <div class="menuBtn">
                      @for($j=0;$j<count($chapther_list);$j++)
                        @if($subject_list["$i"]["id"] == $chapther_list["$j"]["subject_id"])
                        <a href="/selectchapter/{{$subject_list["$i"]["id"]}}/{{$chapther_list["$j"]["id"]}}">{{$chapther_list["$j"]["name"]}}</a>
                        @endif
                      @endfor
                    </div>
                  @endfor
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
                        <a class="name" href="/dashboard">{{session('name','default')}}</a>
                        <a href="/logout" class="navLogOut">ออกจากระบบ</a>
                    </div>
                </div>
                @if(session()->has('student_score_allsubject'))
                  @include('inc.pageoverall')
                @endif
                @if(session()->has('student_score'))
                  @include('inc.pagesubject')
                @endif
                @if(session()->has('student_score_chapter'))
                  @include('inc.pagechapter')
                @endif
    </body>
</html>
