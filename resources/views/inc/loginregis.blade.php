<div id="loginPop" class="modal">
    <div class="modal-content">
        <div class="container">
            {!! Form::open(['url' => 'loginsubmitinaddchild']) !!}
                <p class="headRegis">กรุณาลงชื่อเข้าใช้</p>
                @include('inc.loginmessage')
                <label for="uname">Username</label>
                <input class="inputPop" type="text" name="uname" required>
                <label for="psw">Password</label>
                <input class="inputPop" type="password" name="pass" required>
                <label>Don't have an account?</label>
                <a class="forgot" onclick="document.getElementById('regispop').style.display='block'">Sign up</a> 
                <div class="popBtnLayout">
                    <button class="registerBtn" type="submit">LOGIN</button>
                </div> 
                @include('inc.message')
            {!! Form::close() !!}
            
        </div>
    </div>
</div>
<div id="regispop" class="modal2">
    <div class="modal-content">
        <div class="container">
            {!! Form::open(['url' => 'regissubmitinaddchild']) !!}
                <p class="headRegis"><b>REGISTER</b></p>
                <label for="uname">Name</label>
                <input class="inputPop" type="text" name="nameRegis" required>
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
                    <a class = "cancal" onclick="document.getElementById('regispop').style.display='none'">Cancal</a>
                </div>  
            {!! Form::close() !!}
        </div>
    </div>
</div>