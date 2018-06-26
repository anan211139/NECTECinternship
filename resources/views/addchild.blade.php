<?php $username = Session::get('username','default'); ?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="css/add.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body>
        <div class="containerCode">
            <div class="content">
                <img class="logo" src="picture/bear_N.png">
            </div>
            <div  class="content">
            {!! Form::open(['url' => 'addchildsubmit']) !!}
                <input type="text" name="code" placeholder="Code" value = "{{session('code')}}" required>
                <input type="text" name="nickname" placeholder="Nickname" required>
                <button class="loginBtn" type="submit">ADD</button>
            {!! Form::close() !!}
            </div>
        </div>
        @if(isset($username))
            @include('inc.loginregis')
        @endif
        
    </body>
</html>