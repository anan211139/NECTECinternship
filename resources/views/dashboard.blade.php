<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>พี่หมีติวเตอร์</title>
        <link rel="stylesheet" href="dashboard.css" />
        <link rel="stylesheet" href="footer.css" />
        <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Mitr|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <link rel="shortcut icon" href="picture/bear_N.png">
    </head>
    <body>
        <div class="main-container">
            <div id="navbar">
                <div class="navLeft">
                    <div><img class="logo" src="picture/bear_N.png"></div>
                    <div class="logoBtn">พี่หมีติวเตอร์</div>
                </div>
                <div class="navRight">
                    <a>สุพาพร</a>
                    <a class="navLogOut">ออกจากระบบ</a>
                </div>
            </div>
            <div class="section1">
                <div class="item colorGreen">
                    <label class="label">จำนวนนักเรียนในห้อง (คน)</label>
                    <div class="value">45</div>
                </div>
                <div class="item colorYellow">
                    <label class="label">ค่าเฉลี่ยของนักเรียนทั้งหมด</label>
                    <div class="layoutScore">
                        <div class="value">12.65</div>
                        <div class="smallLabel">/55</div>
                    </div>
                </div>
                <div class="item colorBlue">
                    <label class="label">อันดับของห้องเรียน</label>    
                    <div class="layoutScore">
                        <div class="value">1</div>
                        <div class="smallLabel">/10</div>
                    </div>
                </div>
            </div>
            <div class="section2">
                <div class="section2_1">
                    <div class="subSection1">
                        <h3 class="align-left">ข้อสอบทั้งหมด</h3>
                        <div class="barCon">
                            <p class="align-left label">ข้อสอบคณิตศาสตร์</p>
                            <div class="pro">
                                <div id="bar1" class="bar" style="background-color: #ff525b;"></div>
                            </div>
                            <label class="smallLabel">นักเรียนทำข้อสอบไปแล้ว 36 จาก 45 คน</label>
                        </div>
                        <div class="barCon">
                            <p class="align-left label">ข้อสอบภาษาอังกฤษ</p>
                            <div class="pro">
                                <div id="bar2" class="bar" style="background-color: #5fbddf;"></div>
                            </div>
                            <label class="smallLabel">นักเรียนทำข้อสอบไปแล้ว 21 จาก 45 คน</label>
                        </div>
                    </div> 
                </div>
                <div class="subSectionR">
                    <h3>ค่าเฉลี่ยรายวิชา</h3>
                    <div class="meanScore">
                        <div>
                            <label class="subjectIcon" style="background-color: #ff525b;">วิชาคณิตศาสตร์</label>
                            <div class="layoutScore">
                                <div class="value">12.65</div>
                                <div class="smallLabel">/55</div>
                            </div>
                            <label class="smallLabel">ทำแล้ว 36/55 คน</label>
                        </div>
                        <div>
                            <label class="subjectIcon" style="background-color: #5fbddf;">วิชาภาษาอังกฤษ</label>
                            <div class="layoutScore">
                                <div class="value">12.65</div>
                                <div class="smallLabel">/55</div>
                            </div>
                            <label class="smallLabel">ทำแล้ว 29/55 คน</label>
                        </div>
                    </div>                    
                        <!-- <div class="subSection1" style="margin-top: 1vw; padding-bottom: 22px;">
                            </div> -->  
                </div>
            </div>
            <div class="section3">
                <div class="subSection1 overflow">
                    <div class="headT">
                        <h3>รายชื่อนักเรียนทั้งหมด</h3>
                        <form class="searchCon">
                            <input type="text" name="search" placeholder="Search">
                            <button type="submit">ค้นหา</button>
                        </form>
                    </div>
                    <table id="student">
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">ชื่อ</th>   
                            <th colspan="2" scope="colgroup">ค่าเฉลี่ยรายวิชา</th>
                        </tr>
                        <tr>
                            <th scope="col">คณิตศาสตร์</th>
                            <th scope="col">ภาษาอังกฤษ</th>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                            
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                           
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                        <tr>
                            <td><img src="picture/c96f90063fe961d88c043faa29b545b6.jpg"></td>                            
                            <td>นาย ก</td>
                            <td>40.5</td>
                            <td>5.2</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <div class="footerCenter">
                    <div class="tooltip">
                        <img class="imgContact" src="picture/facebook-logo-button.png">
                        <span class="tooltiptext">พี่หมีติวเตอร์</span>
                    </div>
                    <div class="tooltip">
                        <img class="imgContact" src="picture/linefooter.png">
                        <span class="tooltiptext">@พี่หมีติวเตอร์</span>
                    </div>
                    <div class="tooltip">
                        <img class="imgContact" src="picture/web.png">
                        <span class="tooltiptext">www.พี่หมีติวเตอร์.com</span>
                    </div>
                </div>
                <div class="footerLeft">
                        <img class="nectecLogo" src="picture/Nectec_logo.png">
                </div>
            </div>
        </div>
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>