@extends('layout.app')
    @section('content')
        <div id="navbar">
            <a href="#home">Home</a>
        </div>
        <a href="#detail" class="plus"><img src="picture/arrow.png"></a>
        <div style='background-image: url("picture/bgfinal-01.png"); background-size: 100% auto; background-repeat: no-repeat; 
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
                    <input type="text" name="pass" required>
                    <button class="loginBtn">LOG IN</button>
                <!-- </form> -->
                {!! Form::close() !!}
                <a class="forgot" href="">Forgot Password?</a><br>
                <span>Don't have an account?</span>
                <a class="forgot" onclick="document.getElementById('id01').style.display='block'">Sign up</a>
                @include('inc.message')
            </div>
        </div>
        <div id="detail" class="detail">
            <div class="box">
                <iframe width="auto" height="auto" src="https://www.youtube.com/embed/Yad6t_EgwVw">
                </iframe>
                <p>dsagkljsdafgl;sdjaglkj</p>
                <p>dsagkljsdafgl;sdjaglkj</p>
                <p>dsagkljsdafgl;sdjaglkj</p>
                <p>dsagkljsdafgl;sdjaglkj</p>
                <p>dsagkljsdafgl;sdjaglkj</p>
            </div>
        </div>
        <!-- <img class="backgroundImg" src="background.png"> -->

        <!-- pop-up -->

        <div id="id01" class="modal">
        
        <div class="modal-content animate">
            <div class="container">
                <p class="headRegis"><b>REGISTER</b></p>
            {!! Form::open(['url' => 'regissubmit']) !!}
                <label for="uname">Username</label>
                <input class="inputPop" type="text" name="uname" required>
                <label for="psw">Password</label>
                <input class="inputPop" type="password" name="psw" required>
                <label for="psw">Re-Password</label>
                <input class="inputPop" type="password" name="repsw" required>  
                <label for="psw">E-mail</label>
                <input class="inputPop" type="email" name="email" required>
            <div class="popBtnLayout">
                <button class="registerBtn" type="submit">SUBMIT</button>
                <a class="cancelBtn" type="button" onclick="document.getElementById('id01').style.display='none'" 
                class="cancelbtn">Cancel</a>
            </div>  
            {!! Form::close() !!}
            </div>
        </div>
        </div>
@endsection