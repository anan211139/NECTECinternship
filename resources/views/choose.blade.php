<?php
  $childdata = session('childdata','default');
  $countchild = session('countchild','default');
 ?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="css/select.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body>
        <label class="header">กรุณาเลือกนักเรียน</label>
        <div class="layoutSelectPage">
          @if($countchild >0)
            <a href="choosechild/{{$childdata[0]["line_code"]}}">
                <img src="{{$childdata[0]["local_pic"]}}">
                <p>{{$childdata[0]["name"]}}</p>
            </a>
          @endif
          @if($countchild >1)
            <a href="choosechild/{{$childdata[1]["line_code"]}}">
                <img src="{{$childdata[1]["local_pic"]}}">
                <p>{{$childdata[1]["name"]}}</p>
            </a>
          @endif
          @if($countchild >2)
            <a href="choosechild/{{$childdata[2]["line_code"]}}">>
                <img src="{{$childdata[2]["local_pic"]}}">
                <p>{{$childdata[2]["name"]}}</p>
            </a>
          @endif
          @if($countchild >3)
            <a href="choosechild/{{$childdata[3]["line_code"]}}">>
                <img src="{{$childdata[3]["local_pic"]}}">
                <p>{{$childdata[3]["name"]}}</p>
            </a>
          @endif
        </div>
    </body>
</html>
