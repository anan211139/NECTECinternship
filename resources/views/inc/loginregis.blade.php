<div id="loginPop" class="modal">
    <div class="modal-content animate">
        <div class="container">
            {!! Form::open(['url' => 'loginsubmitinaddchild']) !!}
                <p class="headRegis"><b>LOGIN</b></p>
                <label for="uname">Username</label>
                <input class="inputPop" type="text" name="uname" required>
                <label for="psw">Password</label>
                <input class="inputPop" type="password" name="pass" required>
                <div class="popBtnLayout">
                    <button class="registerBtn" type="submit">LOGIN</button>
                </div>  
                @include('inc.message')
                @include('inc.loginmessage')
            {!! Form::close() !!}
        </div>
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
                </div>  
            {!! Form::close() !!}
        </div>
    </div>
</div>