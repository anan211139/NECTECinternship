<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="css/add.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body style =
    "background-image: url('picture/boat.png');
    background-size: 100% auto;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: bottom right; 
    margin: 0;       
    background-color: #f7f7f7;  
    font-family: 'Prompt', sans-serif;">
        <div class="containerCode">
            <div class="content">
                <p class="headRegis"><b>เพิ่มนักเรียนในระบบ</b></p>
                @if(session('local_pic', 'default') != null)
                    <img class="logo" src= '{{session('local_pic', 'default')}}'>
                @else
                    <img class="logo" src= "picture/bear_N.png">
                @endif
            </div>
            <div class="content">
                {!! Form::open(['url' => 'addchildsubmit']) !!}
                    <input type="text" name="code" placeholder="code" value = "{{Session::get('line_code','default')}}" required>
                    <input type="text" name="nickname" placeholder="Nick name" required>
                    <button class="loginBtn" type="submit">ADD</button>
                {!! Form::close() !!}
            </div>
        </div>
        @if(session()->has('username'))
        @else
            @include('inc.loginregis')
        @endif
    </body>
</html>