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
                <div>
                    <a href="" class="layoutMenu">{{session('name','default')}}</a>
                    <a href="/logout" class="layoutMenu">Log out</a>
                </div>
            </div>
            <div>
                <img class="image" src="picture/bgwater.png">
            </div>
            <div class="content">
                <h1>เริ่มต้นใช้งาน</h1>
                <div class="layoutContentTutor">
                    <div>
                        <img class="imgContentTutor" src="picture/phone1.png">
                    </div>
                    <div class="layoutContentLeft">
                        <span class="button spanfont">Step 1</span>
                        <h2>แอด Line พี่หมีติวเตอร์</h2>
                        <p>โดยให้นักเรียน พิมพ์ <b>@พี่หมีติวเตอร์</b> ลงบนช่อง Search ของ Line แล้วกด ADD</p>
                        <p><b>* หากนักเรียนมี Line ของ พี่หมีติวเตอร์ อยู่แล้วข้ามไป Step 2</b></p>
                    </div>
                    <div class="layoutContentRight layoutContentBackground">
                        <span class="button spanfont">Step 2</span>
                        <h2>เข้าห้อง Chat ของ พี่หมีติวเตอร์</h2>
                        <p>คลิกบริเวณ <b>หมายเลข 2</b> เพื่อเข้าสู่ห้อง Chat ของ พี่หมีติวเตอร์</p>
                        <p>จาก Line ของนักเรียน</p>
                    </div>
                    <div class="layoutContentBackground">
                        <img class="imgContentTutor2" src="picture/phone2.png">
                    </div>
                    <div>
                        <img class="imgContentTutor2" src="picture/phone3.png">
                    </div>
                    <div class="layoutContentLeft">
                        <span class="button spanfont">Step 3</span>
                        <h2>ขอดู Code เพื่อนำมาเชื่อมต่อกับบุตรหลานของท่าน</h2>
                        <p>คลิกปุ่ม <b>ดู Code</b> บริเวณ <b>หมายเลข 3</b> หลังจากนั้นระบบจะทำการส่ง Code ให้ท่าน</p>
                    </div>
                    <div class="layoutContentRight layoutContentBackground">
                        <span class="button spanfont">Step 4</span>
                        <h2>คลิกลิงก์เพื่อเข้าสู่การเพิ่มนักเรียน</h2>
                        <p>คลิกบริเวณ <b>หมายเลข 4</b> เพื่อเข้าสู่หน้าเพิ่มนักเรียน</p>
                    </div>
                    <div class="layoutContentBackground">
                        <img class="imgContentTutor2" src="picture/phone4.png">
                    </div>
                    <div>
                        <img class="imgContentTutor2" src="picture/phone5.png">
                    </div>
                    <div class="layoutContentLeft">
                        <h2>หรือ Scan QR Code</h2>
                        <p>Scan QR Code บริเวณ <b>หมายเลข 5</b> เพื่อเข้าสู่หน้าเพิ่มนักเรียน</p>
                    </div>
                </div>
                @include('inc.footer')
            </div>


        <script type="text/javascript" src="js/tutorial.js"></script>
    </body>
</html>
