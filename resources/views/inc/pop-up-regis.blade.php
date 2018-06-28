<div id="id01" class="modal">
    <div class="modal-content animate">
        <div class="container">
            <p class="headRegis"><b>REGISTER</b></p>
            {!! Form::open(['url' => 'regissubmit']) !!}
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
                    <a class="cancelBtn" type="button" onclick="document.getElementById('id01').style.display='none'" 
                    class="cancelbtn">Cancel</a>
                </div>  
            {!! Form::close() !!}
        </div>
    </div>
</div>