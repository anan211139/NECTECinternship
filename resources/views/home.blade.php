@extends('layout.app')
    @section('content')
    <div class="main-container">
        <div id="navbar">
            <div class="navLeft">
                <div><img class="logo" src="picture/bear_N.png"></div>
                <div class="logoBtn">พี่หมีติวเตอร์</div>
            </div>
            <div class="navRight">
                <a class="navLogin" href="#login">LOG IN</a>
                <a onclick="document.getElementById('id01').style.display='block'">Register</a>
            </div>
        </div>
        <a href="#detail" id ="arrowBtn"class="plus"><img id ="plus" src="picture/arrow.png"></a>
        <div id="login" style='background-image: url("picture/topbg.png"); background-size: 100% auto; background-repeat: no-repeat;
        background-position: bottom right;
        height: 100%; '>
            <div class="layout">
                <div class="pMhee">
                    <p class="fonts">ยินดีต้อนรับ เข้าสู่</p>
                    <p class="name"><strong>พี่หมีติวเตอร์</strong></p>
                </div>
                {!! Form::open(['url' => 'loginsubmit']) !!}
                <!-- <form action="/login"> -->
                    <p class="fonts2">Username</p>
                    <input type="text" name="uname" required>
                    <p class="fonts2">Password</p>
                    <input type="password" name="pass" required>
                    <button class="loginBtn">LOG IN</button>
                <!-- </form> -->
                {!! Form::close() !!}
                <a class="forgot" href="">Forgot Password?</a><br>
                <span>Don't have an account?</span>
                <a class="forgot" onclick="document.getElementById('id01').style.display='block'">Sign up</a>
                @include('inc.message')
                @include('inc.loginmessage')
            </div>
        </div>
        <div id="detail" class="detail">
            <div class="iconContainer">
                <div class="iconStyle">
                    <img class="icon" src="picture/1024px-LINE_logo.svg.png">
                    <p>สามารถเข้าถึงได้ด้วย LINE</p>
                </div>
                <div class="iconStyle">
                    <img class="icon" src="picture/noti.png">
                    <p>จะมีการส่งข้อความแจ้งเตือนให้น้องๆทำข้อสอบ</p>
                </div>
                <div class="iconStyle">
                    <img class="icon" src="picture/chart.png">
                    <p>สามารถติดตามผลได้จากกราฟ</p>
                </div>
            </div>
            <div class="box">
                <div class="topic">
                    <p><b>ABOUT</b></p>
                </div>
                <p> พี่หมีติวเตอร์  โปรเเกรมจำลองบทสนทนา หรือเรียกสั้นๆว่าเเชทบอท ซึ่งอยู่บน Line
                    ที่จะมาเป็นติวเตอร์ส่วนตัว ให้กับน้องๆ  โดยพี่หมีติวเตอร์สามารถส่งข้อความเเจ้งเตือน
                    ให้น้องๆมาทบทวนบทเรียน  ซึ่งน้องๆสามารถเลือกบทเรียนที่จะทบทวนได้  โดยจะมีการเก็บคะแนน
                    เพื่อนำมาแลกของรางวัล เพื่อเป็นเเรงจูงใจให้เด็กมีเป้าหมายในการทบทวน อีกทั้งมีการวัดระดับ
                    ความเข้าใจในบทเรียนนั้นๆ พร้อมทั้งนำเสนอผลคะเเนนออกมาเป็นกราฟเพื่อให้ ผู้ปกครองเเละ
                    คุณครูสามารถเห็นการพัฒนาของเด็ก</p>
            </div>
        </div>
        <div class="detail2">
            <img style="width: 100%;height: auto;" src="picture/lowbg.png">
        </div>
        <div class="detail3">
            <div class="layoutVideo">
                <div class="intrinsic-container intrinsic-container-16x9">
                    <iframe width="auto" height="auto" src="https://www.youtube.com/embed/Yad6t_EgwVw" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
        @include('inc.footer')
      </div>

        @include('inc.pop-up-regis')
@endsection
